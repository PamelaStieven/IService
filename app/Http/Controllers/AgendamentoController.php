<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Tecnicos;
use App\Models\Servico;
use App\Models\Usuario;
use App\Models\Pagamento;
use App\Services\CalculadoraFinanceiraServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $colunasPermitidas = ['status_servico', 'data_hora_inicio', 'data_hora_fim', 'TecnicoID', 'ServicoID', 'UserID'];
        $tipo = $request->input('tipo', 'status_servico');
        if (!in_array($tipo, $colunasPermitidas, true)) {
            $tipo = 'status_servico';
        }
        //condição da consulta
        $dados = Agendamento::with(['tecnico.usuario', 'servico', 'usuario'])
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                $query->where($tipo, 'like', '%' . $valor . '%');
            })->get();

        return view('Agendamento.list', [
            'dados' => $dados,
            'tipo'  => $tipo,
            'valor' => $valor
        ]);
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function create()
    {
        $dado = new Agendamento();
        $tecnicos = Tecnicos::with('usuario')->get();
        $servicos = Servico::all();
        $usuarios = Usuario::all();
        return view('Agendamento.form', compact('dado', 'tecnicos', 'servicos', 'usuarios'));
    }

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'TecnicoID'        => 'required|exists:tecnicos,TecnicoID',
            'ServicoID'        => 'required|exists:servico,ServicoID',
            'UserID'           => 'required|exists:usuario,UserID',
            'data_hora_inicio' => 'required|date',
            'data_hora_fim'    => 'required|date|after:data_hora_inicio',
            'status_servico'   => 'required|in:Aceito,Pendente,Cancelado,Concluido',
            'metodo_pagamento' => 'required_if:status_servico,Concluido|nullable|in:PIX,Boleto',
        ], [
            'TecnicoID.required'        => 'Selecione um técnico.',
            'ServicoID.required'        => 'Selecione um serviço.',
            'UserID.required'              => 'Selecione o cliente/usuário.',
            'data_hora_inicio.required' => 'Informe a data/hora inicial.',
            'data_hora_fim.required'    => 'Informe a data/hora final.',
            'data_hora_fim.after'       => 'A data final deve ser posterior à inicial.',
            'status_servico.required'   => 'Informe o status do agendamento.',
            'metodo_pagamento.required_if' => 'Selecione o método de pagamento para concluir o serviço.',
            'metodo_pagamento.in' => 'Selecione PIX ou Boleto como método de pagamento.',
        ]);
    }

    public function store(Request $request, CalculadoraFinanceiraServico $calculadora)
    {
        $dados = $this->validateForm($request);

        DB::transaction(function () use ($dados, $calculadora) {
            if ($dados['status_servico'] !== 'Concluido') {
                $dados['metodo_pagamento'] = null;
            }

            $agendamento = Agendamento::create($dados);
            if ($agendamento->status_servico === 'Concluido') {
                $this->registrarPagamentoConclusao($agendamento, $calculadora);
            }
        });

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Agendamento::findOrFail($id);
        $tecnicos = Tecnicos::with('usuario')->get();
        $servicos = Servico::all();
        $usuarios = Usuario::all();
        return view('Agendamento.form', compact('dado', 'tecnicos', 'servicos', 'usuarios'));
    }

    public function show($id)
    {
        $agendamento = Agendamento::with(['tecnico.usuario', 'servico', 'usuario', 'pagamento'])
            ->findOrFail($id);

        return view('Agendamento.show', compact('agendamento'));
    }

    public function update(Request $request, $id, CalculadoraFinanceiraServico $calculadora)
    {
        $agendamento = Agendamento::findOrFail($id);
        if ($agendamento->status_servico === 'Concluido'
            && $request->input('status_servico') !== 'Concluido') {
            throw ValidationException::withMessages([
                'status_servico' => 'Um serviço concluído não pode ser reaberto.',
            ]);
        }

        if ($agendamento->status_servico === 'Concluido'
            && $request->input('metodo_pagamento') !== $agendamento->metodo_pagamento) {
            throw ValidationException::withMessages([
                'metodo_pagamento' => 'O método de pagamento de um serviço concluído só pode ser alterado no registro do pagamento.',
            ]);
        }

        $dados = $this->validateForm($request);
        if ($dados['status_servico'] !== 'Concluido') {
            $dados['metodo_pagamento'] = null;
        }

        $jaConcluido = $agendamento->status_servico === 'Concluido';
        DB::transaction(function () use ($agendamento, $dados, $calculadora, $jaConcluido) {
            $agendamento->update($dados);
            if ($agendamento->status_servico === 'Concluido' && !$jaConcluido) {
                $this->registrarPagamentoConclusao($agendamento, $calculadora);
            }
        });

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        if ($agendamento->status_servico === 'Concluido') {
            throw ValidationException::withMessages([
                'agendamento' => 'Um serviço concluído não pode ser excluído.',
            ]);
        }

        $agendamento->delete();

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento removido com sucesso!');
    }

    private function registrarPagamentoConclusao(
        Agendamento $agendamento,
        CalculadoraFinanceiraServico $calculadora
    ): void {
        $valores = $calculadora->calcular($agendamento);
        $pagamento = Pagamento::firstOrNew([
            'AgendamentoID' => $agendamento->AgendamentoID,
        ]);

        if (!$pagamento->exists) {
            $pagamento->status_pagamento = false;
            $pagamento->data_pagamento = now();
        }

        $pagamento->fill([
            'LocEquipID' => null,
            'metodo' => $agendamento->metodo_pagamento,
            'valor_total' => $valores['valor_total'],
            'taxa_site' => $valores['taxa_site'],
            'comissao_empresa' => $valores['comissao_empresa'],
        ])->save();
    }
}
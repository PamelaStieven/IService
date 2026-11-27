<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use App\Models\Agendamento;
use App\Models\LocacaoEquip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PagamentoController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $tipo  = $request->input('tipo', 'metodo');

        $colunasPermitidas = ['metodo', 'valor_total', 'taxa_site', 'status_pagamento', 'data_pagamento'];
        if (!in_array($tipo, $colunasPermitidas, true)) {
            $tipo = 'metodo';
        }

        $dados = Pagamento::with(['agendamento', 'locacaoEquip'])
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                $query->where($tipo, 'like', '%' . $valor . '%');
            })->get();

        return view('Pagamento.list', [
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
        $dado = new Pagamento();
        $agendamentos = Agendamento::all();
        $locacoes = LocacaoEquip::all();
        return view('Pagamento.form', compact('dado', 'agendamentos', 'locacoes'));
    }

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'AgendamentoID'    => 'nullable|exists:agendamento,AgendamentoID',
            'LocEquipID'       => 'nullable|exists:locacao_equips,LocEquipID',
            'metodo'           => 'required|in:PIX,Boleto',
            'valor_total'      => 'required|numeric|min:0',
            'taxa_site'        => 'required|numeric|min:0',
            'status_pagamento' => 'required|boolean',
            'data_pagamento'   => 'required|date',
        ], [
            'metodo.required'           => 'Selecione o método de pagamento.',
            'valor_total.required'      => 'O valor total é obrigatório.',
            'taxa_site.required'        => 'A taxa do site é obrigatória.',
            'status_pagamento.required' => 'O status do pagamento é obrigatório.',
            'data_pagamento.required'   => 'A :attribute do pagamento é obrigatória.',
        ]);
    }

    public function store(Request $request)
    {
        $dados = $this->validateForm($request);
        if (!empty($dados['AgendamentoID'])) {
            throw ValidationException::withMessages([
                'AgendamentoID' => 'O pagamento do serviço é gerado automaticamente ao concluí-lo.',
            ]);
        }

        Pagamento::create($dados);

        return redirect()->route('pagamentos.index')->with('success', 'Pagamento registrado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Pagamento::findOrFail($id);
        $agendamentos = Agendamento::all();
        $locacoes = LocacaoEquip::all();
        return view('Pagamento.form', compact('dado', 'agendamentos', 'locacoes'));
    }

    public function update(Request $request, $id)
    {
        $pagamento = Pagamento::findOrFail($id);
        $dados = $this->validateForm($request);

        if ((string) ($dados['AgendamentoID'] ?? '') !== (string) ($pagamento->AgendamentoID ?? '')
            || (string) ($dados['LocEquipID'] ?? '') !== (string) ($pagamento->LocEquipID ?? '')) {
            throw ValidationException::withMessages([
                'AgendamentoID' => 'A origem de um pagamento não pode ser alterada após o registro.',
            ]);
        }

        if ($pagamento->AgendamentoID) {
            $agendamento = Agendamento::with('servico')->findOrFail($pagamento->AgendamentoID);
            $dados['valor_total'] = $pagamento->valor_total;
            $dados['taxa_site'] = $pagamento->taxa_site;
            $dados['comissao_empresa'] = $pagamento->comissao_empresa;

            DB::transaction(function () use ($pagamento, $agendamento, $dados) {
                $pagamento->update($dados);
                $agendamento->update(['metodo_pagamento' => $dados['metodo']]);
            });
        } else {
            $pagamento->update($dados);
        }

        return redirect()->route('pagamentos.index')->with('success', 'Pagamento atualizado com sucesso!');
    }   

    public function destroy($id)
    {
        $pagamento = Pagamento::findOrFail($id);
        if ($pagamento->AgendamentoID) {
            throw ValidationException::withMessages([
                'pagamento' => 'O registro financeiro de um serviço concluído não pode ser excluído.',
            ]);
        }

        $pagamento->delete();

        return redirect()->route('pagamentos.index')->with('success', 'Pagamento removido com sucesso!');
    }
}
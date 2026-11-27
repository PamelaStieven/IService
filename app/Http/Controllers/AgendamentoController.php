<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Tecnicos;
use App\Models\Servico;
use App\Models\Usuario;
use Illuminate\Http\Request;

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
        ], [
            'TecnicoID.required'        => 'Selecione um técnico.',
            'ServicoID.required'        => 'Selecione um serviço.',
            'UserID.required'              => 'Selecione o cliente/usuário.',
            'data_hora_inicio.required' => 'Informe a data/hora inicial.',
            'data_hora_fim.required'    => 'Informe a data/hora final.',
            'data_hora_fim.after'       => 'A data final deve ser posterior à inicial.',
            'status_servico.required'   => 'Informe o status do agendamento.',
        ]);
    }

    public function store(Request $request)
    {
        Agendamento::create($this->validateForm($request));

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
        $agendamento = Agendamento::with(['tecnico.usuario', 'servico', 'usuario'])
            ->findOrFail($id);

        return view('Agendamento.show', compact('agendamento'));
    }

    public function update(Request $request, $id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->update($this->validateForm($request));

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Agendamento::destroy($id);

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento removido com sucesso!');
    }
}
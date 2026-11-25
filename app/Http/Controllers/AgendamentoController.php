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
        $tipo  = $request->input('tipo', 'status_servico');

        $dados = Agendamento::with(['tecnico.usuario', 'servico', 'usuario'])
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                $query->where($tipo, 'like', '%' . $valor . '%');
            })->get();

        return view('agendamento.list', [
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
        return view('agendamento.form', compact('dado', 'tecnicos', 'servicos', 'usuarios'));
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'TecnicoID'        => 'required|exists:Tecnicos,TecnicoID',
            'ServicoID'        => 'required|exists:Servico,ServicoID',
            'usuarioID'           => 'required|exists:usuario,usuarioID',
            'data_hora_inicio' => 'required|date',
            'data_hora_fim'    => 'required|date|after:data_hora_inicio',
            'status_servico'   => 'required|in:Aceito,Pendente,Cancelado,Concluído',
        ], [
            'TecnicoID.required'        => 'Selecione um técnico.',
            'ServicoID.required'        => 'Selecione um serviço.',
            'usuarioID.required'           => 'Selecione o cliente/usuário.',
            'data_hora_inicio.required' => 'Informe a data/hora inicial.',
            'data_hora_fim.required'    => 'Informe a data/hora final.',
            'data_hora_fim.after'       => 'A data final deve ser posterior à inicial.',
            'status_servico.required'   => 'Informe o status do agendamento.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        Agendamento::create($request->all());

        return redirect()->route('agendamento.index')->with('success', 'Agendamento criado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Agendamento::findOrFail($id);
        $tecnicos = Tecnicos::with('usuario')->get();
        $servicos = Servico::all();
        $usuarios = Usuario::all();
        return view('agendamento.form', compact('dado', 'tecnicos', 'servicos', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $agendamento = Agendamento::findOrFail($id);
        $agendamento->update($request->all());

        return redirect()->route('agendamento.index')->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Agendamento::destroy($id);

        return redirect()->route('agendamento.index')->with('success', 'Agendamento removido com sucesso!');
    }
}
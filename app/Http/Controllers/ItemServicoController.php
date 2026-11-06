<?php

namespace App\Http\Controllers;

use App\Models\ItemServico;
use App\Models\Agendamento;
use App\Models\Servico;
use Illuminate\Http\Request;

class ItemServicoController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $tipo  = $request->input('tipo', 'descricao_item');

        $dados = ItemServico::with(['agendamento', 'servico'])
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                $query->where($tipo, 'like', '%' . $valor . '%');
            })->get();

        return view('item_servico.list', [
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
        $dado = new ItemServico();
        $agendamentos = Agendamento::all();
        $servicos = Servico::all();
        return view('item_servico.form', compact('dado', 'agendamentos', 'servicos'));
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'AgendamentoID'  => 'required|exists:Agendamento,AgendaID',
            'ServicoID'      => 'required|exists:Servico,ServicoID',
            'descricao_item' => 'required|string',
            'data_item'      => 'required|date',
        ], [
            'AgendamentoID.required'  => 'Selecione um agendamento.',
            'ServicoID.required'      => 'Selecione um serviço.',
            'descricao_item.required' => 'A descrição do item é obrigatória.',
            'data_item.required'      => 'A data do item é obrigatória.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        ItemServico::create($request->all());

        return redirect()->route('item_servico.index')->with('success', 'Item de serviço salvo com sucesso!');
    }

    public function edit($id)
    {
        $dado = ItemServico::findOrFail($id);
        $agendamentos = Agendamento::all();
        $servicos = Servico::all();
        return view('item_servico.form', compact('dado', 'agendamentos', 'servicos'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $itemServico = ItemServico::findOrFail($id);
        $itemServico->update($request->all());

        return redirect()->route('item_servico.index')->with('success', 'Item de serviço atualizado com sucesso!');
    }

    public function destroy($id)
    {
        ItemServico::destroy($id);

        return redirect()->route('item_servico.index')->with('success', 'Item de serviço removido com sucesso!');
    }
}
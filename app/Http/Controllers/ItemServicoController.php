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
        $valor =$request->input('valor');
        $tipo  =$request->input('tipo', 'descricao_item');

        $colunasPermitidas = ['descricao_item', 'data_item'];
        if (!in_array($tipo, $colunasPermitidas, true)) {$tipo = 'descricao_item';
        }

        $dados = ItemServico::with(['agendamento', 'servico'])
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {$query->where($tipo, 'like', '\%' .$valor . '%');
            })
            ->orderByDesc('ItemServicoID')
            ->get();

        return view('ItemServico.list', [
            'dados' => $dados,
            'tipo'  => $tipo,
            'valor' => $valor,
        ]);
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function create()
    {
        $dado = new ItemServico();
        $agendamentos = Agendamento::all();$servicos = Servico::all();

        return view('ItemServico.form', compact('dado', 'agendamentos', 'servicos'));
    }

    private function validateForm(Request $request)
    {
        // Confirme se a tabela de agendamentos usa AgendamentoID ou AgendaID no banco
        $request->validate([
            'AgendamentoID'  => 'required|exists:agendamento,AgendamentoID',
            'ServicoID'      => 'required|exists:servico,ServicoID',
            'descricao_item' => 'required|string|max:1000',
            'data_item'      => 'required|date',
        ], [
            'AgendamentoID.required'  => 'Selecione um agendamento.',
            'AgendamentoID.exists'    => 'O agendamento selecionado é inválido.',
            'ServicoID.required'      => 'Selecione um serviço.',
            'ServicoID.exists'        => 'O serviço selecionado é inválido.',
            'descricao_item.required' => 'A descrição do item é obrigatória.',
            'data_item.required'      => 'A data do item é obrigatória.',
            'data_item.date'          => 'Informe uma data válida.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        ItemServico::create($request->only([
            'AgendamentoID',
            'ServicoID',
            'descricao_item',
            'data_item',
        ]));

        return redirect()
            ->route('itens-servico.index')
            ->with('success', 'Item de serviço salvo com sucesso!');
    }

    public function edit($id)
    {
        $dado = ItemServico::findOrFail($id);
        $agendamentos = Agendamento::all();$servicos = Servico::all();

        return view('ItemServico.form', compact('dado', 'agendamentos', 'servicos'));
    }

    public function update(Request $request,$id)
    {
        $this->validateForm($request);

        $itemServico = ItemServico::findOrFail($id);
        $itemServico->update($request->only([
            'AgendamentoID',
            'ServicoID',
            'descricao_item',
            'data_item',
        ]));

        return redirect()
            ->route('itens-servico.index')
            ->with('success', 'Item de serviço atualizado com sucesso!');
    }

    public function destroy($id)
    {
        ItemServico::destroy($id);

        return redirect()
            ->route('itens-servico.index')
            ->with('success', 'Item de serviço removido com sucesso!');
    }
}
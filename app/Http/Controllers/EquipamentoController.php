<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipamentos;
use App\Models\Usuario;

class EquipamentoController extends Controller
{
    public function index()
    {
        $dados = Equipamentos::with('usuario')->get();

        return view('equipamentos.list', compact('dados'));
    }

    public function create()
    {
        $usuarios = Usuario::all();

        return view('equipamentos.form', compact('usuarios'));
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'nome' => 'required|max:55',
            'modelo' => 'required|max:55',
            'descricao_tecnica' => 'required',
            'data_compra' => 'required|date',
            'valor_aluguel' => 'required|numeric|min:0',
            'status' => 'required|in:Alugado,Disponível',
        ], [
            'usuario_id.required' => 'O usuário é obrigatório.',
            'usuario_id.exists' => 'O usuário informado não existe.',
            'nome.required' => 'O nome é obrigatório.',
            'nome.max' => 'O nome deve ter no máximo 55 caracteres.',
            'modelo.required' => 'O modelo é obrigatório.',
            'modelo.max' => 'O modelo deve ter no máximo 55 caracteres.',
            'descricao_tecnica.required' => 'A descrição técnica é obrigatória.',
            'data_compra.required' => 'A data da compra é obrigatória.',
            'data_compra.date' => 'Informe uma data válida.',
            'valor_aluguel.required' => 'O valor do aluguel é obrigatório.',
            'valor_aluguel.numeric' => 'O valor deve ser numérico.',
            'valor_aluguel.min' => 'O valor não pode ser negativo.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Selecione um status válido.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        Equipamentos::create($request->only([
            'usuario_id',
            'nome',
            'modelo',
            'descricao_tecnica',
            'data_compra',
            'valor_aluguel',
            'status',
        ]));

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Equipamentos::findOrFail($id);
        $usuarios = Usuario::all();

        return view('equipamentos.form', compact('dado', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $equipamento = Equipamentos::findOrFail($id);

        $equipamento->update($request->only([
            'usuario_id',
            'nome',
            'modelo',
            'descricao_tecnica',
            'data_compra',
            'valor_aluguel',
            'status',
        ]));

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Equipamentos::destroy($id);

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento removido com sucesso!');
    }
}

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
            'UserID' => 'required|exists:usuario,UserID',
            'nome' => 'required|max:55',
            'modelo' => 'required|max:55',
            'descricao_tecnica' => 'required',
            'data_compra' => 'required|date',
            'valor_aluguel' => 'required|numeric|min:0',
            'status' => 'required|in:Alugado,Disponível',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        Equipamentos::create($request->only([
            'UserID',
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
        $dado = Equipamentos::where('EquipID', $id)->firstOrFail();
        $usuarios = Usuario::all();

        return view('equipamentos.form', compact('dado', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $equipamento = Equipamentos::where('EquipID', $id)->firstOrFail();

        $equipamento->update($request->only([
            'UserID',
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
        $equipamento = Equipamentos::where('EquipID', $id)->firstOrFail();
        $equipamento->delete();

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento removido com sucesso!');
    }
}
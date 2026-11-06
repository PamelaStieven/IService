<?php

namespace App\Http\Controllers;

use App\Models\LocacaoEquip;
use App\Models\Usuario;
use Illuminate\Http\Request;

class LocacaoEquipController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $tipo  = $request->input('tipo', 'UserID');

        $dados = LocacaoEquip::with('user')
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                if ($tipo === 'usuario') {
                    $query->whereHas('user', function ($q) use ($valor) {
                        $q->where('nome_razao', 'like', '%' . $valor . '%');
                    });
                } else {
                    $query->where($tipo, 'like', '%' . $valor . '%');
                }
            })->get();

        return view('locacao_equip.list', [
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
        $dado = new LocacaoEquip();
        $usuarios = Usuario::all();
        return view('locacao_equip.form', compact('dado', 'usuarios'));
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'UserID'         => 'required|exists:Usuario,UserID',
            'data_retirada'  => 'required|date',
            'data_devolucao' => 'required|date|after_or_equal:data_retirada',
        ], [
            'UserID.required'         => 'Selecione um usuário.',
            'data_retirada.required'  => 'A data de retirada é obrigatória.',
            'data_devolucao.required' => 'A data de devolução é obrigatória.',
            'data_devolucao.after_or_equal' => 'A devolução deve ser igual ou após a retirada.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        LocacaoEquip::create($request->all());

        return redirect()->route('locacao_equip.index')->with('success', 'Locação criada com sucesso!');
    }

    public function edit($id)
    {
        $dado = LocacaoEquip::findOrFail($id);
        $usuarios = Usuario::all();
        return view('locacao_equip.form', compact('dado', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $locacao = LocacaoEquip::findOrFail($id);
        $locacao->update($request->all());

        return redirect()->route('locacao_equip.index')->with('success', 'Locação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        LocacaoEquip::destroy($id);

        return redirect()->route('locacao_equip.index')->with('success', 'Locação removida com sucesso!');
    }
}
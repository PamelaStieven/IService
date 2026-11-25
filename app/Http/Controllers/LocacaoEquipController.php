<?php

namespace App\Http\Controllers;

use App\Models\LocacaoEquip;
use App\Models\Usuario;
use App\Models\Equipamentos;
use Illuminate\Http\Request;

class LocacaoEquipController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $tipo  = $request->input('tipo', 'UserID');

        $dados = LocacaoEquip::with(['usuario', 'pagamento'])
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                $query->where($tipo, 'like', '%' . $valor . '%');
            })
            ->orderByDesc('LocEquipID')
            ->get();

        return view('LocacaoEquip.list', compact('dados', 'tipo', 'valor'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function create()
    {
        $dado = new LocacaoEquip();
        $usuarios = Usuario::all();
        $equipamentos = Equipamentos::all();

        return view('LocacaoEquip.form', compact('dado', 'usuarios', 'equipamentos'));
    }

    private function validateForm(Request $request)
    {
        return $request->validate([
            'UserID'         => 'required|exists:usuario,UserID',
            'data_retirada'  => 'required|date',
            'data_devolucao' => 'nullable|date|after_or_equal:data_retirada',
        ], [
            'UserID.required'                  => 'Selecione o usuário.',
            'UserID.exists'                    => 'O usuário selecionado é inválido.',
            'data_retirada.required'           => 'A data da retirada é obrigatória.',
            'data_retirada.date'               => 'Informe uma data de retirada válida.',
            'data_devolucao.date'              => 'Informe uma data de devolução válida.',
            'data_devolucao.after_or_equal'    => 'A data da devolução deve ser igual ou posterior à data da retirada.',
        ]);
    }

    public function store(Request $request)
    {
        $dadosValidados = $this->validateForm($request);

        LocacaoEquip::create($dadosValidados);

        return redirect()
            ->route('locacoes-equipamentos.index')
            ->with('success', 'Locação cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $dado = LocacaoEquip::findOrFail($id);
        $usuarios = Usuario::all();
        $equipamentos = Equipamentos::all();

        return view('LocacaoEquip.form', compact('dado', 'usuarios', 'equipamentos'));
    }

    public function update(Request $request, $id)
    {
        $dadosValidados = $this->validateForm($request);

        $locacao = LocacaoEquip::findOrFail($id);
        $locacao->update($dadosValidados);

        return redirect()
            ->route('locacoes-equipamentos.index')
            ->with('success', 'Locação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $locacao = LocacaoEquip::findOrFail($id);
        $locacao->delete();

        return redirect()
            ->route('locacoes-equipamentos.index')
            ->with('success', 'Locação removida com sucesso!');
    }
}
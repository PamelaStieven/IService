<?php

namespace App\Http\Controllers;

use App\Models\Habilidade;
use App\Models\Tecnicos;
use Illuminate\Http\Request;

class HabilidadeController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $tipo  = $request->input('tipo', 'descricao');

        $dados = Habilidade::with('tecnico.user')
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                if ($tipo === 'tecnico') {
                    $query->whereHas('tecnico.user', function ($q) use ($valor) {
                        $q->where('nome_razao', 'like', '%' . $valor . '%');
                    });
                } else {
                    $query->where($tipo, 'like', '%' . $valor . '%');
                }
            })->get();

        return view('habilidade.list', [
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
        $dado = new Habilidade();
        $tecnicos = Tecnicos::with('user')->get();
        return view('habilidade.form', compact('dado', 'tecnicos'));
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'TecnicoID' => 'required|exists:Tecnicos,TecnicoID',
            'descricao' => 'required|string',
            'cursos'    => 'nullable',
        ], [
            'TecnicoID.required' => 'Selecione um técnico.',
            'descricao.required' => 'A descrição da habilidade é obrigatória.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        Habilidade::create($request->all());

        return redirect()->route('habilidade.index')->with('success', 'Habilidade salva com sucesso!');
    }

    public function edit($id)
    {
        $dado = Habilidade::findOrFail($id);
        $tecnicos = Tecnicos::with('user')->get();
        return view('habilidade.form', compact('dado', 'tecnicos'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $habilidade = Habilidade::findOrFail($id);
        $habilidade->update($request->all());

        return redirect()->route('habilidade.index')->with('success', 'Habilidade atualizada com sucesso!');
    }

    public function destroy($id)
    {
        Habilidade::destroy($id);

        return redirect()->route('habilidade.index')->with('success', 'Habilidade removida com sucesso!');
    }
}
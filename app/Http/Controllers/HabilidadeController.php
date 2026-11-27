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

        $dados = Habilidade::with('tecnico.usuario')
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                if ($tipo === 'tecnico') {
                    $query->whereHas('tecnico.usuario', function ($q) use ($valor) {
                        $q->where('nome_razao', 'like', '%' . $valor . '%');
                    });
                } else {
                    $query->where($tipo, 'like', '%' . $valor . '%');
                }
            })->get();

        return view('Habilidade.list', [
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
        $tecnicos = Tecnicos::with('usuario')->get();
        return view('Habilidade.form', compact('dado', 'tecnicos'));
    }

    private function validateForm(Request $request)
    {
        return $request->validate([
            'TecnicoID' => 'required|exists:tecnicos,TecnicoID',
            'descricao' => 'required|string',
            'cursos'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'TecnicoID.required' => 'Selecione um técnico.',
            'TecnicoID.exists'   => 'O técnico selecionado não foi encontrado.',
            'descricao.required' => 'A descrição da habilidade é obrigatória.',
        ]);
    }

    public function store(Request $request)
    {
        $dados = $this->validateForm($request);

        if ($request->hasFile('cursos')) {
            $dados['cursos'] = file_get_contents($request->file('cursos')->getRealPath());
        }
        Habilidade::create($dados);

        return redirect()->route('habilidades.index')->with('success', 'Habilidade salva com sucesso!');
    }

    public function edit($id)
    {
        $dado = Habilidade::findOrFail($id);
        $tecnicos = Tecnicos::with('usuario')->get();
        return view('Habilidade.form', compact('dado', 'tecnicos'));
    }

    public function update(Request $request, $id)
    {
        $habilidade = Habilidade::findOrFail($id);
        $dados = $this->validateForm($request);
        if ($request->hasFile('cursos')) {
            $dados['cursos'] = file_get_contents($request->file('cursos')->getRealPath());
        } else {
            unset($dados['cursos']);
        }
        $habilidade->update($dados);

        return redirect()->route('habilidades.index')->with('success', 'Habilidade atualizada com sucesso!');
    }

    public function destroy($id)
    {
        Habilidade::findOrFail($id)->delete();

        return redirect()->route('habilidades.index')->with('success', 'Habilidade removida com sucesso!');
    }
}
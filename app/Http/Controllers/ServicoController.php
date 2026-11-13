<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Tecnicos;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $tipo  = $request->input('tipo', 'titulo');

        $dados = Servico::with('tecnico.usuario')
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                if ($tipo === 'tecnico') {
                    $query->whereHas('tecnico.usuario', function ($q) use ($valor) {
                        $q->where('nome_razao', 'like', '%' . $valor . '%');
                    });
                } else {
                    $query->where($tipo, 'like', '%' . $valor . '%');
                }
            })->get();

        return view('servico.list', [
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
        $dado = new Servico();
        $tecnicos = Tecnicos::with('usuario')->get();
        return view('servico.form', compact('dado', 'tecnicos'));
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'TecnicoID'  => 'required|exists:Tecnicos,TecnicoID',
            'titulo'     => 'required|string|max:55',
            'categoria'  => 'required|string|max:55',
            'descricao'  => 'nullable|string',
            'preco_base' => 'required|numeric|min:0',
            'tipo_preco' => 'required|in:hora,Por Serviço',
        ], [
            'TecnicoID.required'  => 'Selecione um técnico.',
            'TecnicoID.exists'    => 'Técnico selecionado é inválido.',
            'titulo.required'     => 'O título do serviço é obrigatório.',
            'categoria.required'  => 'A categoria é obrigatória.',
            'preco_base.required' => 'Informe o preço base.',
            'preco_base.numeric'  => 'Informe um preço válido.',
            'tipo_preco.required' => 'Selecione o tipo de preço.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        Servico::create($request->all());

        return redirect()->route('servico.index')->with('success', 'Serviço cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Servico::findOrFail($id);
        $tecnicos = Tecnicos::with('usuario')->get();
        return view('servico.form', compact('dado', 'tecnicos'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $servico = Servico::findOrFail($id);
        $servico->update($request->all());

        return redirect()->route('servico.index')->with('success', 'Serviço atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Servico::destroy($id);

        return redirect()->route('servico.index')->with('success', 'Serviço removido com sucesso!');
    }
}
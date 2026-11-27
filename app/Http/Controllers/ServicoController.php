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

        if (!in_array($tipo, ['titulo', 'categoria', 'tecnico'], true)) {
            $tipo = 'titulo';
        }

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

        return view('Servico.list', [
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
        return view('Servico.form', compact('dado', 'tecnicos'));
    }

    private function validateForm(Request $request)
    {
        return $request->validate([
            'TecnicoID'  => 'required|exists:tecnicos,TecnicoID',
            'titulo'     => 'required|string|max:100',
            'categoria'  => 'required|string|max:55',
            'descricao'  => 'nullable|string',
            'preco_base' => 'required|numeric|min:0',
            'tipo_preco' => 'required|in:Hora,Por Serviço',
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
        Servico::create($this->validateForm($request));

        return redirect()->route('servicos.index')->with('success', 'Serviço cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Servico::findOrFail($id);
        $tecnicos = Tecnicos::with('usuario')->get();
        return view('Servico.form', compact('dado', 'tecnicos'));
    }

    public function update(Request $request, $id)
    {
        $servico = Servico::findOrFail($id);
        $servico->update($this->validateForm($request));

        return redirect()->route('servicos.index')->with('success', 'Serviço atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Servico::destroy($id);

        return redirect()->route('servicos.index')->with('success', 'Serviço removido com sucesso!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enderecos;

class EnderecosController extends Controller
{
    public function index()
    {
        $dados = Enderecos::all();

        return view('enderecos.list', compact('dados'));
    }

    public function create()
    {
        return view('enderecos.form');
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'apelido' => 'required',
            'rua'     => 'required',
            'numero'  => 'required',
            'bairro'  => 'required',
            'cep'     => 'required',
            'cidade'  => 'required',
            'estado'  => 'required',
            'pais'    => 'required',
            'usuario_id' => 'required|exists:usuario,id',
        ], [
            'apelido.required' => 'O apelido é obrigatório.',
            'rua.required'     => 'A rua é obrigatória.',
            'numero.required'  => 'O número é obrigatório.',
            'bairro.required'  => 'O bairro é obrigatório.',
            'cep.required'     => 'O CEP é obrigatório.',
            'cidade.required'  => 'A cidade é obrigatória.',
            'estado.required'  => 'O estado é obrigatório.',
            'pais.required'    => 'O país é obrigatório.',
            'usuario_id.required' => 'O usuário é obrigatório.',
            'usuario_id.exists' => 'O usuário informado não existe.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        Enderecos::create($request->all());

        return redirect()->route('enderecos.index')
            ->with('success', 'Registro salvo com sucesso!');
    }

    public function edit($id)
    {
        $dado = Enderecos::findOrFail($id);

        return view('enderecos.form', compact('dado'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $enderecos = Enderecos::findOrFail($id);
        $enderecos->update($request->all());

        return redirect()->route('enderecos.index')
            ->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Endereco::destroy($id);

        return redirect()->route('enderecos.index')
            ->with('success', 'Registro removido com sucesso!');
    }
}

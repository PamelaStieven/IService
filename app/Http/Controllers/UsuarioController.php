<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        
        return view('Usuario.list', compact('usuarios'));
    }

    public function create()
    {
        $dado = new Usuario();
        return view('usuario.form', compact('dado'));
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'nome_razao'      => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'telefone'        => 'required|string|max:20',
            'tipo'            => 'required|string|max:50',
            'cpf_cnpj'        => 'required|string|max:14',
            'data_nascimento' => 'required|date',
        ], [
            'nome_razao.required'      => 'O campo nome é obrigatório.',
            'email.required'           => 'O campo e-mail é obrigatório.',
            'email.email'              => 'Informe um e-mail válido.',
            'telefone.required'       => 'O campo telefone é obrigatório.',
            'tipo.required'           => 'O campo tipo é obrigatório.',
            'cpf_cnpj.required'       => 'O campo CPF/CNPJ é obrigatório.',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
            'data_nascimento.date'     => 'Informe uma data válida.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        Usuario::create($request->all());

        return redirect()->route('usuario.index')->with('success', 'Registro salvo com sucesso!');
    }

    public function edit($id)
    {
        $dado = Usuario::findOrFail($id);
        return view('usuario.form', compact('dado'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $usuario = Usuario::findOrFail($id);
        $usuario->update($request->all());

        return redirect()->route('usuario.index')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Usuario::destroy($id);

        return redirect()->route('usuario.index')->with('success', 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        $termo = $request->input('termo');

        $usuarios = Usuario::where('nome_razao', 'LIKE', "%{$termo}%")
                           ->orWhere('email', 'LIKE', "%{$termo}%")
                           ->orWhere('cpf_cnpj', 'LIKE', "%{$termo}%")
                           ->get();

        return view('usuarios.list', compact('usuarios', 'termo'));
    }
}
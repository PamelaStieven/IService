<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TecnicoController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $tipo  = $request->input('tipo', 'nome_razao');

        $dados = Tecnico::with('user')
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                if (in_array($tipo, ['nome_razao', 'email', 'cpf_cnpj', 'telefone'])) {
                    $query->whereHas('user', function ($q) use ($tipo, $valor) {
                        $q->where($tipo, 'like', '%' . $valor . '%');
                    });
                } else {
                    $query->where($tipo, 'like', '%' . $valor . '%');
                }
            })->get();

        return view('tecnico.list', [
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
        $dado = new Tecnico();
        return view('tecnico.form', compact('dado'));
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'nome_razao'      => 'required|string|max:55',
            'email'           => 'required|email|max:55',
            'cpf_cnpj'        => 'required|string|max:18',
            'telefone'        => 'nullable|string|max:14',
            'data_nascimento' => 'nullable|date',
            'documento'       => 'nullable',
        ], [
            'nome_razao.required' => 'O campo nome é obrigatório.',
            'email.required'      => 'O campo e-mail é obrigatório.',
            'email.email'         => 'Informe um e-mail válido.',
            'cpf_cnpj.required'   => 'O campo CPF/CNPJ é obrigatório.',
            'data_nascimento.date'=> 'Informe uma data válida.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'nome_razao'      => $request->input('nome_razao'),
                'email'           => $request->input('email'),
                'cpf_cnpj'        => $request->input('cpf_cnpj'),
                'data_nascimento' => $request->input('data_nascimento'),
                'telefone'        => $request->input('telefone'),
                'tipo'            => 'Técnico',
            ]);

            Tecnico::create([
                'UserID'    => $user->UserID,
                'documento' => $request->input('documento'),
            ]);
        });

        return redirect()->route('tecnico.index')->with('success', 'Técnico salvo com sucesso!');
    }

    public function edit($id)
    {
        $dado = Tecnico::with('user')->findOrFail($id);
        return view('tecnico.form', compact('dado'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $tecnico = Tecnico::findOrFail($id);

        DB::transaction(function () use ($request, $tecnico) {
            $tecnico->user->update([
                'nome_razao'      => $request->input('nome_razao'),
                'email'           => $request->input('email'),
                'cpf_cnpj'        => $request->input('cpf_cnpj'),
                'data_nascimento' => $request->input('data_nascimento'),
                'telefone'        => $request->input('telefone'),
            ]);

            $tecnico->update([
                'documento' => $request->input('documento'),
            ]);
        });

        return redirect()->route('tecnico.index')->with('success', 'Técnico atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $tecnico = Tecnico::findOrFail($id);

        DB::transaction(function () use ($tecnico) {
            $user = $tecnico->user;
            
            $tecnico->delete(); 
            if ($user) {
                $user->delete(); 
            }
        });

        return redirect()->route('tecnico.index')->with('success', 'Técnico removido com sucesso!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\DadosBancarios;
use App\Models\Tecnicos;
use Illuminate\Http\Request;

class DadosBancariosController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $tipo  = $request->input('tipo', 'banco');

        $dados = DadosBancarios::with('tecnico.user')
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                if ($tipo === 'tecnico') {
                    $query->whereHas('tecnico.user', function ($q) use ($valor) {
                        $q->where('nome_razao', 'like', '%' . $valor . '%');
                    });
                } else {
                    $query->where($tipo, 'like', '%' . $valor . '%');
                }
            })->get();

        return view('dados_bancarios.list', [
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
        $dado = new DadosBancarios();
        $tecnicos = Tecnicos::with('user')->get();
        return view('dados_bancarios.form', compact('dado', 'tecnicos'));
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'TecnicoID'        => 'required|exists:Tecnicos,TecnicoID',
            'banco'            => 'required|string|max:55',
            'agencia'          => 'required|string|max:6',
            'numero_conta'     => 'required|string|max:16',
            'tipo_conta'       => 'required|integer',
            'titular'          => 'required|string|max:55',
            'cpf_cnpj_titular' => 'required|string|max:18',
        ], [
            'TecnicoID.required'        => 'Selecione um técnico.',
            'banco.required'            => 'O campo banco é obrigatório.',
            'agencia.required'          => 'O campo agência é obrigatório.',
            'numero_conta.required'     => 'O campo número da conta é obrigatório.',
            'tipo_conta.required'       => 'O tipo de conta é obrigatório.',
            'titular.required'          => 'O titular é obrigatório.',
            'cpf_cnpj_titular.required' => 'O CPF/CNPJ do titular é obrigatório.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        DadosBancarios::create($request->all());

        return redirect()->route('dados_bancarios.index')->with('success', 'Dados bancários salvos com sucesso!');
    }

    public function edit($id)
    {
        $dado = DadosBancarios::findOrFail($id);
        $tecnicos = Tecnicos::with('user')->get();
        return view('dados_bancarios.form', compact('dado', 'tecnicos'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $dadosBancarios = DadosBancarios::findOrFail($id);
        $dadosBancarios->update($request->all());

        return redirect()->route('dados_bancarios.index')->with('success', 'Dados bancários atualizados com sucesso!');
    }

    public function destroy($id)
    {
        DadosBancarios::destroy($id);

        return redirect()->route('dados_bancarios.index')->with('success', 'Dados bancários removidos com sucesso!');
    }
}
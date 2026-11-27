<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enderecos;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class EnderecosController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $tipo = $request->input('tipo', 'cidade');
        if (!in_array($tipo, ['apelido', 'rua', 'bairro', 'cep', 'cidade', 'estado', 'pais'], true)) {
            $tipo = 'cidade';
        }

        $dados = Enderecos::with('usuario')
            ->when($valor !== null && $valor !== '', function ($query) use ($tipo, $valor) {
                $query->where($tipo, 'like', '%' . $valor . '%');
            })
            ->get();

        return view('enderecos.list', compact('dados', 'valor', 'tipo'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function create()
    {
        $dado = new Enderecos();
        $usuarios = Usuario::all();

        return view('enderecos.form', compact('dado', 'usuarios'));
    }

    public function usuarioIndex(Request $request, $usuarioId)
    {
        $usuario = Usuario::whereIn('tipo', ['Administrador', 'Usuário'])->findOrFail($usuarioId);
        $valor = $request->input('valor');
        $tipo = $request->input('tipo', 'cidade');
        $colunasPermitidas = ['apelido', 'rua', 'bairro', 'cep', 'cidade', 'estado', 'pais'];
        if (!in_array($tipo, $colunasPermitidas, true)) {
            $tipo = 'cidade';
        }

        $dados = $usuario->enderecos()
            ->with('usuario')
            ->when($valor !== null && $valor !== '', function ($query) use ($tipo, $valor) {
                $query->where($tipo, 'like', '%' . $valor . '%');
            })
            ->get();

        return view('enderecos.list', compact('dados', 'valor', 'tipo', 'usuario'));
    }

    public function usuarioCreate($usuarioId)
    {
        $usuario = Usuario::whereIn('tipo', ['Administrador', 'Usuário'])->findOrFail($usuarioId);
        $dado = new Enderecos();
        $usuarios = collect([$usuario]);

        return view('enderecos.form', compact('dado', 'usuarios', 'usuario'));
    }

    public function usuarioStore(Request $request, $usuarioId)
    {
        $usuario = Usuario::whereIn('tipo', ['Administrador', 'Usuário'])->findOrFail($usuarioId);
        $validated = $this->validateAddressFields($request);
        $validated['userID'] = $usuario->UserID;
        Enderecos::create($validated);

        return redirect()->route('usuario.enderecos.index', $usuario->UserID)
            ->with('success', 'Endereço cadastrado para ' . $usuario->nome_razao . '.');
    }

    private function validateAddressFields(Request $request): array
    {
        return $request->validate([
            'apelido' => 'required|string|max:55',
            'rua'     => 'required|string|max:55',
            'numero'  => 'required|integer',
            'bairro'  => 'required|string|max:55',
            'cep'     => 'required|string|max:11',
            'cidade'  => 'required|string|max:55',
            'estado'  => 'required|string|max:55',
            'pais'    => 'required|string|max:55',
        ], [
            'apelido.required' => 'O apelido é obrigatório.',
            'rua.required'     => 'A rua é obrigatória.',
            'numero.required'  => 'O número é obrigatório.',
            'numero.integer'   => 'Informe um número de endereço válido.',
            'bairro.required'  => 'O bairro é obrigatório.',
            'cep.required'     => 'O CEP é obrigatório.',
            'cidade.required'  => 'A cidade é obrigatória.',
            'estado.required'  => 'O estado é obrigatório.',
            'pais.required'    => 'O país é obrigatório.',
        ]);
    }

    private function validateForm(Request $request): array
    {
        $validated = $this->validateAddressFields($request);
        $validated['userID'] = $request->validate([
            'UserID' => 'required|exists:usuario,UserID',
        ], [
            'UserID.required' => 'O usuário é obrigatório.',
            'UserID.exists'   => 'O usuário informado não existe.',
        ])['UserID'];

        return $validated;
    }

    public function store(Request $request)
    {
        Enderecos::create($this->validateForm($request));

        return redirect()->route('enderecos.index')
            ->with('success', 'Registro salvo com sucesso!');
    }

    public function edit($id)
    {
        $dado = Enderecos::findOrFail($id);

        $usuarios = Usuario::all();

        return view('enderecos.form', compact('dado', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $enderecos = Enderecos::findOrFail($id);
        $enderecos->update($this->validateForm($request));

        return redirect()->route('enderecos.index')
            ->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Enderecos::findOrFail($id)->delete();

        return redirect()->route('enderecos.index')
            ->with('success', 'Registro removido com sucesso!');
    }

    public function clienteIndex()
    {
        $enderecos = Auth::user()->enderecos()->orderBy('apelido')->get();
        $dado = new Enderecos();

        return view('enderecos.cliente', compact('enderecos', 'dado'));
    }

    public function clienteEdit($id)
    {
        $dado = $this->findClienteAddress($id);
        $enderecos = Auth::user()->enderecos()->orderBy('apelido')->get();

        return view('enderecos.cliente', compact('enderecos', 'dado'));
    }

    public function clienteStore(Request $request)
    {
        $validated = $this->validateAddressFields($request);
        $validated['userID'] = Auth::user()->UserID;
        Enderecos::create($validated);

        return redirect()->route('cliente.enderecos.index')
            ->with('success', 'Endereço adicionado com sucesso.');
    }

    public function clienteUpdate(Request $request, $id)
    {
        $dado = $this->findClienteAddress($id);
        $dado->update($this->validateAddressFields($request));

        return redirect()->route('cliente.enderecos.index')
            ->with('success', 'Endereço atualizado com sucesso.');
    }

    public function clienteDestroy($id)
    {
        $this->findClienteAddress($id)->delete();

        return redirect()->route('cliente.enderecos.index')
            ->with('success', 'Endereço removido com sucesso.');
    }

    private function findClienteAddress($id): Enderecos
    {
        return Enderecos::where('userID', Auth::user()->UserID)->findOrFail($id);
    }
}

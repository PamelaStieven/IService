<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuario = Usuario::whereIn('tipo', ['Administrador', 'Usuário'])->get();
        
        return view('Usuario.list', compact('usuario'));
    }

    public function create()
    {
        $usuario = new Usuario();
        return view('Usuario.form', compact('usuario'));
    }

    private function validateForm(Request $request, ?Usuario $usuario = null): array
    {
        return $request->validate([
            'nome_razao'      => 'required|string|max:55',
            'email'           => $usuario
                ? ['required', 'email', 'max:55', Rule::unique('usuario', 'email')->ignore($usuario->UserID, 'UserID')]
                : 'required|email|max:55|unique:usuario,email',
            'telefone'        => 'required|string|max:14',
            'tipo'            => $usuario && $usuario->tipo === 'Técnico'
                ? 'prohibited'
                : 'required|in:Administrador,Usuário',
            'cpf_cnpj'        => $usuario
                ? ['required', 'string', 'max:18', Rule::unique('usuario', 'cpf_cnpj')->ignore($usuario->UserID, 'UserID')]
                : 'required|string|max:18|unique:usuario,cpf_cnpj',
            'data_nascimento' => 'required|date',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'password'        => $usuario ? 'nullable|string|min:6|confirmed' : 'required|string|min:6|confirmed',
        ], [
            'nome_razao.required'      => 'O campo nome é obrigatório.',
            'email.required'           => 'O campo e-mail é obrigatório.',
            'email.email'              => 'Informe um e-mail válido.',
            'telefone.required'       => 'O campo telefone é obrigatório.',
            'tipo.required'           => 'O campo tipo é obrigatório.',
            'cpf_cnpj.required'       => 'O campo CPF/CNPJ é obrigatório.',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
            'data_nascimento.date'     => 'Informe uma data válida.',
            'password.required'       => 'A senha é obrigatória para novos usuários.',
            'password.min'            => 'A senha deve conter no mínimo 6 caracteres.',
            'password.confirmed'      => 'A confirmação de senha não confere.',
        ]);
    }

    public function store(Request $request)
    {
        $dados = $this->validateForm($request);
        $dados['password'] = Hash::make($dados['password']);
        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('fotos/usuarios', 'public');
            if (!$foto) {
                return back()->withInput()->withErrors([
                    'foto' => 'Não foi possível salvar a foto. Tente novamente.',
                ]);
            }
        }
        unset($dados['foto']);
        $dados['foto'] = $foto;

        try {
            Usuario::create($dados);
        } catch (\Throwable $exception) {
            if ($foto) {
                Storage::disk('public')->delete($foto);
            }

            throw $exception;
        }

        return redirect()->route('usuario.index')->with('success', 'Registro salvo com sucesso!');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('Usuario.form', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $dados = $this->validateForm($request, $usuario);
        $fotoAnterior = $usuario->foto;
        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('fotos/usuarios', 'public');
            if (!$foto) {
                return back()->withInput()->withErrors([
                    'foto' => 'Não foi possível salvar a foto. Tente novamente.',
                ]);
            }
            $dados['foto'] = $foto;
        } else {
            unset($dados['foto']);
        }

        if (!empty($dados['password'])) {
            $dados['password'] = Hash::make($dados['password']);
        } else {
            unset($dados['password']);
        }

        try {
            $usuario->update($dados);
        } catch (\Throwable $exception) {
            if ($foto) {
                Storage::disk('public')->delete($foto);
            }

            throw $exception;
        }
        if ($foto && $fotoAnterior) {
            Storage::disk('public')->delete($fotoAnterior);
        }

        return redirect()->route('usuario.index')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $foto = $usuario->foto;
        $usuario->delete();
        if ($foto) {
            Storage::disk('public')->delete($foto);
        }

        return redirect()->route('usuario.index')->with('success', 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        $termo = $request->input('termo');

        $usuario = Usuario::whereIn('tipo', ['Administrador', 'Usuário'])
            ->where(function ($query) use ($termo) {
                $query->where('nome_razao', 'LIKE', "%{$termo}%")
                    ->orWhere('email', 'LIKE', "%{$termo}%")
                    ->orWhere('cpf_cnpj', 'LIKE', "%{$termo}%");
            })
            ->get();

        return view('Usuario.list', compact('usuario', 'termo'));
    }

    public function foto($id)
    {
        $usuario = Usuario::findOrFail($id);
        abort_unless($usuario->foto && Storage::disk('public')->exists($usuario->foto), 404);

        return response()->file(Storage::disk('public')->path($usuario->foto));
    }
}
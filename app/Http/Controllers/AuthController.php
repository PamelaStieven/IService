<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Tecnicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

#email: admin@iservice.com
#password: admin123

class AuthController extends Controller
{
    /**
     * Exibe a tela inicial (Landing Page com Login).
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }

        return view('auth.landing');
    }

    /**
     * Processa a autenticação do usuário.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Por favor, informe seu e-mail.',
            'email.email'       => 'Informe um endereço de e-mail válido.',
            'password.required' => 'Por favor, informe sua senha.',
        ]);

        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $usuario = Auth::user();

            return $this->redirectUserByRole($usuario)
                ->with('success', 'Olá, ' . $usuario->nome_razao . '! Bem-vindo(a) de volta.');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'As credenciais informadas estão incorretas.',
            ]);
    }

    /**
     * Realiza o logout do usuário.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Você encerrou sua sessão com segurança.');
    }

    /**
     * Exibe o formulário de cadastro público para Usuário (Cliente).
     */
    public function showRegisterUsuario()
    {
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }

        return view('auth.register-usuario');
    }

    /**
     * Processa o cadastro público de Usuário (Cliente).
     */
    public function registerUsuario(Request $request)
    {
        $request->validate([
            'nome_razao'      => 'required|string|max:55',
            'email'           => 'required|email|max:55|unique:usuario,email',
            'password'        => 'required|string|min:6|confirmed',
            'cpf_cnpj'        => 'required|string|max:18|unique:usuario,cpf_cnpj',
            'telefone'        => 'required|string|max:14',
            'data_nascimento' => 'required|date',
        ], [
            'nome_razao.required'      => 'O campo nome completo é obrigatório.',
            'email.required'           => 'O e-mail é obrigatório.',
            'email.email'              => 'Informe um e-mail válido.',
            'email.unique'             => 'Este e-mail já está cadastrado no sistema.',
            'password.required'        => 'A senha é obrigatória.',
            'password.min'             => 'A senha deve conter no mínimo 6 caracteres.',
            'password.confirmed'       => 'A confirmação de senha não confere.',
            'cpf_cnpj.required'        => 'O CPF/CNPJ é obrigatório.',
            'cpf_cnpj.unique'          => 'Este CPF/CNPJ já está cadastrado.',
            'telefone.required'        => 'O telefone é obrigatório.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date'     => 'Informe uma data válida.',
        ]);

        $usuario = Usuario::create([
            'nome_razao'      => $request->input('nome_razao'),
            'email'           => $request->input('email'),
            'password'        => Hash::make($request->input('password')),
            'cpf_cnpj'        => $request->input('cpf_cnpj'),
            'telefone'        => $request->input('telefone'),
            'data_nascimento' => $request->input('data_nascimento'),
            'tipo'            => 'Usuário',
        ]);

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('cliente.dashboard')
            ->with('success', 'Cadastro realizado com sucesso! Seja bem-vindo(a) ao IService.');
    }

    /**
     * Exibe o formulário de cadastro público para Técnico Parceiro.
     */
    public function showRegisterTecnico()
    {
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }

        return view('auth.register-tecnico');
    }

    /**
     * Processa o cadastro público de Técnico Parceiro.
     */
    public function registerTecnico(Request $request)
    {
        $request->validate([
            'nome_razao'      => 'required|string|max:55',
            'email'           => 'required|email|max:55|unique:usuario,email',
            'password'        => 'required|string|min:6|confirmed',
            'cpf_cnpj'        => 'required|string|max:18|unique:usuario,cpf_cnpj',
            'telefone'        => 'required|string|max:14',
            'data_nascimento' => 'required|date',
            'documento'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'nome_razao.required'      => 'O campo nome completo é obrigatório.',
            'email.required'           => 'O e-mail é obrigatório.',
            'email.email'              => 'Informe um e-mail válido.',
            'email.unique'             => 'Este e-mail já está cadastrado no sistema.',
            'password.required'        => 'A senha é obrigatória.',
            'password.min'             => 'A senha deve conter no mínimo 6 caracteres.',
            'password.confirmed'       => 'A confirmação de senha não confere.',
            'cpf_cnpj.required'        => 'O CPF/CNPJ é obrigatório.',
            'cpf_cnpj.unique'          => 'Este CPF/CNPJ já está cadastrado.',
            'telefone.required'        => 'O telefone é obrigatório.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date'     => 'Informe uma data válida.',
            'documento.file'           => 'O certificado deve ser um arquivo.',
            'documento.mimes'          => 'O certificado deve ser um arquivo PDF, JPG ou PNG.',
            'documento.max'            => 'O arquivo de certificado não pode ultrapassar 5 MB.',
        ]);

        DB::transaction(function () use ($request, &$usuario) {
            $usuario = Usuario::create([
                'nome_razao'      => $request->input('nome_razao'),
                'email'           => $request->input('email'),
                'password'        => Hash::make($request->input('password')),
                'cpf_cnpj'        => $request->input('cpf_cnpj'),
                'telefone'        => $request->input('telefone'),
                'data_nascimento' => $request->input('data_nascimento'),
                'tipo'            => 'Técnico',
            ]);

            $caminhoCertificado = null;
            if ($request->hasFile('documento')) {
                $caminhoCertificado = $request->file('documento')->store('certificados', 'public');
            }

            Tecnicos::create([
                'UserID'    => $usuario->UserID,
                'documento' => $caminhoCertificado,
            ]);
        });

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('tecnico.dashboard')
            ->with('success', 'Cadastro de técnico parceiro concluído! Bem-vindo(a) à plataforma IService.');
    }

    /**
     * Redireciona o usuário para o destino adequado de acordo com seu perfil.
     */
    private function redirectUserByRole($usuario)
    {
        if ($usuario->tipo === 'Administrador') {
            return redirect()->route('dashboard.graficos');
        } elseif ($usuario->tipo === 'Técnico') {
            return redirect()->route('tecnico.dashboard');
        } else {
            return redirect()->route('cliente.dashboard');
        }
    }
}

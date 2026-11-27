<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Tecnicos;
use App\Models\Enderecos;
use App\Models\DadosBancarios;
use App\Models\Habilidade;
use App\Rules\CpfCnpjValido;
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
        $dados = $request->validate([
            'nome_razao'      => 'required|string|max:55',
            'email'           => 'required|email|max:55|unique:usuario,email',
            'password'        => 'required|string|min:6|confirmed',
            'cpf_cnpj'        => 'required|string|max:18|unique:usuario,cpf_cnpj',
            'telefone'        => 'required|string|max:14',
            'data_nascimento' => 'required|date',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'apelido'         => 'required|string|max:55',
            'rua'             => 'required|string|max:55',
            'numero'          => 'required|integer',
            'bairro'          => 'required|string|max:55',
            'cep'             => 'required|string|max:11',
            'cidade'          => 'required|string|max:55',
            'estado'          => 'required|string|max:55',
            'pais'            => 'required|string|max:55',
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
            'apelido.required'         => 'Informe um nome para identificar o endereço.',
            'rua.required'             => 'A rua é obrigatória.',
            'numero.required'          => 'O número do endereço é obrigatório.',
            'numero.integer'           => 'Informe um número de endereço válido.',
            'bairro.required'          => 'O bairro é obrigatório.',
            'cep.required'             => 'O CEP é obrigatório.',
            'cidade.required'          => 'A cidade é obrigatória.',
            'estado.required'          => 'O estado é obrigatório.',
            'pais.required'            => 'O país é obrigatório.',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('fotos/usuarios', 'public');
            if (!$foto) {
                return back()->withInput()->withErrors([
                    'foto' => 'Não foi possível salvar a foto. Tente novamente.',
                ]);
            }
        }

        try {
            DB::transaction(function () use ($dados, $foto, &$usuario) {
            $usuario = Usuario::create([
                'nome_razao'      => $dados['nome_razao'],
                'email'           => $dados['email'],
                'password'        => Hash::make($dados['password']),
                'cpf_cnpj'        => $dados['cpf_cnpj'],
                'telefone'        => $dados['telefone'],
                'data_nascimento' => $dados['data_nascimento'],
                'tipo'            => 'Usuário',
                'foto'            => $foto,
            ]);

            Enderecos::create([
                'userID'  => $usuario->UserID,
                'apelido' => $dados['apelido'],
                'rua'     => $dados['rua'],
                'numero'  => $dados['numero'],
                'bairro'  => $dados['bairro'],
                'cep'     => $dados['cep'],
                'cidade'  => $dados['cidade'],
                'estado'  => $dados['estado'],
                'pais'    => $dados['pais'],
            ]);
            });
        } catch (\Throwable $exception) {
            if ($foto) {
                Storage::disk('public')->delete($foto);
            }

            throw $exception;
        }

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
        $dados = $request->validate([
            'nome_razao'      => 'required|string|max:55',
            'email'           => 'required|email|max:55|unique:usuario,email',
            'password'        => 'required|string|min:6|confirmed',
            'cpf_cnpj'        => 'required|string|max:18|unique:usuario,cpf_cnpj',
            'telefone'        => 'required|string|max:14',
            'data_nascimento' => 'required|date',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'habilidades'     => 'required|string|max:5000',
            'documento'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'banco'            => 'required|string|max:55',
            'agencia'          => 'required|string|max:6',
            'numero_conta'     => 'required|string|max:16',
            'tipo_conta'       => 'required|in:1,2',
            'titular'          => 'required|string|max:55',
            'cpf_cnpj_titular' => ['required', 'string', 'max:18', new CpfCnpjValido()],
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
            'habilidades.required'     => 'Informe suas habilidades, uma por linha.',
            'documento.file'           => 'O certificado deve ser um arquivo.',
            'documento.mimes'          => 'O certificado deve ser um arquivo PDF, JPG ou PNG.',
            'documento.max'            => 'O arquivo de certificado não pode ultrapassar 5 MB.',
            'banco.required'            => 'Informe o banco para recebimento dos repasses.',
            'agencia.required'          => 'Informe a agência da conta.',
            'numero_conta.required'     => 'Informe o número da conta.',
            'tipo_conta.required'       => 'Selecione o tipo de conta.',
            'titular.required'          => 'Informe o titular da conta.',
            'cpf_cnpj_titular.required' => 'Informe o CPF/CNPJ do titular da conta.',
        ]);

        unset($dados['foto'], $dados['documento']);
        $foto = null;
        $caminhoCertificado = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('fotos/usuarios', 'public');
            if (!$foto) {
                return back()->withInput()->withErrors([
                    'foto' => 'Não foi possível salvar a foto. Tente novamente.',
                ]);
            }
        }
        if ($request->hasFile('documento')) {
            $caminhoCertificado = $request->file('documento')->store('certificados', 'public');
            if (!$caminhoCertificado) {
                if ($foto) {
                    Storage::disk('public')->delete($foto);
                }
                return back()->withInput()->withErrors([
                    'documento' => 'Não foi possível salvar o certificado. Tente novamente.',
                ]);
            }
        }

        try {
            DB::transaction(function () use ($dados, $foto, $caminhoCertificado, &$usuario) {
            $usuario = Usuario::create([
                'nome_razao'      => $dados['nome_razao'],
                'email'           => $dados['email'],
                'password'        => Hash::make($dados['password']),
                'cpf_cnpj'        => $dados['cpf_cnpj'],
                'telefone'        => $dados['telefone'],
                'data_nascimento' => $dados['data_nascimento'],
                'tipo'            => 'Técnico',
                'foto'            => $foto,
            ]);

            $tecnico = Tecnicos::create([
                'UserID'    => $usuario->UserID,
                'documento' => $caminhoCertificado,
            ]);

            DadosBancarios::create([
                'TecnicoID'        => $tecnico->TecnicoID,
                'banco'            => $dados['banco'],
                'agencia'          => $dados['agencia'],
                'numero_conta'     => $dados['numero_conta'],
                'tipo_conta'       => $dados['tipo_conta'],
                'titular'          => $dados['titular'],
                'cpf_cnpj_titular' => $dados['cpf_cnpj_titular'],
            ]);
            foreach ($this->habilidadeDescriptions($dados['habilidades']) as $descricao) {
                Habilidade::create([
                    'TecnicoID' => $tecnico->TecnicoID,
                    'descricao' => $descricao,
                ]);
            }
            });
        } catch (\Throwable $exception) {
            foreach ([$foto, $caminhoCertificado] as $path) {
                if ($path) {
                    Storage::disk('public')->delete($path);
                }
            }

            throw $exception;
        }

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('tecnico.dashboard')
            ->with('success', 'Cadastro de técnico parceiro concluído! Bem-vindo(a) à plataforma IService.');
    }

    private function habilidadeDescriptions(string $habilidades): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $habilidades))
            ->map(function ($descricao) {
                return trim($descricao);
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
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

<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Tecnicos;
use App\Models\Habilidade;
use App\Rules\CpfCnpjValido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TecnicosController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $tipo  = $request->input('tipo', 'nome_razao');

        $dados = Tecnicos::with('usuario')
            ->when(!empty($valor), function ($query) use ($tipo, $valor) {
                if (in_array($tipo, ['nome_razao', 'email', 'cpf_cnpj', 'telefone'])) {
                    $query->whereHas('usuario', function ($q) use ($tipo, $valor) {
                        $q->where($tipo, 'like', '%' . $valor . '%');
                    });
                } else {
                    $query->where($tipo, 'like', '%' . $valor . '%');
                }
            })->get();

        return view('Tecnicos.list', [
            'dados' => $dados,
            'tipo'  => $tipo,
            'valor' => $valor,
        ]);
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function create()
    {
        $dado = new Tecnicos();
        return view('Tecnicos.form', compact('dado'));
    }

    private function validateForm(Request $request, ?Tecnicos $tecnico = null)
    {
        return $request->validate([
            'nome_razao'      => 'required|string|max:55',
            'email'           => $tecnico
                ? ['required', 'email', 'max:55', Rule::unique('usuario', 'email')->ignore($tecnico->UserID, 'UserID')]
                : 'required|email|max:55|unique:usuario,email',
            'cpf_cnpj'        => $tecnico
                ? ['required', 'string', 'max:18', Rule::unique('usuario', 'cpf_cnpj')->ignore($tecnico->UserID, 'UserID')]
                : 'required|string|max:18|unique:usuario,cpf_cnpj',
            'telefone'        => 'required|string|max:14',
            'data_nascimento' => 'required|date',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'habilidades'     => 'required|string|max:5000',
            'password'        => $tecnico ? 'nullable|string|min:6|confirmed' : 'required|string|min:6|confirmed',
            'documento'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'banco'            => 'required|string|max:55',
            'agencia'          => 'required|string|max:6',
            'numero_conta'     => 'required|string|max:16',
            'tipo_conta'       => 'required|in:1,2',
            'titular'          => 'required|string|max:55',
            'cpf_cnpj_titular' => ['required', 'string', 'max:18', new CpfCnpjValido()],
        ], [
            'nome_razao.required'  => 'O campo nome é obrigatório.',
            'email.required'       => 'O campo e-mail é obrigatório.',
            'email.email'          => 'Informe um e-mail válido.',
            'cpf_cnpj.required'    => 'O campo CPF/CNPJ é obrigatório.',
            'data_nascimento.date' => 'Informe uma data válida.',
            'password.required'   => 'A senha é obrigatória no cadastro.',
            'password.min'        => 'A senha deve conter no mínimo 6 caracteres.',
            'password.confirmed'  => 'A confirmação de senha não confere.',
            'habilidades.required' => 'Informe pelo menos uma habilidade, uma por linha.',
            'documento.file'       => 'O certificado deve ser um arquivo.',
            'documento.mimes'      => 'O certificado deve ser PDF, JPG ou PNG.',
            'documento.max'        => 'O certificado deve ter no máximo 5 MB.',
            'banco.required'            => 'Informe o banco para recebimento dos repasses.',
            'agencia.required'          => 'Informe a agência da conta.',
            'numero_conta.required'     => 'Informe o número da conta.',
            'tipo_conta.required'       => 'Selecione o tipo de conta.',
            'titular.required'          => 'Informe o titular da conta.',
            'cpf_cnpj_titular.required' => 'Informe o CPF/CNPJ do titular da conta.',
        ]);
    }

    public function store(Request $request)
    {
        $dados = $this->validateForm($request);
        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('fotos/usuarios', 'public');
            if (!$foto) {
                return back()->withInput()->withErrors([
                    'foto' => 'Não foi possível salvar a foto. Tente novamente.',
                ]);
            }
        }
        $caminhoCertificado = null;
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
            DB::transaction(function () use ($dados, $foto, $caminhoCertificado) {
                $user = Usuario::create([
                    'nome_razao'      => $dados['nome_razao'],
                    'email'           => $dados['email'],
                    'password'        => Hash::make($dados['password']),
                    'cpf_cnpj'        => $dados['cpf_cnpj'],
                    'data_nascimento' => $dados['data_nascimento'],
                    'telefone'        => $dados['telefone'],
                    'tipo'            => 'Técnico',
                    'foto'            => $foto,
                ]);

                $tecnico = Tecnicos::create([
                    'UserID'    => $user->UserID,
                    'documento' => $caminhoCertificado,
                ]);

                $tecnico->dadosBancarios()->create($this->bankFields($dados));
                $this->saveHabilidades($tecnico, $dados['habilidades']);
            });
        } catch (\Throwable $exception) {
            foreach ([$foto, $caminhoCertificado] as $path) {
                if ($path) {
                    Storage::disk('public')->delete($path);
                }
            }

            throw $exception;
        }

        return redirect()->route('tecnicos.index')->with('success', 'Técnico cadastrado com sucesso!');
    }

    private function bankFields(array $dados): array
    {
        return [
            'banco' => $dados['banco'],
            'agencia' => $dados['agencia'],
            'numero_conta' => $dados['numero_conta'],
            'tipo_conta' => $dados['tipo_conta'],
            'titular' => $dados['titular'],
            'cpf_cnpj_titular' => $dados['cpf_cnpj_titular'],
        ];
    }

    private function saveHabilidades(Tecnicos $tecnico, string $habilidades): void
    {
        $descricoes = collect(preg_split('/\r\n|\r|\n/', $habilidades))
            ->map(function ($descricao) {
                return trim($descricao);
            })
            ->filter()
            ->unique()
            ->values();

        foreach ($descricoes as $descricao) {
            $tecnico->habilidades()->firstOrCreate(['descricao' => $descricao]);
        }

        if ($descricoes->isNotEmpty()) {
            $tecnico->habilidades()->whereNotIn('descricao', $descricoes->all())->delete();
        }
    }

    public function edit($id)
    {
        $dado = Tecnicos::with(['usuario', 'dadosBancarios'])->findOrFail($id);
        return view('Tecnicos.form', compact('dado'));
    }

    public function update(Request $request, $id)
    {
        $tecnico = Tecnicos::with(['usuario', 'dadosBancarios'])->findOrFail($id);
        $dados = $this->validateForm($request, $tecnico);
        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('fotos/usuarios', 'public');
            if (!$foto) {
                return back()->withInput()->withErrors([
                    'foto' => 'Não foi possível salvar a foto. Tente novamente.',
                ]);
            }
        }
        $caminhoCertificado = null;
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

        $certificadoAnterior = $tecnico->documento;
        $fotoAnterior = $tecnico->usuario->foto;
        try {
            DB::transaction(function () use ($dados, $tecnico, $foto, $caminhoCertificado) {
                $usuarioDados = [
                    'nome_razao'      => $dados['nome_razao'],
                    'email'           => $dados['email'],
                    'cpf_cnpj'        => $dados['cpf_cnpj'],
                    'data_nascimento' => $dados['data_nascimento'],
                    'telefone'        => $dados['telefone'],
                ];
                if (!empty($dados['password'])) {
                    $usuarioDados['password'] = Hash::make($dados['password']);
                }
                if ($foto) {
                    $usuarioDados['foto'] = $foto;
                }
                $tecnico->usuario->update($usuarioDados);

                if ($caminhoCertificado) {
                    $tecnico->documento = $caminhoCertificado;
                    $tecnico->save();
                }

                $tecnico->dadosBancarios()->updateOrCreate(
                    ['TecnicoID' => $tecnico->TecnicoID],
                    $this->bankFields($dados)
                );
                $this->saveHabilidades($tecnico, $dados['habilidades']);
            });
        } catch (\Throwable $exception) {
            foreach ([$foto, $caminhoCertificado] as $path) {
                if ($path) {
                    Storage::disk('public')->delete($path);
                }
            }

            throw $exception;
        }

        if ($caminhoCertificado && $certificadoAnterior && $certificadoAnterior !== $caminhoCertificado) {
            Storage::disk('public')->delete($certificadoAnterior);
        }
        if ($foto && $fotoAnterior) {
            Storage::disk('public')->delete($fotoAnterior);
        }

        return redirect()->route('tecnicos.index')->with('success', 'Técnico atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $tecnico = Tecnicos::findOrFail($id);
        $caminhoCertificado = $tecnico->documento;
        $foto = optional($tecnico->usuario)->foto;

        DB::transaction(function () use ($tecnico) {
            $usuario = $tecnico->usuario;
            $tecnico->delete();

            if ($usuario) {
                $usuario->delete();
            }
        });

        if ($caminhoCertificado) {
            Storage::disk('public')->delete($caminhoCertificado);
        }
        if ($foto) {
            Storage::disk('public')->delete($foto);
        }

        return redirect()->route('tecnicos.index')->with('success', 'Técnico removido com sucesso!');
    }

    /**
     * Exibe/faz download do certificado do técnico.
     */
    public function certificado($id)
    {
        $tecnico = Tecnicos::findOrFail($id);

        if (!$tecnico->documento || !Storage::disk('public')->exists($tecnico->documento)) {
            return back()->with('error', 'Certificado não encontrado.');
        }

        $caminho   = Storage::disk('public')->path($tecnico->documento);
        $extensao  = pathinfo($caminho, PATHINFO_EXTENSION);
        $mimeTypes = [
            'pdf'  => 'application/pdf',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
        ];
        $mime = $mimeTypes[strtolower($extensao)] ?? 'application/octet-stream';

        return response()->file($caminho, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="certificado_tecnico_' . $id . '.' . $extensao . '"',
        ]);
    }

    public function dadosBancarios($id)
    {
        $tecnico = Tecnicos::with(['usuario', 'dadosBancarios'])->findOrFail($id);

        return view('Tecnicos.dados-bancarios', compact('tecnico'));
    }
}

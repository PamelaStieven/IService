<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Tecnicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    private function validateForm(Request $request, bool $isUpdate = false)
    {
        $request->validate([
            'nome_razao'      => 'required|string|max:55',
            'email'           => 'required|email|max:55',
            'cpf_cnpj'        => 'required|string|max:18',
            'telefone'        => 'nullable|string|max:14',
            'data_nascimento' => 'nullable|date',
            // Certificado: obrigatório ao criar, opcional ao editar
            'documento'       => ($isUpdate ? 'nullable' : 'nullable') . '|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'nome_razao.required'  => 'O campo nome é obrigatório.',
            'email.required'       => 'O campo e-mail é obrigatório.',
            'email.email'          => 'Informe um e-mail válido.',
            'cpf_cnpj.required'    => 'O campo CPF/CNPJ é obrigatório.',
            'data_nascimento.date' => 'Informe uma data válida.',
            'documento.file'       => 'O certificado deve ser um arquivo.',
            'documento.mimes'      => 'O certificado deve ser PDF, JPG ou PNG.',
            'documento.max'        => 'O certificado deve ter no máximo 5 MB.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request, false);

        DB::transaction(function () use ($request) {
            $user = Usuario::create([
                'nome_razao'      => $request->input('nome_razao'),
                'email'           => $request->input('email'),
                'cpf_cnpj'        => $request->input('cpf_cnpj'),
                'data_nascimento' => $request->input('data_nascimento'),
                'telefone'        => $request->input('telefone'),
                'tipo'            => 'Técnico',
            ]);

            $caminhoCertificado = null;
            if ($request->hasFile('documento')) {
                $caminhoCertificado = $request->file('documento')
                    ->store('certificados', 'public');
            }

            Tecnicos::create([
                'UserID'    => $user->UserID,
                'documento' => $caminhoCertificado,
            ]);
        });

        return redirect()->route('tecnicos.index')->with('success', 'Técnico cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Tecnicos::with('usuario')->findOrFail($id);
        return view('Tecnicos.form', compact('dado'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request, true);

        $tecnico = Tecnicos::with('usuario')->findOrFail($id);

        DB::transaction(function () use ($request, $tecnico) {
            $tecnico->usuario->update([
                'nome_razao'      => $request->input('nome_razao'),
                'email'           => $request->input('email'),
                'cpf_cnpj'        => $request->input('cpf_cnpj'),
                'data_nascimento' => $request->input('data_nascimento'),
                'telefone'        => $request->input('telefone'),
            ]);

            $dados = [];

            if ($request->hasFile('documento')) {
                // Remove o certificado antigo se existir
                if ($tecnico->documento) {
                    Storage::disk('public')->delete($tecnico->documento);
                }
                $dados['documento'] = $request->file('documento')
                    ->store('certificados', 'public');
            }

            if (!empty($dados)) {
                $tecnico->update($dados);
            }
        });

        return redirect()->route('tecnicos.index')->with('success', 'Técnico atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $tecnico = Tecnicos::findOrFail($id);

        DB::transaction(function () use ($tecnico) {
            $usuario = $tecnico->usuario;

            // Remove o arquivo de certificado do storage
            if ($tecnico->documento) {
                Storage::disk('public')->delete($tecnico->documento);
            }

            $tecnico->delete();

            if ($usuario) {
                $usuario->delete();
            }
        });

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

        // Exibe inline no browser (PDF abre no visualizador, imagens na aba)
        return response()->file($caminho, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="certificado_tecnico_' . $id . '.' . $extensao . '"',
        ]);
    }
}

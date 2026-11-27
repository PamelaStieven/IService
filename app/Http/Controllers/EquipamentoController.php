<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipamentos;
use App\Models\Usuario;
use Illuminate\Support\Facades\Storage;

class EquipamentoController extends Controller
{
    public function index(Request $request)
    {
        $valor = $request->input('valor');
        $tipo = $request->input('tipo', 'nome');
        if (!in_array($tipo, ['nome', 'modelo', 'status'], true)) {
            $tipo = 'nome';
        }

        $dados = Equipamentos::with('usuario')
            ->when($valor !== null && $valor !== '', function ($query) use ($tipo, $valor) {
                $query->where($tipo, 'like', '%' . $valor . '%');
            })
            ->get();

        return view('Equipamentos.list', compact('dados', 'valor', 'tipo'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function create()
    {
        $dado = new Equipamentos();
        $usuarios = Usuario::all();

        return view('Equipamentos.form', compact('dado', 'usuarios'));
    }

    private function validateForm(Request $request)
    {
        return $request->validate([
            'UserID' => 'required|exists:usuario,UserID',
            'nome' => 'required|max:55',
            'modelo' => 'required|max:55',
            'descricao_tecnica' => 'required',
            'estado_conservacao' => 'required|in:Pessimo,Bom,Muito Bom',
            'valor_diaria' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'required|in:Alugado,Disponível',
        ]);
    }

    public function store(Request $request)
    {
        $dados = $this->validateForm($request);
        $imagem = null;
        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem')->store('imagens/equipamentos', 'public');
            if (!$imagem) {
                return back()->withInput()->withErrors([
                    'imagem' => 'Não foi possível salvar a imagem. Tente novamente.',
                ]);
            }
        }

        unset($dados['imagem']);
        $dados['imagem'] = $imagem;
        $dados['data_compra'] = now();
        $dados['valor_aluguel'] = $dados['valor_diaria'];

        try {
            Equipamentos::create($dados);
        } catch (\Throwable $exception) {
            if ($imagem) {
                Storage::disk('public')->delete($imagem);
            }

            throw $exception;
        }

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Equipamentos::where('EquipID', $id)->firstOrFail();
        $usuarios = Usuario::all();

        return view('Equipamentos.form', compact('dado', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $dados = $this->validateForm($request);
        $equipamento = Equipamentos::where('EquipID', $id)->firstOrFail();
        $imagemAnterior = $equipamento->imagem;
        $imagem = null;
        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem')->store('imagens/equipamentos', 'public');
            if (!$imagem) {
                return back()->withInput()->withErrors([
                    'imagem' => 'Não foi possível salvar a imagem. Tente novamente.',
                ]);
            }
            $dados['imagem'] = $imagem;
        } else {
            unset($dados['imagem']);
        }

        $dados['valor_aluguel'] = $dados['valor_diaria'];
        try {
            $equipamento->update($dados);
        } catch (\Throwable $exception) {
            if ($imagem) {
                Storage::disk('public')->delete($imagem);
            }

            throw $exception;
        }
        if ($imagem && $imagemAnterior) {
            Storage::disk('public')->delete($imagemAnterior);
        }

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $equipamento = Equipamentos::where('EquipID', $id)->firstOrFail();
        $imagem = $equipamento->imagem;
        $equipamento->delete();
        if ($imagem) {
            Storage::disk('public')->delete($imagem);
        }

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento removido com sucesso!');
    }

    public function imagem($id)
    {
        $equipamento = Equipamentos::where('EquipID', $id)->firstOrFail();
        abort_unless($equipamento->imagem && Storage::disk('public')->exists($equipamento->imagem), 404);

        return response()->file(Storage::disk('public')->path($equipamento->imagem));
    }
}
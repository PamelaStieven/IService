<?php

namespace App\Services;

use App\Models\Tecnicos;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class SalvarHabilidadesTecnico
{
    public function sincronizar(Tecnicos $tecnico, array $habilidades): void
    {
        $existentes = $tecnico->habilidades()->get()->keyBy('HabilidadeID');
        $mantidas = [];

        foreach ($habilidades as $habilidade) {
            $id = $habilidade['id'] ?? null;
            if ($id !== null) {
                $registro = $existentes->get((int) $id);
                if (!$registro) {
                    throw ValidationException::withMessages([
                        'habilidades' => 'Uma das habilidades informadas não pertence a este técnico.',
                    ]);
                }
            } else {
                $registro = $tecnico->habilidades()->make();
            }

            $registro->descricao = trim($habilidade['descricao']);

            $comprovante = $habilidade['cursos'] ?? null;
            if ($comprovante instanceof UploadedFile) {
                $conteudo = file_get_contents($comprovante->getRealPath());
                if ($conteudo === false) {
                    throw new RuntimeException('Não foi possível ler o comprovante de habilidade enviado.');
                }

                $registro->cursos = $conteudo;
            }

            $registro->save();
            $mantidas[] = $registro->getKey();
        }

        $removidas = $existentes->keys()->diff($mantidas);
        if ($removidas->isNotEmpty()) {
            $tecnico->habilidades()->whereIn('HabilidadeID', $removidas)->delete();
        }
    }
}

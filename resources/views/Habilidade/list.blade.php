
@extends('main')

@section('titulo', 'Habilidades')

@section('conteudo')

<div class="container">
    <h2>Habilidades</h2>

    <a href="{{ route('habilidades.create') }}" class="btn btn-primary mb-3">
        Cadastrar Habilidade
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Técnico</th>
                <th>Descrição</th>
                <th>Curso/Certificado</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($dados as $item)
                <tr>
                    <td>{{ $item->HabilidadeID }}</td>
                    <td>{{ $item->tecnico->user->nome_razao ?? 'Não informado' }}</td>
                    <td>{{ $item->descricao }}</td>
                    <td>
                        {{ !empty($item->cursos) ? 'Arquivo anexado' : 'Sem arquivo' }}
                    </td>
                    <td>
                        <a href="{{ route('habilidades.edit', $item->HabilidadeID) }}"
                           class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('habilidades.destroy', $item->HabilidadeID) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja excluir esta habilidade?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Nenhuma habilidade cadastrada.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

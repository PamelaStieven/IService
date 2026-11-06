@extends('main')
@section('titulo', 'Listagem de Técnicos')

@section('conteudo')

<div class="container my-4">

    <div class="row mb-3">
        <div class="col">
            <h3>Listagem de Técnicos</h3>
        </div>

        <div class="col text-end">
            <a href="{{ route('tecnicos.create') }}" class="btn btn-success">
                Novo
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mt-4">

        <table class="table table-striped table-hover shadow-sm">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Documento</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse($dados as $item)

                    <tr>
                        <td>{{ $item->TecnicoID }}</td>

                        <td>{{ $item->user->nome_razao ?? '-' }}</td>

                        <td>
                            {{ !empty($item->documento) ? 'Anexado' : 'Não anexado' }}
                        </td>

                        <td class="text-center">

                            <a
                                href="{{ route('tecnicos.edit', $item->TecnicoID) }}"
                                class="btn btn-warning btn-sm"
                                title="Editar"
                            >
                                Editar
                            </a>

                            <form
                                action="{{ route('tecnicos.destroy', $item->TecnicoID) }}"
                                method="POST"
                                class="d-inline"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja realmente excluir?')"
                                >
                                    Deletar
                                </button>
                            </form>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="text-center">
                            Nenhum técnico encontrado.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection


@extends('main')
@section('titulo', 'Listagem de Endereços')

@section('conteudo')

<div class="container my-4">

    <div class="row mb-3">
        <div class="col">
            <h3>Listagem de Endereços</h3>
        </div>

        <div class="col text-end">
            <a href="{{ route('enderecos.create') }}" class="btn btn-success">
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
                    <th>Apelido</th>
                    <th>Número</th>
                    <th>Rua</th>
                    <th>Bairro</th>
                    <th>CEP</th>
                    <th>Estado</th>
                    <th>País</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse($dados as $item)

                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->usuario->nome ?? '-' }}</td>
                        <td>{{ $item->apelido ?? '-' }}</td>
                        <td>{{ $item->numero ?? '-' }}</td>
                        <td>{{ $item->rua ?? '-' }}</td>
                        <td>{{ $item->bairro ?? '-' }}</td>
                        <td>{{ $item->cep ?? '-' }}</td>
                        <td>{{ $item->estado ?? '-' }}</td>
                        <td>{{ $item->pais ?? '-' }}</td>

                        <td class="text-center">

                            <a
                                href="{{ route('enderecos.edit', $item->id) }}"
                                class="btn btn-warning btn-sm"
                                title="Editar"
                            >
                                Editar
                            </a>

                            <form
                                action="{{ route('enderecos.destroy', $item->id) }}"
                                method="POST"
                                class="d-inline"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    title="Excluir"
                                    onclick="return confirm('Deseja realmente excluir?')"
                                >
                                    Deletar
                                </button>

                            </form>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="10" class="text-center">
                            Nenhum endereço encontrado.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

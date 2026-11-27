
@extends('main')
@section('titulo', 'Listagem de Endereços')

@section('conteudo')

<div class="container my-4">
    @unless(isset($usuario))
        @include('components.report-actions', ['tipo' => 'enderecos'])
    @endunless

    <div class="row mb-3">
        <div class="col">
            <h3>
                {{ isset($usuario) ? 'Endereços de ' . $usuario->nome_razao : 'Listagem de Endereços' }}
            </h3>
        </div>

        <form action="{{ isset($usuario) ? route('usuario.enderecos.index', $usuario->UserID) : route('enderecos.search') }}" method="GET" class="row g-2 mb-3">
            <div class="col-md-8">
                <input type="search" name="valor" value="{{ $valor ?? '' }}" class="form-control"
                       placeholder="Buscar endereço...">
            </div>
            <div class="col-md-3">
                <select name="tipo" class="form-select">
                    <option value="cidade" {{ ($tipo ?? '') === 'cidade' ? 'selected' : '' }}>Cidade</option>
                    <option value="apelido" {{ ($tipo ?? '') === 'apelido' ? 'selected' : '' }}>Apelido</option>
                    <option value="rua" {{ ($tipo ?? '') === 'rua' ? 'selected' : '' }}>Rua</option>
                    <option value="bairro" {{ ($tipo ?? '') === 'bairro' ? 'selected' : '' }}>Bairro</option>
                    <option value="cep" {{ ($tipo ?? '') === 'cep' ? 'selected' : '' }}>CEP</option>
                    <option value="estado" {{ ($tipo ?? '') === 'estado' ? 'selected' : '' }}>Estado</option>
                    <option value="pais" {{ ($tipo ?? '') === 'pais' ? 'selected' : '' }}>País</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </form>

        <div class="col text-end">
            <a href="{{ isset($usuario) ? route('usuario.enderecos.create', $usuario->UserID) : route('enderecos.create') }}" class="btn btn-success">
                Cadastrar endereço
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
                        <td>{{ $item->EnderecosID }}</td>
                        <td>{{ $item->usuario->nome_razao ?? '-' }}</td>
                        <td>{{ $item->apelido ?? '-' }}</td>
                        <td>{{ $item->numero ?? '-' }}</td>
                        <td>{{ $item->rua ?? '-' }}</td>
                        <td>{{ $item->bairro ?? '-' }}</td>
                        <td>{{ $item->cep ?? '-' }}</td>
                        <td>{{ $item->estado ?? '-' }}</td>
                        <td>{{ $item->pais ?? '-' }}</td>

                        <td class="text-center">

                            <a
                                href="{{ route('enderecos.edit', $item->EnderecosID) }}"
                                class="btn btn-warning btn-sm"
                                title="Editar"
                            >
                                Editar
                            </a>

                            <form
                                action="{{ route('enderecos.destroy', $item->EnderecosID) }}"
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

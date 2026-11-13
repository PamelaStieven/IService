@extends('main')
@section('titulo', 'Listagem de Equipamentos')

@section('conteudo')

<div class="container my-4">

    <div class="row mb-3">
        <div class="col">
            <h3>Listagem de Equipamentos</h3>
        </div>

        <div class="col text-end">
            <a href="{{ route('equipamentos.create') }}" class="btn btn-success">
                Novo Equipamento
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
                    <th>Nome</th>
                    <th>Modelo</th>
                    <th>Descrição técnica</th>
                    <th>Data da compra</th>
                    <th>Valor do aluguel</th>
                    <th>Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse($dados as $item)

                    <tr>
                        <td>{{ $item->EquipID }}</td>
                        <td>{{ optional($item->usuario)->nome ?? optional($item->usuario)->nome_razao ?? 'Sem usuário' }}</td>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->modelo }}</td>
                        <td>{{ $item->descricao_tecnica }}</td>
                        <td>{{ $item->data_compra ? \Carbon\Carbon::parse($item->data_compra)->format('d/m/Y H:i') : '-' }}</td>
                        <td>R$ {{ number_format($item->valor_aluguel, 2, ',', '.') }}</td>
                        <td>{{ $item->status }}</td>

                        <td class="text-center">

                            <a
                                href="{{ route('equipamentos.edit', $item->EquipID) }}"
                                class="btn btn-warning btn-sm"
                            >
                                Editar
                            </a>

                            <form
                                action="{{ route('equipamentos.destroy', $item->EquipID) }}"
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
                        <td colspan="9" class="text-center py-4 text-muted">
                            Nenhum equipamento cadastrado ainda. Clique em "Novo Equipamento" para começar.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

    </div>
</div>

@endsection
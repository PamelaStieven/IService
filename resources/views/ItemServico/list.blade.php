
@extends('main')

@section('titulo', 'Itens de Serviço')

@section('conteudo')

<div class="container">
    <h2>Itens de Serviço</h2>

    <a href="{{ route('itemservicos.create') }}" class="btn btn-primary mb-3">
        Cadastrar Item de Serviço
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Agendamento</th>
                <th>Serviço</th>
                <th>Descrição</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($dados as $item)
                <tr>
                    <td>{{ $item->ItemServicoID }}</td>
                    <td>{{ $item->AgendamentoID }}</td>
                    <td>{{ $item->servico->titulo ?? 'Não informado' }}</td>
                    <td>{{ $item->descricao_item }}</td>
                    <td>{{ $item->data_item }}</td>

                    <td>
                        <a href="{{ route('itemservicos.edit', $item->ItemServicoID) }}"
                           class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('itemservicos.destroy', $item->ItemServicoID) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja excluir este item?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Nenhum item de serviço cadastrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

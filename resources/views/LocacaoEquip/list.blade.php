
@extends('main')

@section('titulo', 'Locações de Equipamentos')

@section('conteudo')

<div class="container">
    <h2>Locações de Equipamentos</h2>

    <a href="{{ route('locacaoequip.create') }}" class="btn btn-primary mb-3">
        Cadastrar Locação
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Data da Retirada</th>
                <th>Data da Devolução</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($dados as $item)
                <tr>
                    <td>{{ $item->LocEquipID }}</td>
                    <td>{{ $item->user->nome_razao ?? 'Não informado' }}</td>
                    <td>{{ $item->data_retirada }}</td>
                    <td>{{ $item->data_devolucao }}</td>

                    <td>
                        <a href="{{ route('locacaoequip.edit', $item->LocEquipID) }}"
                           class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('locacaoequip.destroy', $item->LocEquipID) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja excluir esta locação?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Nenhuma locação cadastrada.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection


@extends('main')

@section('titulo', 'Agendamentos')

@section('conteudo')

<div class="container">
    <h2>Agendamentos</h2>

    <a href="{{ route('agendamentos.create') }}" class="btn btn-primary mb-3">
        Cadastrar Agendamento
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Técnico</th>
                <th>Serviço</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($dados as $item)
                <tr>
                    <td>{{ $item->AgendaID }}</td>
                    <td>{{ $item->user->nome_razao ?? 'Não informado' }}</td>
                    <td>{{ $item->tecnico->user->nome_razao ?? 'Não informado' }}</td>
                    <td>{{ $item->servico->titulo ?? 'Não informado' }}</td>
                    <td>{{ $item->data_hora_inicio }}</td>
                    <td>{{ $item->data_hora_fim }}</td>
                    <td>{{ $item->status_servico }}</td>

                    <td>
                        <a href="{{ route('agendamentos.edit', $item->AgendaID) }}"
                           class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('agendamentos.destroy', $item->AgendaID) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja excluir este agendamento?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Nenhum agendamento cadastrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

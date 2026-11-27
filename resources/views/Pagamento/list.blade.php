
@extends('main')

@section('titulo', 'Pagamentos')

@section('conteudo')

<div class="container">
    @include('components.report-actions', ['tipo' => 'pagamentos'])
    <h2>Pagamentos</h2>

    <a href="{{ route('pagamentos.create') }}" class="btn btn-primary mb-3">
        Cadastrar Pagamento
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Agendamento</th>
                <th>Locação</th>
                <th>Método</th>
                <th>Valor Total</th>
                <th>Taxa do Site</th>
                <th>Status</th>
                <th>Data do Pagamento</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($dados as $item)
                <tr>
                    <td>{{ $item->PagamentoID }}</td>
                    <td>{{ $item->AgendamentoID ?? 'Não informado' }}</td>
                    <td>{{ $item->LocEquipID ?? 'Não informado' }}</td>
                    <td>{{ $item->metodo }}</td>
                    <td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($item->comissao_empresa ?? $item->taxa_site, 2, ',', '.') }}</td>
                    <td>{{ $item->status_pagamento ? 'Pago' : 'Pendente' }}</td>
                    <td>{{ $item->data_pagamento }}</td>

                    <td>
                        <a href="{{ route('pagamentos.edit', $item->PagamentoID) }}"
                           class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        @if(!$item->AgendamentoID)
                            <form action="{{ route('pagamentos.destroy', $item->PagamentoID) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Deseja excluir este pagamento?')">
                                    Excluir
                                </button>
                            </form>
                        @else
                            <span class="small text-muted">Registro de serviço protegido</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">
                        Nenhum pagamento cadastrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

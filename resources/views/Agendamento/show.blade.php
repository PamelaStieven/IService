@extends('main')

@section('titulo', 'Detalhes do Agendamento')

@section('conteudo')
<div class="container my-4" style="max-width: 760px;">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <span class="text-muted small">Agendamento #{{ $agendamento->AgendamentoID }}</span>
                    <h1 class="h3 fw-bold mt-1 mb-0">Detalhes do agendamento</h1>
                </div>
                <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                    {{ $agendamento->status_servico }}
                </span>
            </div>

            <dl class="row mb-4">
                <dt class="col-sm-4 text-muted">Cliente</dt>
                <dd class="col-sm-8">{{ $agendamento->usuario->nome_razao ?? 'Não informado' }}</dd>

                <dt class="col-sm-4 text-muted">Técnico</dt>
                <dd class="col-sm-8">{{ $agendamento->tecnico->usuario->nome_razao ?? 'Não informado' }}</dd>

                <dt class="col-sm-4 text-muted">Serviço</dt>
                <dd class="col-sm-8">{{ $agendamento->servico->titulo ?? 'Não informado' }}</dd>

                <dt class="col-sm-4 text-muted">Início</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($agendamento->data_hora_inicio)->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4 text-muted">Término</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($agendamento->data_hora_fim)->format('d/m/Y H:i') }}</dd>
            </dl>

            <div class="d-flex flex-wrap justify-content-end gap-2">
                <a href="{{ route('agendamentos.index') }}" class="btn btn-light rounded-pill px-4">Voltar</a>
                <a href="{{ route('agendamentos.edit', $agendamento->AgendamentoID) }}" class="btn btn-primary rounded-pill px-4">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection

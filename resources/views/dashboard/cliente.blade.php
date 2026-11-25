@extends('main')

@section('titulo', 'Área do Cliente - IService')

@section('conteudo')
<div class="container my-4">
    <!-- Banner de Boas-vindas -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 text-white" style="background: linear-gradient(135deg, #0047AB 0%, #0095D9 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-primary rounded-pill px-3 py-1 mb-2 fw-semibold text-uppercase" style="font-size: 0.75rem;">
                    Portal do Cliente
                </span>
                <h2 class="fw-bold mb-2">Olá, {{ $user->nome_razao ?? 'Cliente' }}!</h2>
                <p class="mb-0 text-white-50" style="max-width: 600px;">
                    Bem-vindo(a) à sua central de serviços. Acompanhe seus agendamentos, visualize status de manutenções e solicite novas locações de equipamentos.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('agendamentos.create') }}" class="btn btn-light text-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                        + Novo Agendamento
                    </a>
                    <a href="{{ route('locacoes-equipamentos.create') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold">
                        Alugar Equipamento
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Métricas do Cliente -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold text-uppercase">Agendamentos</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-1">Total</span>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $metricas['total_agendamentos'] }}</h3>
                <span class="text-muted small">Solicitações registradas</span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold text-uppercase">Em Andamento</span>
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2.5 py-1">Ativos</span>
                </div>
                <h3 class="fw-bold text-warning mb-0">{{ $metricas['pendentes'] }}</h3>
                <span class="text-muted small">Pendentes ou aceitos</span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold text-uppercase">Concluídos</span>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1">Finalizados</span>
                </div>
                <h3 class="fw-bold text-success mb-0">{{ $metricas['concluidos'] }}</h3>
                <span class="text-muted small">Serviços entregues</span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold text-uppercase">Locações</span>
                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-2.5 py-1">Equipamentos</span>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $metricas['total_locacoes'] }}</h3>
                <span class="text-muted small">Máquinas e ferramentas</span>
            </div>
        </div>
    </div>

    <!-- Tabela de Meus Agendamentos Recentes -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center justify-content-between">
            <div>
                <h5 class="fw-bold text-dark mb-0">Meus Agendamentos de Serviço</h5>
                <small class="text-muted">Histórico das suas manutenções e reparos solicitados</small>
            </div>
            <a href="{{ route('agendamentos.create') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                + Solicitar Reparo
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Serviço</th>
                        <th>Técnico Responsável</th>
                        <th>Data de Início</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agendamentos as $agenda)
                        @php
                            $badgeStatus = match($agenda->status_servico) {
                                'Concluido' => 'bg-success',
                                'Aceito'    => 'bg-primary',
                                'Cancelado' => 'bg-danger',
                                default     => 'bg-warning text-dark'
                            };
                        @endphp
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#{{ $agenda->AgendamentoID }}</td>
                            <td>
                                <span class="fw-bold text-dark">{{ $agenda->servico->titulo ?? 'Serviço sob demanda' }}</span>
                                @if(isset($agenda->servico->categoria))
                                    <div class="text-muted small">{{ $agenda->servico->categoria }}</div>
                                @endif
                            </td>
                            <td>
                                @if(isset($agenda->tecnico->usuario))
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                            {{ strtoupper(substr($agenda->tecnico->usuario->nome_razao, 0, 2)) }}
                                        </div>
                                        <span>{{ $agenda->tecnico->usuario->nome_razao }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">Aguardando atribuição</span>
                                @endif
                            </td>
                            <td>
                                {{ $agenda->data_hora_inicio ? \Carbon\Carbon::parse($agenda->data_hora_inicio)->format('d/m/Y H:i') : 'A definir' }}
                            </td>
                            <td>
                                <span class="badge {{ $badgeStatus }} rounded-pill px-3 py-1">
                                    {{ $agenda->status_servico }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('agendamentos.show', $agenda->AgendamentoID) }}" class="btn btn-sm btn-light border rounded-pill px-3">
                                    Detalhes
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Você ainda não possui nenhum agendamento registrado.
                                <div class="mt-2">
                                    <a href="{{ route('agendamentos.create') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                        Agendar Primeiro Serviço
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabela de Minhas Locações de Equipamentos -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center justify-content-between">
            <div>
                <h5 class="fw-bold text-dark mb-0">Minhas Locações de Equipamentos</h5>
                <small class="text-muted">Equipamentos alugados por você na plataforma</small>
            </div>
            <a href="{{ route('locacoes-equipamentos.create') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                + Nova Locação
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Locação ID</th>
                        <th>Data de Retirada</th>
                        <th>Data Prevista de Devolução</th>
                        <th>Status do Pagamento</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locacoes as $loc)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#{{ $loc->LocEquipID }}</td>
                            <td>{{ $loc->data_retirada ? \Carbon\Carbon::parse($loc->data_retirada)->format('d/m/Y') : '—' }}</td>
                            <td>{{ $loc->data_devolucao ? \Carbon\Carbon::parse($loc->data_devolucao)->format('d/m/Y') : '—' }}</td>
                            <td>
                                @if($loc->pagamento)
                                    <span class="badge bg-success rounded-pill px-3 py-1">Pago (R$ {{ number_format($loc->pagamento->valor_total, 2, ',', '.') }})</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3 py-1">Pagamento Pendente</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                Nenhuma locação de equipamento registrada até o momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

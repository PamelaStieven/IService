@extends('main')

@section('titulo', 'Painel do Técnico - IService')

@section('conteudo')
<div class="container my-4">
    <!-- Banner de Boas-vindas do Técnico -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-primary text-white rounded-pill px-3 py-1 fw-semibold text-uppercase" style="font-size: 0.75rem;">
                        Técnico Parceiro Credenciado
                    </span>
                    @if($tecnico)
                        <span class="badge bg-white text-dark rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.75rem;">
                            ID #{{ $tecnico->TecnicoID }}
                        </span>
                    @endif
                </div>

                <h2 class="fw-bold mb-2">
                    Olá, {{ $tecnico->usuario->nome_razao ?? $user->nome_razao ?? 'Técnico' }}!
                </h2>
                <p class="mb-0 text-slate-300" style="max-width: 600px;">
                    Gerencie seus atendimentos técnicos, cadastre suas especialidades profissionais e acompanhe seus dados bancários para recebimento de repasses.
                </p>
            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('servicos.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                        + Novo Serviço
                    </a>
                    <a href="{{ route('habilidades.create') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold">
                        + Nova Habilidade
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Status de Credenciamento e Conta Bancária -->
    <div class="row g-3 mb-4">
        <!-- Card Certificado -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex items-start justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-3 {{ $metricas['tem_certificado'] ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-warning' }}">
                            <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0.5">Certificado Profissional</h5>
                            <span class="small {{ $metricas['tem_certificado'] ? 'text-success fw-semibold' : 'text-warning fw-semibold' }}">
                                {{ $metricas['tem_certificado'] ? 'Documento Anexado e Válido' : 'Pendente de Envio' }}
                            </span>
                        </div>
                    </div>
                </div>
                <p class="text-muted small mb-3">
                    Seus certificados comprovam sua capacidade técnica e habilitam sua conta para receber solicitações de reparo na região.
                </p>
                <div>
                    @if($tecnico && $metricas['tem_certificado'])
                        <a href="{{ route('tecnicos.certificado', $tecnico->TecnicoID) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            Visualizar Certificado Atual
                        </a>
                    @elseif($tecnico)
                        <a href="{{ route('tecnicos.edit', $tecnico->TecnicoID) }}" class="btn btn-sm btn-warning text-dark rounded-pill px-3 fw-bold">
                            Anexar Certificado Agora
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Dados Bancários -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex items-start justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-3 {{ $metricas['tem_banco'] ? 'bg-primary bg-opacity-10 text-primary' : 'bg-danger bg-opacity-10 text-danger' }}">
                            <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0.5">Conta para Repasse</h5>
                            <span class="small {{ $metricas['tem_banco'] ? 'text-success fw-semibold' : 'text-danger fw-semibold' }}">
                                {{ $metricas['tem_banco'] ? 'Conta Bancária Ativa' : 'Nenhuma Conta Cadastrada' }}
                            </span>
                        </div>
                    </div>
                </div>
                <p class="text-muted small mb-3">
                    Os valores dos serviços realizados são creditados diretamente na conta bancária vinculada ao seu cadastro técnico.
                </p>
                <div>
                    @if($metricas['tem_banco'])
                        <a href="{{ route('dados-bancarios.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            Ver Meus Dados Bancários
                        </a>
                    @else
                        <a href="{{ route('dados-bancarios.create') }}" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">
                            Cadastrar Dados Bancários
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Métricas de Atendimento -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <span class="text-muted small fw-semibold text-uppercase">Trabalhos Atribuídos</span>
                <h3 class="fw-bold text-dark my-1">{{ $metricas['total_trabalhos'] }}</h3>
                <span class="text-muted small">Agendamentos totais</span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <span class="text-muted small fw-semibold text-uppercase">Serviços Pendentes</span>
                <h3 class="fw-bold text-warning my-1">{{ $metricas['pendentes'] }}</h3>
                <span class="text-muted small">Aguardando atendimento</span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <span class="text-muted small fw-semibold text-uppercase">Finalizados</span>
                <h3 class="fw-bold text-success my-1">{{ $metricas['concluidos'] }}</h3>
                <span class="text-muted small">Concluídos com sucesso</span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <span class="text-muted small fw-semibold text-uppercase">Serviços no Catálogo</span>
                <h3 class="fw-bold text-primary my-1">{{ $metricas['total_servicos'] }}</h3>
                <span class="text-muted small">Modalidades ativas</span>
            </div>
        </div>
    </div>

    <!-- Tabela de Agendamentos / Trabalhos Atribuídos -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center justify-between">
            <div>
                <h5 class="fw-bold text-dark mb-0">Trabalhos e Agendamentos Atribuídos</h5>
                <small class="text-muted">Lista de chamados técnicos de clientes para sua realização</small>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Chamado ID</th>
                        <th>Cliente Solicitante</th>
                        <th>Serviço</th>
                        <th>Data Agendada</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Ação</th>
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
                                <div class="fw-bold text-dark">{{ $agenda->usuario->nome_razao ?? 'Cliente' }}</div>
                                <small class="text-muted">{{ $agenda->usuario->telefone ?? '' }}</small>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $agenda->servico->titulo ?? 'Serviço Técnico' }}</span>
                                <div class="text-muted small">{{ $agenda->servico->categoria ?? '' }}</div>
                            </td>
                            <td>{{ $agenda->data_hora_inicio ? \Carbon\Carbon::parse($agenda->data_hora_inicio)->format('d/m/Y H:i') : 'A definir' }}</td>
                            <td>
                                <span class="badge {{ $badgeStatus }} rounded-pill px-3 py-1">
                                    {{ $agenda->status_servico }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('agendamentos.show', $agenda->AgendamentoID) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    Ver Detalhes
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Nenhum agendamento atribuído até o momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

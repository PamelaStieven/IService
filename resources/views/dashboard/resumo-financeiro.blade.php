<style>
    .finance-summary {
        border: 1px solid #e4eaf2;
        padding: clamp(1.1rem, 2.5vw, 1.75rem);
    }

    .finance-metric {
        height: 100%;
        min-height: 92px;
        padding: 1rem 1.1rem;
        border: 1px solid #e7edf3;
        border-radius: 1rem;
        background: #f7f9fc;
    }

    .finance-metric-label {
        display: block;
        color: #64748b;
        font-size: .82rem;
        line-height: 1.4;
    }

    .finance-metric-value {
        display: block;
        margin-top: .35rem;
        color: #17243a;
        font-size: 1.16rem;
        font-weight: 700;
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .finance-metric--commission {
        background: #eaf6fb;
        border-color: #cfe8f3;
    }

    .finance-metric--commission .finance-metric-value {
        color: #00699f;
    }

    .finance-metric--received {
        background: #edf8f2;
        border-color: #d3ecdf;
    }

    .finance-metric--received .finance-metric-value {
        color: #16704c;
    }

    .finance-metric--pending {
        background: #fff8e8;
        border-color: #f5e8c5;
    }

    .finance-metric--pending .finance-metric-value {
        color: #8a5b08;
    }

    .finance-summary .table thead th {
        background: #f7f9fc;
    }

    @media (max-width: 575.98px) {
        .finance-summary .table {
            min-width: 620px;
        }
    }
</style>

<section class="card finance-summary mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="badge rounded-pill bg-light text-primary border px-3 py-2 mb-2">FINANCEIRO</span>
            <h3 class="h5 fw-bold mb-1">Resumo financeiro</h3>
            <p class="small text-muted mb-0">Acompanhe repasses, pagamentos e comissão da plataforma.</p>
        </div>
        <a href="{{ route('relatorios.index') }}" class="btn btn-outline-primary rounded-pill px-4">
            Relatório financeiro
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="finance-metric">
                <span class="finance-metric-label">Repasses confirmados aos técnicos</span>
                <strong class="finance-metric-value">R$ {{ number_format($kpi['total_repasses'], 2, ',', '.') }}</strong>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="finance-metric">
                <span class="finance-metric-label">Faturamento confirmado no mês</span>
                <strong class="finance-metric-value">R$ {{ number_format($kpi['faturamento_mes'], 2, ',', '.') }}</strong>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="finance-metric">
                <span class="finance-metric-label">Taxas confirmadas da plataforma</span>
                <strong class="finance-metric-value">R$ {{ number_format($kpi['total_taxa_site'], 2, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h4 class="h6 fw-bold mb-0">Comissão da empresa em serviços concluídos</h4>
        <span class="badge rounded-pill bg-light text-primary border px-3 py-2">10% por serviço</span>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="finance-metric finance-metric--commission">
                <span class="finance-metric-label">Comissão total prevista</span>
                <strong class="finance-metric-value">R$ {{ number_format($kpi['comissao_servicos_total'], 2, ',', '.') }}</strong>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="finance-metric finance-metric--received">
                <span class="finance-metric-label">Comissão recebida</span>
                <strong class="finance-metric-value">R$ {{ number_format($kpi['comissao_servicos_recebida'], 2, ',', '.') }}</strong>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="finance-metric finance-metric--pending">
                <span class="finance-metric-label">Comissão pendente</span>
                <strong class="finance-metric-value">R$ {{ number_format($kpi['comissao_servicos_pendente'], 2, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-2">
        <h4 class="h6 fw-bold mb-0">Pagamentos recentes</h4>
        <span class="small text-muted">Últimos {{ $pagamentosRecentes->count() }} registros</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Recebedor</th>
                    <th>Método</th>
                    <th>Situação</th>
                    <th>Data</th>
                    <th class="text-end">Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pagamentosRecentes as $pagamento)
                    @php
                        $nomeRecebedor = optional(optional($pagamento->agendamento)->usuario)->nome_razao
                            ?? optional(optional($pagamento->locacaoEquip)->usuario)->nome_razao
                            ?? '—';
                    @endphp
                    <tr>
                        <td class="fw-semibold">{{ $nomeRecebedor }}</td>
                        <td><span class="badge rounded-pill bg-light text-dark border">{{ $pagamento->metodo }}</span></td>
                        <td>
                            <span class="badge rounded-pill {{ $pagamento->status_pagamento ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis' }}">
                                {{ $pagamento->status_pagamento ? 'Pago' : 'Pendente' }}
                            </span>
                        </td>
                        <td class="text-muted">{{ \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') }}</td>
                        <td class="text-end fw-semibold">R$ {{ number_format($pagamento->valor_total, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Ainda não há pagamentos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

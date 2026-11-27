<section class="card border-0 shadow-sm rounded-4 p-4 bg-white mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
        <div>
            <h3 class="h5 fw-bold mb-1">Resumo financeiro</h3>
            <p class="small text-muted mb-0">Valores de pagamentos confirmados.</p>
        </div>
        <a href="{{ route('relatorios.index') }}" class="btn btn-outline-primary rounded-pill px-3">Relatório financeiro</a>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="p-3 rounded-3 bg-light">
                <span class="small text-muted d-block">Repasses aos técnicos</span>
                <strong>R$ {{ number_format($kpi['total_repasses'], 2, ',', '.') }}</strong>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="p-3 rounded-3 bg-light">
                <span class="small text-muted d-block">Faturamento no mês</span>
                <strong>R$ {{ number_format($kpi['faturamento_mes'], 2, ',', '.') }}</strong>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="p-3 rounded-3 bg-light">
                <span class="small text-muted d-block">Taxas da plataforma</span>
                <strong>R$ {{ number_format($kpi['total_taxa_site'], 2, ',', '.') }}</strong>
            </div>
        </div>
    </div>
    <h4 class="h6 fw-bold">Pagamentos recentes</h4>
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead><tr><th>Recebedor</th><th>Método</th><th>Data</th><th class="text-end">Valor</th></tr></thead>
            <tbody>
                @forelse($pagamentosRecentes as $pagamento)
                    @php
                        $nomeRecebedor = optional(optional($pagamento->agendamento)->usuario)->nome_razao
                            ?? optional(optional($pagamento->locacaoEquip)->usuario)->nome_razao
                            ?? '—';
                    @endphp
                    <tr>
                        <td>{{ $nomeRecebedor }}</td>
                        <td>{{ $pagamento->metodo }}</td>
                        <td>{{ \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') }}</td>
                        <td class="text-end">R$ {{ number_format($pagamento->valor_total, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Ainda não há pagamentos confirmados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@extends('main')

@section('titulo', 'Relatório Consolidado de Pagamentos & Serviços - IService')

@section('conteudo')
<div class="container my-4">
    <!-- Cabeçalho do Relatório -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div class="d-flex items-center gap-2 mb-1">
                <span class="badge bg-primary text-white rounded-pill px-3 py-1 text-uppercase" style="font-size: 0.7rem;">
                    Relatório Financeiro & Operacional
                </span>
                <span class="text-muted small">Gerado em {{ date('d/m/Y H:i') }}</span>
            </div>
            <h2 class="fw-bold text-dark mb-0">Relatório de Pagamentos & Serviços</h2>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 py-2 fw-bold d-flex align-items-center gap-2 shadow-sm">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Imprimir / Salvar PDF
            </button>
            <a href="{{ route('dashboard.graficos') }}" class="btn btn-light border rounded-pill px-3 py-2 text-muted">
                Voltar aos Gráficos
            </a>
        </div>
    </div>

    <!-- Resumo Financeiro Consolidado -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #0047AB, #0095D9);">
                <span class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.75rem;">Pagamentos Registrados</span>
                <h3 class="fw-bold my-1">R$ {{ number_format($faturamentoTotal, 2, ',', '.') }}</h3>
                <span class="text-white-50 small">Valores pagos e pendentes</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #059669, #10b981);">
                <span class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.75rem;">Repasse Previsto aos Técnicos</span>
                <h3 class="fw-bold my-1">R$ {{ number_format($repassesTecnico, 2, ',', '.') }}</h3>
                <span class="text-white-50 small">Após comissão da plataforma</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #475569, #1e293b);">
                <span class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.75rem;">Comissão da Plataforma</span>
                <h3 class="fw-bold my-1">R$ {{ number_format($taxaSiteTotal, 2, ',', '.') }}</h3>
                <span class="text-white-50 small">Comissões em pagamentos registrados</span>
            </div>
        </div>
    </div>

    <!-- Barra de Filtros (Oculta na Impressão) -->
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4 d-print-none">
        <form action="{{ route('relatorios.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Filtrar Pagamentos por Método</label>
                <select name="metodo" class="form-select rounded-3">
                    <option value="">Todos os Métodos</option>
                    <option value="PIX" {{ $metodoFiltro === 'PIX' ? 'selected' : '' }}>PIX</option>
                    <option value="Boleto" {{ $metodoFiltro === 'Boleto' ? 'selected' : '' }}>Boleto Bancário</option>
                </select>
            </div>

            <div class="col-md-5">
                <label class="form-label small fw-semibold text-muted mb-1">Filtrar Serviços por Categoria</label>
                <select name="categoria" class="form-select rounded-3">
                    <option value="">Todas as Categorias</option>
                    @foreach($todasCategorias as $cat)
                        <option value="{{ $cat }}" {{ $categoriaFiltro === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 w-100">
                    Aplicar Filtros
                </button>
                <a href="{{ route('relatorios.index') }}" class="btn btn-light border rounded-pill px-3 py-2 text-muted" title="Limpar">
                    ✕
                </a>
            </div>
        </form>
    </div>

    <!-- TABELA 1: RELATÓRIO DE PAGAMENTOS -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">1. Relatório Detalhado de Pagamentos</h5>
                <small class="text-muted">Total de {{ $pagamentos->count() }} transações localizadas</small>
            </div>
            <span class="badge bg-light text-dark border rounded-pill px-3 py-1 d-print-none">
                Financeiro
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Origem (Chamado / Locação)</th>
                        <th>Método</th>
                        <th>Valor Bruto</th>
                        <th>Taxa IService</th>
                        <th>Repasse Técnico</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Data Pagamento</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pagamentos as $pag)
                        @php
                            $taxaPagamento = $pag->comissao_empresa ?? $pag->taxa_site;
                            $repasse = $pag->valor_total - $taxaPagamento;
                        @endphp
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#{{ $pag->PagamentoID }}</td>
                            <td>
                                @if($pag->agendamento)
                                    <span class="fw-bold text-dark">Agendamento #{{ $pag->agendamento->AgendamentoID }}</span>
                                    <div class="text-muted small">Cliente: {{ $pag->agendamento->usuario->nome_razao ?? '—' }}</div>
                                @elseif($pag->locacaoEquip)
                                    <span class="fw-bold text-dark">Locação #{{ $pag->locacaoEquip->LocEquipID }}</span>
                                    <div class="text-muted small">Cliente: {{ $pag->locacaoEquip->usuario->nome_razao ?? '—' }}</div>
                                @else
                                    <span class="text-muted">Transação Avulsa</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $pag->metodo === 'PIX' ? 'bg-info text-dark' : 'bg-secondary' }} rounded-pill px-2.5 py-1">
                                    {{ $pag->metodo }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">R$ {{ number_format($pag->valor_total, 2, ',', '.') }}</td>
                            <td class="text-danger small">R$ {{ number_format($taxaPagamento, 2, ',', '.') }}</td>
                            <td class="text-success fw-semibold">R$ {{ number_format($repasse, 2, ',', '.') }}</td>
                            <td>
                                @if($pag->status_pagamento)
                                    <span class="badge bg-success rounded-pill px-3 py-1">Aprovado</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1">Pendente</span>
                                @endif
                            </td>
                            <td class="text-end pe-4 text-muted small">
                                {{ $pag->data_pagamento ? \Carbon\Carbon::parse($pag->data_pagamento)->format('d/m/Y H:i') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                Nenhum pagamento localizado com os filtros selecionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- TABELA 2: RELATÓRIO DE SERVIÇOS -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">2. Relatório de Serviços Oferecidos</h5>
                <small class="text-muted">Total de {{ $servicos->count() }} serviços cadastrados pelos técnicos</small>
            </div>
            <span class="badge bg-light text-dark border rounded-pill px-3 py-1 d-print-none">
                Operacional
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Título do Serviço</th>
                        <th>Categoria</th>
                        <th>Técnico Responsável</th>
                        <th>Preço Base</th>
                        <th class="text-end pe-4">Modalidade de Cobrança</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicos as $srv)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#{{ $srv->ServicoID }}</td>
                            <td>
                                <span class="fw-bold text-dark">{{ $srv->titulo }}</span>
                                @if($srv->descricao)
                                    <div class="text-muted small text-truncate" style="max-width: 300px;">{{ $srv->descricao }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border rounded-pill px-3 py-1">
                                    {{ $srv->categoria }}
                                </span>
                            </td>
                            <td>{{ $srv->tecnico->usuario->nome_razao ?? 'Técnico #' . $srv->TecnicoID }}</td>
                            <td class="fw-bold text-dark">R$ {{ number_format($srv->preco_base, 2, ',', '.') }}</td>
                            <td class="text-end pe-4">
                                <span class="badge bg-secondary rounded-pill px-2.5 py-1">
                                    {{ ucfirst($srv->tipo_preco) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Nenhum serviço localizado com os filtros selecionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        body {
            background-color: #ffffff !important;
        }
        .iservice-navbar, .d-print-none, .btn {
            display: none !important;
        }
        .card {
            border: 1px solid #e2e8f0 !important;
            box-shadow: none !important;
            break-inside: avoid;
        }
    }
</style>
@endsection

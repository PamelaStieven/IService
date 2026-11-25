@extends('main')

@section('titulo', 'Gráficos & Métricas - IService')

@section('conteudo')
<div class="container my-4">
    <!-- Cabeçalho -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">Painel de Gráficos & Desempenho</h2>
            <p class="text-muted small mb-0">Estatísticas em tempo real sobre a base de usuários, trabalhos realizados e serviços da plataforma.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('relatorios.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 font-semibold">
                Ver Relatórios Detalhados
            </a>
            <button onclick="window.print()" class="btn btn-light border rounded-pill px-3 py-2 text-muted">
                🖨️ Imprimir
            </button>
        </div>
    </div>

    <!-- Cards de Indicadores Chave (KPIs) -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <span class="text-muted small fw-bold text-uppercase">Clientes Cadastrados</span>
                <h2 class="fw-bold text-primary my-1">{{ $kpi['total_usuarios'] }}</h2>
                <span class="text-muted small">Usuários contratantes</span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <span class="text-muted small fw-bold text-uppercase">Técnicos Parceiros</span>
                <h2 class="fw-bold text-dark my-1">{{ $kpi['total_tecnicos'] }}</h2>
                <span class="text-muted small">Profissionais ativos</span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <span class="text-muted small fw-bold text-uppercase">Trabalhos Realizados</span>
                <h2 class="fw-bold text-success my-1">{{ $kpi['total_agendamentos'] }}</h2>
                <span class="text-muted small">Agendamentos totais</span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <span class="text-muted small fw-bold text-uppercase">Faturamento Bruto</span>
                <h2 class="fw-bold text-info my-1">R$ {{ number_format($kpi['total_faturamento'], 2, ',', '.') }}</h2>
                <span class="text-muted small">Taxa retida: R$ {{ number_format($kpi['total_taxa_site'], 2, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Linha 1 de Gráficos -->
    <div class="row g-4 mb-4">
        <!-- Gráfico 1: Técnicos X Usuários -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="mb-3">
                    <h5 class="fw-bold text-dark mb-0.5">Base de Usuários: Técnicos X Clientes</h5>
                    <small class="text-muted">Proporção entre prestadores de serviço e clientes cadastrados</small>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="chartUsuariosTecnicos"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico 2: Trabalhos Realizados por Status -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="mb-3">
                    <h5 class="fw-bold text-dark mb-0.5">Trabalhos Realizados por Status</h5>
                    <small class="text-muted">Distribuição dos agendamentos entre Concluídos, Aceitos, Pendentes e Cancelados</small>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="chartTrabalhosStatus"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Linha 2 de Gráficos -->
    <div class="row g-4">
        <!-- Gráfico 3: Serviços por Categoria -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="mb-3">
                    <h5 class="fw-bold text-dark mb-0.5">Serviços por Categoria</h5>
                    <small class="text-muted">Quantidade de modalidades ativas cadastradas pelos técnicos</small>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="chartCategoriasServicos"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico 4: Métodos de Pagamento -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="mb-3">
                    <h5 class="fw-bold text-dark mb-0.5">Métodos de Pagamento Utilizados</h5>
                    <small class="text-muted">Volume de transações processadas via PIX e Boleto</small>
                </div>
                <div style="position: relative; height: 280px;">
                    <canvas id="chartMetodosPagamento"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Gráfico Técnicos X Usuários (Doughnut)
        const ctxUsuarios = document.getElementById('chartUsuariosTecnicos').getContext('2d');
        new Chart(ctxUsuarios, {
            type: 'doughnut',
            data: {
                labels: ['Clientes / Usuários', 'Técnicos Credenciados', 'Administradores'],
                datasets: [{
                    data: [{{ $totalUsuarios }}, {{ $totalTecnicos }}, {{ $totalAdmins }}],
                    backgroundColor: ['#0047AB', '#0095D9', '#64748b'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, padding: 15, font: { family: 'Plus Jakarta Sans', size: 12 } }
                    }
                },
                cutout: '68%'
            }
        });

        // 2. Gráfico Trabalhos por Status (Bar)
        const ctxTrabalhos = document.getElementById('chartTrabalhosStatus').getContext('2d');
        new Chart(ctxTrabalhos, {
            type: 'bar',
            data: {
                labels: {!! json_encode($statusLabels) !!},
                datasets: [{
                    label: 'Quantidade de Chamados',
                    data: {!! json_encode($statusData) !!},
                    backgroundColor: ['#10b981', '#0047AB', '#f59e0b', '#ef4444'],
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { family: 'Plus Jakarta Sans' } },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans', weight: '600' } }
                    }
                }
            }
        });

        // 3. Gráfico Serviços por Categoria (Horizontal Bar)
        const ctxCategorias = document.getElementById('chartCategoriasServicos').getContext('2d');
        const categoriasData = {!! json_encode($categorias) !!};
        new Chart(ctxCategorias, {
            type: 'bar',
            data: {
                labels: Object.keys(categoriasData).length ? Object.keys(categoriasData) : ['Sem categorias'],
                datasets: [{
                    label: 'Serviços Cadastrados',
                    data: Object.values(categoriasData).length ? Object.values(categoriasData) : [0],
                    backgroundColor: '#0047AB',
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { family: 'Plus Jakarta Sans' } },
                        grid: { color: '#f1f5f9' }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans' } }
                    }
                }
            }
        });

        // 4. Gráfico Métodos de Pagamento (Pie)
        const ctxPagamento = document.getElementById('chartMetodosPagamento').getContext('2d');
        @php
            $pixQtd = 0;
            $boletoQtd = 0;
            foreach ($pagamentosMetodo as $pm) {
                if ($pm->metodo === 'PIX') $pixQtd = $pm->qtd;
                if ($pm->metodo === 'Boleto') $boletoQtd = $pm->qtd;
            }
        @endphp
        new Chart(ctxPagamento, {
            type: 'pie',
            data: {
                labels: ['PIX', 'Boleto Bancário'],
                datasets: [{
                    data: [{{ $pixQtd }}, {{ $boletoQtd }}],
                    backgroundColor: ['#0095D9', '#0047AB'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, padding: 15, font: { family: 'Plus Jakarta Sans', size: 12 } }
                    }
                }
            }
        });
    });
</script>
@endsection

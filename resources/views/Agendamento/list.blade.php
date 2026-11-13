@extends('main')
@section('titulo', 'Agendamentos')

@section('botao_topo')
    <a href="{{ route('agendamentos.create') }}" class="btn btn-blue-pill shadow-sm">
        + Novo Agendamento
    </a>
@endsection

@section('conteudo')

<div class="container my-3">

    <!-- Cabeçalho e Barra de Pesquisa -->
    <div class="row align-items-center justify-content-between mb-4 g-3">
        <div class="col-lg-5">
            <h3 class="fw-bold text-dark mb-1">Agendamentos Realizados</h3>
            <p class="text-muted small mb-0">Gerencie os horários, técnicos, serviços e status dos agendamentos.</p>
        </div>

        <div class="col-lg-7">
            <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                <div class="position-relative" style="min-width: 260px;">
                    <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">🔍</span>
                    <input type="text" class="form-control bg-white border rounded-pill ps-5 py-2 shadow-none" placeholder="Buscar agendamento..." style="border-color: #e2e8f0 !important; font-size: 0.9rem;">
                </div>

                <div>
                    <select class="form-select bg-white border rounded-pill px-4 py-2 shadow-none" style="border-color: #e2e8f0 !important; font-size: 0.9rem;">
                        <option selected>Todos os Status</option>
                        <option value="Aceito">Aceito</option>
                        <option value="Pendente">Pendente</option>
                        <option value="Cancelado">Cancelado</option>
                        <option value="Concluido">Concluído</option>
                    </select>
                </div>

                <div class="d-lg-none">
                    <a href="{{ route('agendamentos.create') }}" class="btn btn-blue-pill w-100">
                        + Novo Agendamento
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-primary border-0 bg-primary bg-opacity-10 text-primary alert-dismissible fade show rounded-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Grid de Cards -->
    <div class="row g-4">
        @forelse($dados as $item)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                    
                    <!-- Topo do Card -->
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold"
                                 style="width: 48px; height: 48px; background-color: #e0f2fe; color: #0284c7; font-size: 1rem;">
                                AG
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem;">{{ optional($item->servico)->titulo ?? 'Serviço' }}</h6>
                                <small class="text-muted" style="font-size: 0.8rem;">ID #{{ $item->AgendamentoID }}</small>
                            </div>
                        </div>

                        <!-- Badge de Status -->
                        <span class="badge rounded-pill px-3 py-1 fw-semibold"
                              style="background-color: #f0f9ff; color: #0284c7; border: 1px solid #bae6fd; font-size: 0.75rem;">
                            {{ $item->status_servico }}
                        </span>
                    </div>

                    <!-- Detalhes -->
                    <div class="card-body p-0 my-2" style="color: #475569; font-size: 0.9rem; line-height: 1.7;">
                        <div><strong>Usuário:</strong> {{ optional($item->usuario)->nome_razao ?? 'Não informado' }}</div>
                        <div><strong>Técnico:</strong> {{ optional(optional($item->tecnico)->usuario)->nome_razao ?? 'Não informado' }}</div>
                        <div><strong>Início:</strong> {{ $item->data_hora_inicio }}</div>
                        <div><strong>Fim:</strong> {{ $item->data_hora_fim }}</div>
                    </div>

                    <hr class="my-3" style="border-color: #f1f5f9; opacity: 1;">

                    <!-- Ações -->
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="{{ route('agendamentos.edit', $item->AgendamentoID) }}"
                           class="btn btn-sm rounded-pill px-3 py-1 fw-semibold border-0"
                           style="background-color: #e0f2fe; color: #0284c7;">
                            Editar
                        </a>

                        <form action="{{ route('agendamentos.destroy', $item->AgendamentoID) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm rounded-pill px-3 py-1 fw-semibold border-0"
                                    style="background-color: #fee2e2; color: #dc2626;"
                                    onclick="return confirm('Deseja realmente excluir este agendamento?')">
                                Excluir
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white text-center">
                    <h6 class="fw-bold text-dark mb-1">Nenhum agendamento cadastrado</h6>
                    <p class="text-muted small mb-0">Clique no botão azul "+ Novo Agendamento" acima para adicionar o primeiro registro.</p>
                </div>
            </div>
        @endforelse
    </div>

</div>

@endsection
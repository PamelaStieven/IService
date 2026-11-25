@extends('main')
@section('titulo', 'Equipamentos')

@section('conteudo')

<div class="container my-4">

    <!-- Cabeçalho da Página com Título, Subtítulo e Botão de Novo -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-1">Equipamentos Cadastrados</h2>
            <p class="text-muted mb-0">Gerencie os equipamentos, valores de aluguel e status da plataforma.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('equipamentos.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> + Novo Equipamento
            </a>
        </div>
    </div>

    <!-- Barra de Pesquisa e Filtro (Estilo Visual) -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted ps-3">
                                <i class="bi bi-search"></i>🔍
                            </span>
                            <input type="text" class="form-control bg-light border-0 py-2" placeholder="Buscar por nome ou modelo...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select bg-light border-0 py-2">
                            <option selected>Todos os Status</option>
                            <option value="Disponível">Disponível</option>
                            <option value="Alugado">Alugado</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Grid de Cards de Equipamentos -->
    <div class="row g-4">
        @forelse($dados as $item)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white position-relative">
                    
                    <!-- Topo do Card: Avatar com iniciais, Nome, Modelo e Badge de Status -->
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <!-- Círculo com as iniciais do equipamento -->
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 1.1rem;">
                                {{ strtoupper(substr($item->nome, 0, 2)) }}
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-dark">{{ $item->nome }}</h5>
                                <small class="text-muted">ID #{{ $item->EquipID }}</small>
                            </div>
                        </div>

                        <!-- Badge de Status -->
                        @if($item->status == 'Disponível')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">Disponível</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-dark px-3 py-2 rounded-pill fw-semibold">Alugado</span>
                        @endif
                    </div>

                    <!-- Corpo do Card: Informações Detalhadas -->
                    <div class="card-body px-0 py-2 text-muted small">
                        <p class="mb-1"><strong>Modelo:</strong> {{ $item->modelo }}</p>
                        <p class="mb-1"><strong>Usuário Responsável:</strong> {{ optional($item->usuario)->nome ?? 'Não atribuído' }}</p>
                        <p class="mb-1"><strong>Valor do Aluguel:</strong> <span class="text-dark fw-bold">R$ {{ number_format($item->valor_aluguel, 2, ',', '.') }}</span></p>
                        <p class="mb-0 text-truncate"><strong>Descrição:</strong> {{ $item->descricao_tecnica }}</p>
                    </div>

                    <hr class="text-muted opacity-25 my-3">

                    <!-- Rodapé do Card: Botões de Ação (Editar / Excluir) -->
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="{{ route('equipamentos.edit', $item->EquipID) }}" class="btn btn-light text-primary bg-primary bg-opacity-10 px-3 py-1 rounded-pill fw-semibold border-0 btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('equipamentos.destroy', $item->EquipID) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light text-danger bg-danger bg-opacity-10 px-3 py-1 rounded-pill fw-semibold border-0 btn-sm" onclick="return confirm('Deseja realmente excluir este equipamento?')">
                                Excluir
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
                    <h5 class="text-muted mb-2">Nenhum equipamento encontrado</h5>
                    <p class="text-muted small">Clique no botão "+ Novo Equipamento" acima para cadastrar o primeiro registro.</p>
                </div>
            </div>
        @endforelse
    </div>

</div>

@endsection
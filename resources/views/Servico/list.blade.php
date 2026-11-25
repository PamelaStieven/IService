@extends('main')

@section('titulo', 'Serviços')

@section('botao_topo')
    <a href="{{ route('servicos.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
        + Novo Serviço
    </a>
@endsection

@section('conteudo')
<div class="container my-4">
    <!-- Cabeçalho da Página -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-1">Serviços Cadastrados</h2>
            <p class="text-muted mb-0">Gerencie os serviços oferecidos pelos técnicos da plataforma.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0 d-lg-none">
            <a href="{{ route('servicos.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                + Novo Serviço
            </a>
        </div>
    </div>

    <!-- Barra de Pesquisa e Filtro -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <form action="{{ route('servicos.search') }}" method="GET" class="row g-3 align-items-center">
                    <div class="col-md-7">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted ps-3">🔍</span>
                            <input type="text" name="valor" value="{{ $valor ?? '' }}" class="form-control bg-light border-0 py-2" placeholder="Buscar por título ou técnico...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="tipo" class="form-select bg-light border-0 py-2">
                            <option value="titulo" {{ ($tipo ?? '') == 'titulo' ? 'selected' : '' }}>Por Título</option>
                            <option value="categoria" {{ ($tipo ?? '') == 'categoria' ? 'selected' : '' }}>Por Categoria</option>
                            <option value="tecnico" {{ ($tipo ?? '') == 'tecnico' ? 'selected' : '' }}>Por Técnico</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabela de Serviços -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Técnico</th>
                        <th>Preço Base</th>
                        <th>Tipo Preço</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dados as $item)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#{{ $item->ServicoID }}</td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $item->titulo }}</span>
                                @if($item->descricao)
                                    <p class="text-muted small mb-0 text-truncate" style="max-width: 250px;">{{ $item->descricao }}</p>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border rounded-pill px-3 py-1">
                                    {{ $item->categoria }}
                                </span>
                            </td>
                            <td>{{ $item->tecnico->usuario->nome_razao ?? 'Técnico #' . $item->TecnicoID }}</td>
                            <td class="fw-bold text-dark">R$ {{ number_format($item->preco_base, 2, ',', '.') }}</td>
                            <td>{{ ucfirst($item->tipo_preco) }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('servicos.edit', $item->ServicoID) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                    Editar
                                </a>
                                <form action="{{ route('servicos.destroy', $item->ServicoID) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este serviço?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                Nenhum serviço cadastrado até o momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

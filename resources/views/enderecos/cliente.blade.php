@extends('main')

@section('titulo', 'Meus endereços - IService')

@section('conteudo')
<div class="container my-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <a href="{{ route('cliente.dashboard') }}" class="text-decoration-none small">&larr; Voltar à área do cliente</a>
            <h1 class="h3 fw-bold mt-2 mb-1">Meus endereços</h1>
            <p class="text-muted mb-0">Cadastre e mantenha atualizados os locais de atendimento.</p>
        </div>
        @if($dado->exists)
            <a href="{{ route('cliente.enderecos.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar edição</a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <p class="fw-semibold mb-1">Confira os campos informados:</p>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h2 class="h5 fw-bold mb-1">Endereços cadastrados</h2>
                            <p class="text-muted small mb-0">{{ $enderecos->count() }} {{ $enderecos->count() === 1 ? 'endereço' : 'endereços' }}</p>
                        </div>
                    </div>

                    @forelse($enderecos as $endereco)
                        <article class="border rounded-3 p-3 mb-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                                <div>
                                    <h3 class="h6 fw-bold mb-1">{{ $endereco->apelido }}</h3>
                                    <p class="mb-1">{{ $endereco->rua }}, {{ $endereco->numero }} &middot; {{ $endereco->bairro }}</p>
                                    <p class="text-muted small mb-0">{{ $endereco->cidade }}, {{ $endereco->estado }} {{ $endereco->cep }} &middot; {{ $endereco->pais }}</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('cliente.enderecos.edit', $endereco->EnderecosID) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Editar</a>
                                    <form action="{{ route('cliente.enderecos.destroy', $endereco->EnderecosID) }}" method="POST" onsubmit="return confirm('Remover este endereço?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Remover</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="text-center rounded-3 bg-light py-5 px-3">
                            <h3 class="h6 fw-bold">Nenhum endereço cadastrado</h3>
                            <p class="text-muted small mb-0">Adicione um local para facilitar seus próximos agendamentos.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">{{ $dado->exists ? 'Editar endereço' : 'Adicionar endereço' }}</h2>

                    <form action="{{ $dado->exists ? route('cliente.enderecos.update', $dado->EnderecosID) : route('cliente.enderecos.store') }}" method="POST">
                        @csrf
                        @if($dado->exists)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="apelido" class="form-label">Identificação</label>
                            <input id="apelido" name="apelido" type="text" maxlength="55" required class="form-control" value="{{ old('apelido', $dado->apelido ?? '') }}" placeholder="Casa, trabalho...">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-8">
                                <label for="rua" class="form-label">Rua / Avenida</label>
                                <input id="rua" name="rua" type="text" maxlength="55" required class="form-control" value="{{ old('rua', $dado->rua ?? '') }}">
                            </div>
                            <div class="col-sm-4">
                                <label for="numero" class="form-label">Número</label>
                                <input id="numero" name="numero" type="number" min="0" required class="form-control" value="{{ old('numero', $dado->numero ?? '') }}">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-7">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input id="bairro" name="bairro" type="text" maxlength="55" required class="form-control" value="{{ old('bairro', $dado->bairro ?? '') }}">
                            </div>
                            <div class="col-sm-5">
                                <label for="cep" class="form-label">CEP</label>
                                <input id="cep" name="cep" type="text" maxlength="11" required class="form-control" value="{{ old('cep', $dado->cep ?? '') }}" placeholder="00000-000">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-5">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input id="cidade" name="cidade" type="text" maxlength="55" required class="form-control" value="{{ old('cidade', $dado->cidade ?? '') }}">
                            </div>
                            <div class="col-sm-3">
                                <label for="estado" class="form-label">Estado</label>
                                <input id="estado" name="estado" type="text" maxlength="55" required class="form-control" value="{{ old('estado', $dado->estado ?? '') }}">
                            </div>
                            <div class="col-sm-4">
                                <label for="pais" class="form-label">País</label>
                                <input id="pais" name="pais" type="text" maxlength="55" required class="form-control" value="{{ old('pais', $dado->pais ?? 'Brasil') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary rounded-pill px-4 w-100">
                            {{ $dado->exists ? 'Salvar alterações' : 'Adicionar endereço' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

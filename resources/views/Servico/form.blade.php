@extends('main')

@php($isEdit = isset($dado) && $dado->exists)

@section('titulo', $isEdit ? 'Editar Serviço' : 'Novo Serviço')

@section('conteudo')
<div class="container my-4" style="max-width: 760px;">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
            <h1 class="h3 fw-bold text-dark">{{ $isEdit ? 'Editar serviço' : 'Cadastrar serviço' }}</h1>
            <p class="text-muted mb-4">Informe os detalhes do serviço oferecido.</p>

            @if ($errors->any())
                <div class="alert alert-danger rounded-3" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ $isEdit ? route('servicos.update', $dado->ServicoID) : route('servicos.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="TecnicoID" class="form-label fw-semibold">Técnico</label>
                    <select name="TecnicoID" id="TecnicoID" class="form-select" required>
                        <option value="">Selecione um técnico</option>
                        @foreach($tecnicos as $tecnico)
                            <option value="{{ $tecnico->TecnicoID }}"
                                {{ (string) old('TecnicoID', $dado->TecnicoID ?? '') === (string) $tecnico->TecnicoID ? 'selected' : '' }}>
                                {{ $tecnico->usuario->nome_razao ?? 'Técnico #' . $tecnico->TecnicoID }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="titulo" class="form-label fw-semibold">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" maxlength="100"
                           value="{{ old('titulo', $dado->titulo ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="categoria" class="form-label fw-semibold">Categoria</label>
                    <input type="text" name="categoria" id="categoria" class="form-control" maxlength="55"
                           value="{{ old('categoria', $dado->categoria ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label fw-semibold">Descrição</label>
                    <textarea name="descricao" id="descricao" class="form-control" rows="4">{{ old('descricao', $dado->descricao ?? '') }}</textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="preco_base" class="form-label fw-semibold">Preço base (R$)</label>
                        <input type="number" name="preco_base" id="preco_base" class="form-control"
                               min="0" step="0.01" value="{{ old('preco_base', $dado->preco_base ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tipo_preco" class="form-label fw-semibold">Tipo de preço</label>
                        <select name="tipo_preco" id="tipo_preco" class="form-select" required>
                            <option value="">Selecione</option>
                            @foreach(['Hora' => 'Por hora', 'Por Serviço' => 'Por serviço'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('tipo_preco', $dado->tipo_preco ?? '') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('servicos.index') }}" class="btn btn-light rounded-pill px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Salvar serviço</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
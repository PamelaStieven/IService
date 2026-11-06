@extends('main')
@section('titulo', isset($dado->id) ? 'Editar Equipamento' : 'Novo Equipamento')

@section('conteudo')

<div class="container my-4">
    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                {{ isset($dado->id) ? 'Editar Equipamento' : 'Novo Equipamento' }}
            </h4>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($dado->id) ? route('equipamentos.update', $dado->id) : route('equipamentos.store') }}" method="POST">

                @csrf

                @if(isset($dado->id))
                    @method('PUT')
                @endif

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="usuario_id" class="form-label">Usuário *</label>

                        <select name="usuario_id" id="usuario_id" class="form-select" required>
                            <option value="">Selecione um usuário</option>

                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    {{ old('usuario_id', $dado->usuario_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome *</label>
                        <input
                            type="text"
                            name="nome"
                            id="nome"
                            class="form-control"
                            value="{{ old('nome', $dado->nome ?? '') }}"
                            maxlength="55"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="modelo" class="form-label">Modelo *</label>
                        <input
                            type="text"
                            name="modelo"
                            id="modelo"
                            class="form-control"
                            value="{{ old('modelo', $dado->modelo ?? '') }}"
                            maxlength="55"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="data_compra" class="form-label">Data da compra *</label>
                        <input
                            type="datetime-local"
                            name="data_compra"
                            id="data_compra"
                            class="form-control"
                            value="{{ old('data_compra', isset($dado->data_compra) ? \Carbon\Carbon::parse($dado->data_compra)->format('Y-m-d\TH:i') : '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="valor_aluguel" class="form-label">Valor do aluguel *</label>
                        <input
                            type="number"
                            name="valor_aluguel"
                            id="valor_aluguel"
                            class="form-control"
                            step="0.01"
                            min="0"
                            value="{{ old('valor_aluguel', $dado->valor_aluguel ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status *</label>

                        <select name="status" id="status" class="form-select" required>
                            <option value="">Selecione</option>

                            <option value="Disponível"
                                {{ old('status', $dado->status ?? '') == 'Disponível' ? 'selected' : '' }}>
                                Disponível
                            </option>

                            <option value="Alugado"
                                {{ old('status', $dado->status ?? '') == 'Alugado' ? 'selected' : '' }}>
                                Alugado
                            </option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="descricao_tecnica" class="form-label">Descrição técnica *</label>

                        <textarea
                            name="descricao_tecnica"
                            id="descricao_tecnica"
                            class="form-control"
                            rows="4"
                            required
                        >{{ old('descricao_tecnica', $dado->descricao_tecnica ?? '') }}</textarea>
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success me-2">
                        Salvar
                    </button>

                    <a href="{{ route('equipamentos.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
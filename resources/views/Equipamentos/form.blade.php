@extends('main')
@section('titulo', isset($dado->EquipID) ? 'Editar Equipamento' : 'Novo Equipamento')

@section('conteudo')

<div class="container my-4 iservice-form-shell">
    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                {{ isset($dado->EquipID) ? 'Editar Equipamento' : 'Novo Equipamento' }}
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

            <form action="{{ isset($dado->EquipID) ? route('equipamentos.update', $dado->EquipID) : route('equipamentos.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                @if(isset($dado->EquipID))
                    @method('PUT')
                @endif

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="UserID" class="form-label">Usuário *</label>

                        <select name="UserID" id="UserID" class="form-select" required>
                            <option value="">Selecione um usuário</option>

                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->UserID }}"
                                    {{ old('UserID', $dado->UserID ?? '') == $usuario->UserID ? 'selected' : '' }}>
                                    {{ $usuario->nome_razao }}
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
                        <label for="estado_conservacao" class="form-label">Estado de conservação *</label>
                        <select name="estado_conservacao" id="estado_conservacao" class="form-select" required>
                            @foreach(['Pessimo' => 'Péssimo', 'Bom' => 'Bom', 'Muito Bom' => 'Muito Bom'] as $value => $label)
                                <option value="{{ $value }}" {{ old('estado_conservacao', $dado->estado_conservacao ?? 'Bom') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="valor_diaria" class="form-label">Valor da diária (R$) *</label>
                        <input type="number" name="valor_diaria" id="valor_diaria" class="form-control"
                               step="0.01" min="0" value="{{ old('valor_diaria', $dado->valor_diaria ?? '') }}" required>
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

                    <div class="col-md-12">
                        <label for="imagem" class="form-label">Imagem do equipamento</label>
                        @if($dado->imagem)
                            <div class="mb-2">
                                <img src="{{ route('equipamentos.imagem', $dado->EquipID) }}" alt="Imagem de {{ $dado->nome }}"
                                     class="rounded" style="max-width: 180px; max-height: 140px; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" name="imagem" id="imagem" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">JPG, PNG ou WEBP; até 5 MB. Deixe em branco para manter a imagem atual.</small>
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
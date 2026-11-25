@extends('main')

@php
    $item = $dado ?? $data ?? null;
    $isEdit = isset($item) && $item->exists;
@endphp

@section('titulo', $isEdit ? 'Editar Habilidade' : 'Cadastrar Habilidade')

@section('conteudo')

<div class="container my-4">
    <div class="card border-0 shadow-sm rounded-4 p-4 max-w-2xl mx-auto bg-white" style="max-width: 700px;">
        <div class="mb-4">
            <h3 class="fw-bold text-dark mb-1">{{ $isEdit ? 'Editar Habilidade' : 'Cadastrar Nova Habilidade' }}</h3>
            <p class="text-muted small mb-0">Vincule competências, cursos e especialidades aos técnicos cadastrados.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger rounded-3 text-sm mb-4">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $isEdit ? route('habilidades.update', $item->HabilidadeID) : route('habilidades.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            @if($isEdit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="TecnicoID" class="form-label fw-semibold">Técnico Responsável</label>
                <select name="TecnicoID" id="TecnicoID" class="form-select rounded-3 py-2" required>
                    <option value="">Selecione um técnico...</option>
                    @foreach($tecnicos as $tecnico)
                        <option value="{{ $tecnico->TecnicoID }}"
                            {{ old('TecnicoID', $item->TecnicoID ?? '') == $tecnico->TecnicoID ? 'selected' : '' }}>
                            {{ $tecnico->usuario->nome_razao ?? 'Técnico' }} (ID #{{ $tecnico->TecnicoID }})
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Exibe o nome completo do técnico e seu identificador na plataforma.</div>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label fw-semibold">Descrição da Habilidade / Especialidade</label>
                <textarea name="descricao" id="descricao" class="form-control rounded-3" rows="4" 
                          placeholder="Ex: Manutenção em placas eletrônicas, reparo de compressores de ar-condicionado, etc."
                          required>{{ old('descricao', $item->descricao ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="cursos" class="form-label fw-semibold">Certificado ou Comprovante de Curso (opcional)</label>
                <input type="file" name="cursos" id="cursos" class="form-control rounded-3 py-2">
                @if($isEdit && !empty($item->cursos))
                    <div class="mt-2 text-success small font-weight-bold">
                        ✓ Já existe um arquivo de comprovação anexado.
                    </div>
                @endif
            </div>

            <div class="d-flex items-center gap-2 pt-2">
                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                    Salvar Habilidade
                </button>
                <a href="{{ route('habilidades.index') }}" class="btn btn-light border rounded-pill px-4 py-2 text-muted">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

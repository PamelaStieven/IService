
@extends('main')

@section('titulo', isset($data) ? 'Editar Habilidade' : 'Cadastrar Habilidade')

@section('conteudo')

<div class="container">
    <h2>{{ isset($data) ? 'Editar Habilidade' : 'Cadastrar Habilidade' }}</h2>

    <form action="{{ isset($data) ? route('habilidades.update', $data->HabilidadeID) : route('habilidades.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        @if(isset($data))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="TecnicoID" class="form-label">Técnico</label>

            <select name="TecnicoID" id="TecnicoID" class="form-control" required>
                <option value="">Selecione um técnico</option>

                @foreach($tecnicos as $tecnico)
                    <option value="{{ $tecnico->TecnicoID }}"
                        {{ old('TecnicoID', $data->TecnicoID ?? '') == $tecnico->TecnicoID ? 'selected' : '' }}>
                        {{ $tecnico->user->nome_razao ?? 'Técnico #' . $tecnico->TecnicoID }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição da habilidade</label>

            <textarea name="descricao" id="descricao" class="form-control" rows="4" required>{{ old('descricao', $data->descricao ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="cursos" class="form-label">Cursos ou certificados</label>

            <input type="file" name="cursos" id="cursos" class="form-control">

            @if(isset($data) && !empty($data->cursos))
                <small class="text-muted">Já existe um arquivo anexado.</small>
            @endif
        </div>

        <button type="submit" class="btn btn-success">
            Salvar
        </button>

        <a href="{{ route('habilidades.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </form>
</div>

@endsection

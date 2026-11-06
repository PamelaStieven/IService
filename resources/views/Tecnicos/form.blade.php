@extends('main')
@section('titulo', isset($dado->TecnicoID) ? 'Editar Técnico' : 'Novo Técnico')

@section('conteudo')

<div class="container my-4">

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                {{ isset($dado->TecnicoID) ? 'Editar Técnico' : 'Novo Técnico' }}
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

            <form
                action="{{ isset($dado->TecnicoID) ? route('tecnicos.update', $dado->TecnicoID) : route('tecnicos.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                @if(isset($dado->TecnicoID))
                    @method('PUT')
                @endif

                <div class="row g-3">

                    <div class="col-md-6">

                        <label for="UserID" class="form-label">
                            Usuário *
                        </label>

                        <select
                            name="UserID"
                            id="UserID"
                            class="form-select"
                            required
                        >
                            <option value="">Selecione um usuário</option>

                            @foreach($usuarios as $usuario)

                                <option
                                    value="{{ $usuario->UserID }}"
                                    {{ old('UserID', $dado->UserID ?? '') == $usuario->UserID ? 'selected' : '' }}
                                >
                                    {{ $usuario->nome_razao }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6">

                        <label for="documento" class="form-label">
                            Documento
                        </label>

                        <input
                            type="file"
                            name="documento"
                            id="documento"
                            class="form-control"
                        >

                        @if(isset($dado->TecnicoID) && !empty($dado->documento))
                            <small class="text-success">
                                Já existe um documento cadastrado.
                                Envie outro somente se desejar substituí-lo.
                            </small>
                        @endif

                    </div>

                </div>

                <div class="mt-4">

                    <button type="submit" class="btn btn-success me-2">
                        Salvar
                    </button>

                    <a href="{{ route('tecnicos.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

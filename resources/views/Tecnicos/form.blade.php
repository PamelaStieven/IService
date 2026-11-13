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
                        <label for="nome_razao" class="form-label">Nome completo ou razão social *</label>
                        <input
                            type="text"
                            name="nome_razao"
                            id="nome_razao"
                            class="form-control"
                            maxlength="55"
                            value="{{ old('nome_razao', $dado->usuario->nome_razao ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail *</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            maxlength="55"
                            value="{{ old('email', $dado->usuario->email ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="cpf_cnpj" class="form-label">CPF ou CNPJ *</label>
                        <input
                            type="text"
                            name="cpf_cnpj"
                            id="cpf_cnpj"
                            class="form-control"
                            maxlength="18"
                            value="{{ old('cpf_cnpj', $dado->usuario->cpf_cnpj ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="telefone" class="form-label">Telefone *</label>
                        <input
                            type="text"
                            name="telefone"
                            id="telefone"
                            class="form-control"
                            maxlength="14"
                            value="{{ old('telefone', $dado->usuario->telefone ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="data_nascimento" class="form-label">Data de nascimento *</label>
                        <input
                            type="date"
                            name="data_nascimento"
                            id="data_nascimento"
                            class="form-control"
                            value="{{ old('data_nascimento', isset($dado->usuario->data_nascimento) ? $dado->usuario->data_nascimento->format('Y-m-d') : '') }}"
                            required
                        >
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
                            accept=".pdf,.jpg,.jpeg,.png"
                        >

                        @if(isset($dado->TecnicoID) && !empty($dado->documento))
                            <small class="text-success">
                                Já existe um documento cadastrado.
                                Envie outro somente se desejar substituí-lo.
                            </small>
                        @endif
                        <small class="form-text text-muted">Arquivo opcional, até 60 KB.</small>

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

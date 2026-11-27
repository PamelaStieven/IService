
@extends('main')
@php($isEdit = isset($dado) && $dado->exists)
@section('titulo', $isEdit ? 'Editar Endereço' : 'Novo Endereço')

@section('conteudo')
<div class="container my-4 iservice-form-shell">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">{{ $isEdit ? 'Editar Endereço' : 'Novo Endereço' }}</h4>
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

            <form action="{{ isset($usuario) ? route('usuario.enderecos.store', $usuario->UserID) : ($isEdit ? route('enderecos.update', $dado->EnderecosID) : route('enderecos.store')) }}" method="POST">

                @csrf

                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="row g-3">

                    @if(isset($usuario))
                        <input type="hidden" name="UserID" value="{{ $usuario->UserID }}">
                        <div class="col-md-6">
                            <label class="form-label">Usuário</label>
                            <div class="form-control bg-light">{{ $usuario->nome_razao }}</div>
                        </div>
                    @else
                        <div class="col-md-6">
                            <label for="UserID" class="form-label">Usuário *</label>
                            <select name="UserID" id="UserID" class="form-select" required>
                                <option value="">Selecione um usuário</option>

                                @foreach($usuarios as $usuarioOption)
                                    <option value="{{ $usuarioOption->UserID }}"
                                        {{ old('UserID', $dado->userID ?? '') == $usuarioOption->UserID ? 'selected' : '' }}>
                                        {{ $usuarioOption->nome_razao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <label for="apelido" class="form-label">Apelido *</label>
                        <input type="text" name="apelido" id="apelido" class="form-control" value="{{ old('apelido', $dado->apelido ?? '') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label for="rua" class="form-label">Rua *</label>
                        <input type="text" name="rua" id="rua" class="form-control" value="{{ old('rua', $dado->rua ?? '') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label for="numero" class="form-label">Número *</label>
                        <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero', $dado->numero ?? '') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label for="bairro" class="form-label">Bairro *</label>
                        <input type="text" name="bairro" id="bairro" class="form-control" value="{{ old('bairro', $dado->bairro ?? '') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label for="cep" class="form-label">CEP *</label>
                        <input type="text" name="cep" id="cep" class="form-control" value="{{ old('cep', $dado->cep ?? '') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="cidade" class="form-label">Cidade *</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" value="{{ old('cidade', $dado->cidade ?? '') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="estado" class="form-label">Estado *</label>
                        <input type="text" name="estado" id="estado" class="form-control" value="{{ old('estado', $dado->estado ?? '') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="pais" class="form-label">País *</label>
                        <input type="text" name="pais" id="pais" class="form-control" value="{{ old('pais', $dado->pais ?? '') }}" required>
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success me-2">Salvar</button>
                    <a href="{{ isset($usuario) ? route('usuario.enderecos.index', $usuario->UserID) : route('enderecos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>
@stop

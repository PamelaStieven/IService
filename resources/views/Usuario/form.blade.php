@extends('main')

@section('titulo', isset($dado->UserID) ? 'Editar Usuário' : 'Cadastrar Usuário')

@section('conteudo')
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                {{ isset($dado->UserID) ? 'Editar Usuário' : 'Novo Usuário' }}
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

            @php
                $action = isset($dado->UserID)
                    ? route('usuario.update', $dado->UserID)
                    : route('usuario.store');
            @endphp

            <form action="{{ $action }}" method="POST">
                @csrf

                @if (isset($dado->UserID))
                    @method('PUT')
                @endif

                <div class="row g-3">

                    <!-- Nome / Razão Social -->
                    <div class="col-md-6">
                        <label for="nome_razao" class="form-label">Nome / Razão Social *</label>
                        <input
                            type="text" 
                            name="nome_razao" 
                            id="nome_razao" 
                            class="form-control" 
                            value="{{ old('nome_razao', $dado->nome_razao ?? '') }}" 
                            maxlength="55" 
                            required>
                    </div>

                    <!-- E-mail -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail *</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control" 
                            value="{{ old('email', $dado->email ?? '') }}" 
                            maxlength="55" 
                            required>
                    </div>

                    <!-- CPF / CNPJ -->
                    <div class="col-md-6">
                        <label for="cpf_cnpj" class="form-label">CPF / CNPJ *</label>
                        <input 
                            type="text" 
                            name="cpf_cnpj" 
                            id="cpf_cnpj" 
                            class="form-control" 
                            value="{{ old('cpf_cnpj', $dado->cpf_cnpj ?? '') }}" 
                            maxlength="18" 
                            required>
                    </div>

                    <!-- Telefone -->
                    <div class="col-md-6">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input 
                            type="text" 
                            name="telefone" 
                            id="telefone" 
                            class="form-control" 
                            value="{{ old('telefone', $dado->telefone ?? '') }}" 
                            maxlength="14">
                    </div>

                    <!-- Tipo de Usuário -->
                    <div class="col-md-6">
                        <label for="tipo" class="form-label">Tipo de Usuário *</label>
                        <select
                            name="tipo"
                            id="tipo"
                            class="form-select"
                            required
                        >
                            <option value="">Selecione o tipo...</option>
                            <option value="Usuário" {{ old('tipo', $dado->tipo ?? '') == 'Usuário' ? 'selected' : '' }}>Usuário</option>
                            <option value="Técnico" {{ old('tipo', $dado->tipo ?? '') == 'Técnico' ? 'selected' : '' }}>Técnico</option>
                            <option value="Administrador" {{ old('tipo', $dado->tipo ?? '') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>

                    <!-- Data de Nascimento -->
                    <div class="col-md-6">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input 
                            type="date" 
                            name="data_nascimento" 
                            id="data_nascimento" 
                            class="form-control" 
                            value="{{ old('data_nascimento', isset($dado->data_nascimento) ? \Illuminate\Support\Carbon::parse($dado->data_nascimento)->format('Y-m-d') : '') }}">
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        {{ isset($dado->UserID) ? 'Salvar Alterações' : 'Cadastrar Usuário' }}
                    </button>
                    <a href="{{ route('usuario.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
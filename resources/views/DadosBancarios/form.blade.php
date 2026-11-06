
@extends('main')

@section('titulo', isset($data) ? 'Editar Dados Bancários' : 'Cadastrar Dados Bancários')

@section('conteudo')

<div class="container">
    <h2>{{ isset($data) ? 'Editar Dados Bancários' : 'Cadastrar Dados Bancários' }}</h2>

    <form action="{{ isset($data) ? route('dadosbancarios.update', $data->ContaID) : route('dadosbancarios.store') }}"
          method="POST">

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
            <label for="banco" class="form-label">Banco</label>
            <input type="text" name="banco" id="banco" class="form-control"
                   maxlength="55" value="{{ old('banco', $data->banco ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="agencia" class="form-label">Agência</label>
            <input type="text" name="agencia" id="agencia" class="form-control"
                   maxlength="6" value="{{ old('agencia', $data->agencia ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="numero_conta" class="form-label">Número da Conta</label>
            <input type="text" name="numero_conta" id="numero_conta" class="form-control"
                   maxlength="16" value="{{ old('numero_conta', $data->numero_conta ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="tipo_conta" class="form-label">Tipo de Conta</label>

            <select name="tipo_conta" id="tipo_conta" class="form-control" required>
                <option value="">Selecione o tipo de conta</option>

                <option value="1" {{ old('tipo_conta', $data->tipo_conta ?? '') == 1 ? 'selected' : '' }}>
                    Corrente
                </option>

                <option value="2" {{ old('tipo_conta', $data->tipo_conta ?? '') == 2 ? 'selected' : '' }}>
                    Poupança
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="titular" class="form-label">Titular</label>
            <input type="text" name="titular" id="titular" class="form-control"
                   maxlength="55" value="{{ old('titular', $data->titular ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="cpf_cnpj_titular" class="form-label">CPF/CNPJ do Titular</label>
            <input type="text" name="cpf_cnpj_titular" id="cpf_cnpj_titular"
                   class="form-control" maxlength="18"
                   value="{{ old('cpf_cnpj_titular', $data->cpf_cnpj_titular ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-success">
            Salvar
        </button>

        <a href="{{ route('dadosbancarios.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </form>
</div>

@endsection

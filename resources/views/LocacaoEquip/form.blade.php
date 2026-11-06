
@extends('main')

@section('titulo', isset($data) ? 'Editar Locação' : 'Cadastrar Locação')

@section('conteudo')

<div class="container">
    <h2>{{ isset($data) ? 'Editar Locação' : 'Cadastrar Locação' }}</h2>

    <form action="{{ isset($data) ? route('locacaoequip.update', $data->LocEquipID) : route('locacaoequip.store') }}"
          method="POST">

        @csrf

        @if(isset($data))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="UserID" class="form-label">Usuário</label>

            <select name="UserID" id="UserID" class="form-control" required>
                <option value="">Selecione um usuário</option>

                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->UserID }}"
                        {{ old('UserID', $data->UserID ?? '') == $usuario->UserID ? 'selected' : '' }}>
                        {{ $usuario->nome_razao }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="data_retirada" class="form-label">Data e hora da retirada</label>

            <input type="datetime-local"
                   name="data_retirada"
                   id="data_retirada"
                   class="form-control"
                   value="{{ old('data_retirada', isset($data) ? date('Y-m-d\TH:i', strtotime($data->data_retirada)) : '') }}"
                   required>
        </div>

        <div class="mb-3">
            <label for="data_devolucao" class="form-label">Data e hora da devolução</label>

            <input type="datetime-local"
                   name="data_devolucao"
                   id="data_devolucao"
                   class="form-control"
                   value="{{ old('data_devolucao', isset($data) ? date('Y-m-d\TH:i', strtotime($data->data_devolucao)) : '') }}"
                   required>
        </div>

        <button type="submit" class="btn btn-success">
            Salvar
        </button>

        <a href="{{ route('locacaoequip.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </form>
</div>

@endsection

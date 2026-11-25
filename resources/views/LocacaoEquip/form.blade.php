@extends('main')

@php
    $isEdit = isset($dado) && !empty($dado->LocEquipID);

    $formatDateTimeLocal = function ($value) {
        if (empty($value)) {
            return '';
        }
        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d\TH:i');
        } catch (\Throwable $e) {
            return '';
        }
    };

    $valorUserId = old('UserID', $dado->UserID ?? '');
    $valorEquipId = old('EquipID', $dado->EquipID ?? '');
    $valorRetirada = old('data_retirada', $formatDateTimeLocal($dado->data_retirada ?? null));
    $valorDevolucao = old('data_devolucao', $formatDateTimeLocal($dado->data_devolucao ?? null));
@endphp

@section('titulo', $isEdit ? 'Editar Locação de Equipamento' : 'Cadastrar Locação de Equipamento')

@section('conteudo')

<div class="container">
    <h2>{{ $isEdit ? 'Editar Locação de Equipamento' : 'Cadastrar Locação de Equipamento' }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $isEdit ? route('locacoes-equipamentos.update', $dado->LocEquipID) : route('locacoes-equipamentos.store') }}"
          method="POST">
        @csrf

        @if($isEdit)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="UserID" class="form-label">Usuário</label>
            <select name="UserID" id="UserID" class="form-control" required>
                <option value="">Selecione um usuário</option>
                @foreach($usuarios as $usuario)
                    @php
                        $uid = $usuario->UserID ?? $usuario->id;
                        $unome = $usuario->nome_razao ?? $usuario->nome ?? $usuario->name ?? ('Usuário #' . $uid);
                    @endphp
                    <option value="{{ $uid }}" {{ (string) $valorUserId === (string) $uid ? 'selected' : '' }}>
                        {{ $unome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="EquipID" class="form-label">Equipamento</label>
            <select name="EquipID" id="EquipID" class="form-control" required>
                <option value="">Selecione um equipamento</option>
                @foreach($equipamentos as $equipamento)
                    @php
                        $eid = $equipamento->EquipID ?? $equipamento->id;
                        $enome = $equipamento->nome ?? $equipamento->descricao ?? $equipamento->modelo ?? ('Equipamento #' . $eid);
                    @endphp
                    <option value="{{ $eid }}" {{ (string) $valorEquipId === (string) $eid ? 'selected' : '' }}>
                        {{ $enome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="data_retirada" class="form-label">Data da Retirada</label>
            <input type="datetime-local"
                   name="data_retirada"
                   id="data_retirada"
                   class="form-control"
                   value="{{ $valorRetirada }}"
                   required>
        </div>

        <div class="mb-3">
            <label for="data_devolucao" class="form-label">Data da Devolução</label>
            <input type="datetime-local"
                   name="data_devolucao"
                   id="data_devolucao"
                   class="form-control"
                   value="{{ $valorDevolucao }}"
                   required>
        </div>

        <button type="submit" class="btn btn-success">
            {{ $isEdit ? 'Atualizar' : 'Salvar' }}
        </button>

        <a href="{{ route('locacoes-equipamentos.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </form>
</div>

@endsection

@extends('main')

@php($isEdit = isset($dado) && $dado->exists)
@php($isServicePayment = $isEdit && $dado->AgendamentoID !== null)

@section('titulo', $isEdit ? 'Editar Pagamento' : 'Cadastrar Pagamento')

@section('conteudo')

<div class="container">
    <h2>{{ $isEdit ? 'Editar Pagamento' : 'Cadastrar Pagamento' }}</h2>

    <form action="{{ $isEdit ? route('pagamentos.update', $dado->PagamentoID) : route('pagamentos.store') }}"
          method="POST">

        @csrf

        @if($isEdit)
            @method('PUT')
        @endif

        @if($isServicePayment)
            <input type="hidden" name="AgendamentoID" value="{{ $dado->AgendamentoID }}">
            <div class="alert alert-info rounded-3">
                Pagamento do agendamento #{{ $dado->AgendamentoID }}. O valor e a comissão de 10% são calculados pelo serviço.
            </div>
        @else
            <div class="alert alert-light border rounded-3">
                Pagamentos de serviços são registrados automaticamente quando o agendamento é concluído.
            </div>
        @endif

        <div class="mb-3">
            <label for="LocEquipID" class="form-label">Locação de Equipamento</label>

            <select name="LocEquipID" id="LocEquipID" class="form-control">
                <option value="">Selecione uma locação</option>

                @foreach($locacoes as $locacao)
                    <option value="{{ $locacao->LocEquipID }}"
                        {{ old('LocEquipID', $dado->LocEquipID ?? '') == $locacao->LocEquipID ? 'selected' : '' }}>
                        Locação #{{ $locacao->LocEquipID }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="metodo" class="form-label">Método de Pagamento</label>

            <select name="metodo" id="metodo" class="form-control" required>
                <option value="">Selecione o método</option>

                @foreach(['PIX', 'Boleto'] as $metodo)
                    <option value="{{ $metodo }}"
                        {{ old('metodo', $dado->metodo ?? '') == $metodo ? 'selected' : '' }}>
                        {{ $metodo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="valor_total" class="form-label">Valor Total</label>

            <input type="number" name="valor_total" id="valor_total"
                   class="form-control" step="0.01" min="0"
                   value="{{ old('valor_total', $dado->valor_total ?? '') }}" required
                   {{ $isServicePayment ? 'readonly' : '' }}>
        </div>

        <div class="mb-3">
            <label for="taxa_site" class="form-label">Taxa do Site</label>

            <input type="number" name="taxa_site" id="taxa_site"
                   class="form-control" step="0.01" min="0"
                   value="{{ old('taxa_site', $dado->comissao_empresa ?? $dado->taxa_site ?? '') }}" required
                   {{ $isServicePayment ? 'readonly' : '' }}>
        </div>

        <div class="mb-3">
            <label for="status_pagamento" class="form-label">Status do Pagamento</label>

            <select name="status_pagamento" id="status_pagamento" class="form-control" required>
                <option value="">Selecione o status</option>

                <option value="0" {{ old('status_pagamento', $dado->status_pagamento ?? '') == 0 ? 'selected' : '' }}>
                    Pendente
                </option>

                <option value="1" {{ old('status_pagamento', $dado->status_pagamento ?? '') == 1 ? 'selected' : '' }}>
                    Pago
                </option>

            </select>
        </div>

        <div class="mb-3">
            <label for="data_pagamento" class="form-label">Data do Pagamento</label>

            <input type="datetime-local" name="data_pagamento" id="data_pagamento"
                   class="form-control"
                   value="{{ old('data_pagamento', $isEdit ? date('Y-m-d\TH:i', strtotime($dado->data_pagamento)) : '') }}"
                   required>
        </div>

        <button type="submit" class="btn btn-primary">
            Salvar
        </button>

        <a href="{{ route('pagamentos.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </form>
</div>

@endsection

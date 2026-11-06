
@extends('main')

@section('titulo', isset($data) ? 'Editar Pagamento' : 'Cadastrar Pagamento')

@section('conteudo')

<div class="container">
    <h2>{{ isset($data) ? 'Editar Pagamento' : 'Cadastrar Pagamento' }}</h2>

    <form action="{{ isset($data) ? route('pagamentos.update', $data->PagamentoID) : route('pagamentos.store') }}"
          method="POST">

        @csrf

        @if(isset($data))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="AgendaID" class="form-label">Agendamento</label>

            <select name="AgendaID" id="AgendaID" class="form-control">
                <option value="">Selecione um agendamento</option>

                @foreach($agendamentos as $agendamento)
                    <option value="{{ $agendamento->AgendaID }}"
                        {{ old('AgendaID', $data->AgendaID ?? '') == $agendamento->AgendaID ? 'selected' : '' }}>
                        Agendamento #{{ $agendamento->AgendaID }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="LocEquipID" class="form-label">Locação de Equipamento</label>

            <select name="LocEquipID" id="LocEquipID" class="form-control">
                <option value="">Selecione uma locação</option>

                @foreach($locacoes as $locacao)
                    <option value="{{ $locacao->LocEquipID }}"
                        {{ old('LocEquipID', $data->LocEquipID ?? '') == $locacao->LocEquipID ? 'selected' : '' }}>
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
                        {{ old('metodo', $data->metodo ?? '') == $metodo ? 'selected' : '' }}>
                        {{ $metodo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="valor_total" class="form-label">Valor Total</label>

            <input type="number" name="valor_total" id="valor_total"
                   class="form-control" step="0.01" min="0"
                   value="{{ old('valor_total', $data->valor_total ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="taxa_site" class="form-label">Taxa do Site</label>

            <input type="number" name="taxa_site" id="taxa_site"
                   class="form-control" step="0.1" min="0"
                   value="{{ old('taxa_site', $data->taxa_site ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="status_pagamento" class="form-label">Status do Pagamento</label>

            <select name="status_pagamento" id="status_pagamento" class="form-control" required>
                <option value="">Selecione o status</option>

                <option value="0" {{ old('status_pagamento', $data->status_pagamento ?? '') == 0 ? 'selected' : '' }}>
                    Pendente
                </option>

                <option value="1" {{ old('status_pagamento', $data->status_pagamento ?? '') == 1 ? 'selected' : '' }}>
                    Pago
                </option>

                <option value="2" {{ old('status_pagamento', $data->status_pagamento ?? '') == 2 ? 'selected' : '' }}>
                    Cancelado
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="data_pagamento" class="form-label">Data do Pagamento</label>

            <input type="datetime-local" name="data_pagamento" id="data_pagamento"
                   class="form-control"
                   value="{{ old('data_pagamento', isset($data) ? date('Y-m-d\TH:i', strtotime($data->data_pagamento)) : '') }}"
                   required>
        </div>

        <button type="submit" class="btn btn-success">
            Salvar
        </button>

        <a href="{{ route('pagamentos.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </form>
</div>

@endsection

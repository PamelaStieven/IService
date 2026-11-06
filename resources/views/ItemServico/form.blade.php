
@extends('main')

@section('titulo', isset($data) ? 'Editar Item de Serviço' : 'Cadastrar Item de Serviço')

@section('conteudo')

<div class="container">
    <h2>{{ isset($data) ? 'Editar Item de Serviço' : 'Cadastrar Item de Serviço' }}</h2>

    <form action="{{ isset($data) ? route('itemservicos.update', $data->ItemServicoID) : route('itemservicos.store') }}"
          method="POST">

        @csrf

        @if(isset($data))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="AgendamentoID" class="form-label">Agendamento</label>

            <select name="AgendamentoID" id="AgendamentoID" class="form-control" required>
                <option value="">Selecione um agendamento</option>

                @foreach($agendamentos as $agendamento)
                    <option value="{{ $agendamento->AgendaID }}"
                        {{ old('AgendamentoID', $data->AgendamentoID ?? '') == $agendamento->AgendaID ? 'selected' : '' }}>
                        Agendamento #{{ $agendamento->AgendaID }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="ServicoID" class="form-label">Serviço</label>

            <select name="ServicoID" id="ServicoID" class="form-control" required>
                <option value="">Selecione um serviço</option>

                @foreach($servicos as $servico)
                    <option value="{{ $servico->ServicoID }}"
                        {{ old('ServicoID', $data->ServicoID ?? '') == $servico->ServicoID ? 'selected' : '' }}>
                        {{ $servico->titulo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="descricao_item" class="form-label">Descrição do Item</label>

            <textarea name="descricao_item" id="descricao_item"
                      class="form-control" rows="4" required>{{ old('descricao_item', $data->descricao_item ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="data_item" class="form-label">Data do Item</label>

            <input type="date" name="data_item" id="data_item"
                   class="form-control"
                   value="{{ old('data_item', isset($data) ? $data->data_item : '') }}"
                   required>
        </div>

        <button type="submit" class="btn btn-success">
            Salvar
        </button>

        <a href="{{ route('itemservicos.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </form>
</div>

@endsection

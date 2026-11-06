
@extends('main')

@section('titulo', isset($data) ? 'Editar Agendamento' : 'Cadastrar Agendamento')

@section('conteudo')

<div class="container">
    <h2>{{ isset($data) ? 'Editar Agendamento' : 'Cadastrar Agendamento' }}</h2>

    <form action="{{ isset($data) ? route('agendamentos.update', $data->AgendaID) : route('agendamentos.store') }}"
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
            <label for="data_hora_inicio" class="form-label">Data e hora de início</label>

            <input type="datetime-local"
                   name="data_hora_inicio"
                   id="data_hora_inicio"
                   class="form-control"
                   value="{{ old('data_hora_inicio', isset($data) ? date('Y-m-d\TH:i', strtotime($data->data_hora_inicio)) : '') }}"
                   required>
        </div>

        <div class="mb-3">
            <label for="data_hora_fim" class="form-label">Data e hora de término</label>

            <input type="datetime-local"
                   name="data_hora_fim"
                   id="data_hora_fim"
                   class="form-control"
                   value="{{ old('data_hora_fim', isset($data) ? date('Y-m-d\TH:i', strtotime($data->data_hora_fim)) : '') }}"
                   required>
        </div>

        <div class="mb-3">
            <label for="status_servico" class="form-label">Status</label>

            <select name="status_servico" id="status_servico" class="form-control" required>
                <option value="">Selecione o status</option>

                @foreach(['Aceito', 'Pendente', 'Cancelado', 'Concluído'] as $status)
                    <option value="{{ $status }}"
                        {{ old('status_servico', $data->status_servico ?? 'Pendente') == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            Salvar
        </button>

        <a href="{{ route('agendamentos.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </form>
</div>

@endsection

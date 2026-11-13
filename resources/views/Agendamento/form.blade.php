@extends('main')
@section('titulo', isset($dado) ? 'Editar Agendamento' : 'Novo Agendamento')

@section('conteudo')

<div class="container my-4" style="max-width: 700px;">
    
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <h3 class="fw-bold text-dark mb-3">{{ isset($dado) ? 'Editar Agendamento' : 'Novo Agendamento' }}</h3>
        <p class="text-muted small mb-4">Preencha os campos abaixo para gerenciar as informações do agendamento.</p>

        @if ($errors->any())
            <div class="alert alert-danger rounded-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($dado->AgendamentoID) ? route('agendamentos.update', $dado->AgendamentoID) : route('agendamentos.store') }}" method="POST">
            @csrf
            @if(isset($dado->AgendamentoID))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="UserID" class="form-label fw-semibold">Usuário *</label>
                <select name="UserID" id="UserID" class="form-select rounded-pill py-2 bg-light border-0" required>
                    <option value="">Selecione um usuário</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->UserID }}" {{ (isset($dado) && $dado->UserID == $usuario->UserID) ? 'selected' : '' }}>
                            {{ $usuario->nome_razao }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="TecnicoID" class="form-label fw-semibold">Técnico *</label>
                <select name="TecnicoID" id="TecnicoID" class="form-select rounded-pill py-2 bg-light border-0" required>
                    <option value="">Selecione um técnico</option>
                    @foreach($tecnicos as $tecnico)
                        <option value="{{ $tecnico->TecnicoID }}" {{ (isset($dado) && $dado->TecnicoID == $tecnico->TecnicoID) ? 'selected' : '' }}>
                            {{ optional($tecnico->usuario)->nome_razao ?? 'Técnico #' . $tecnico->TecnicoID }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="ServicoID" class="form-label fw-semibold">Serviço *</label>
                <select name="ServicoID" id="ServicoID" class="form-select rounded-pill py-2 bg-light border-0" required>
                    <option value="">Selecione um serviço</option>
                    @foreach($servicos as $servico)
                        <option value="{{ $servico->ServicoID }}" {{ (isset($dado) && $dado->ServicoID == $servico->ServicoID) ? 'selected' : '' }}>
                            {{ $servico->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="data_hora_inicio" class="form-label fw-semibold">Data e Hora de Início *</label>
                    <input type="datetime-local" name="data_hora_inicio" id="data_hora_inicio" class="form-control rounded-pill py-2 bg-light border-0 px-3" value="{{ isset($dado) ? date('Y-m-d\TH:i', strtotime($dado->data_hora_inicio)) : '' }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="data_hora_fim" class="form-label fw-semibold">Data e Hora de Fim *</label>
                    <input type="datetime-local" name="data_hora_fim" id="data_hora_fim" class="form-control rounded-pill py-2 bg-light border-0 px-3" value="{{ isset($dado) ? date('Y-m-d\TH:i', strtotime($dado->data_hora_fim)) : '' }}" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="status_servico" class="form-label fw-semibold">Status do Serviço *</label>
                <select name="status_servico" id="status_servico" class="form-select rounded-pill py-2 bg-light border-0" required>
                    <option value="Pendente" {{ (isset($dado) && $dado->status_servico == 'Pendente') ? 'selected' : '' }}>Pendente</option>
                    <option value="Aceito" {{ (isset($dado) && $dado->status_servico == 'Aceito') ? 'selected' : '' }}>Aceito</option>
                    <option value="Cancelado" {{ (isset($dado) && $dado->status_servico == 'Cancelado') ? 'selected' : '' }}>Cancelado</option>
                    <option value="Concluido" {{ (isset($dado) && $dado->status_servico == 'Concluido') ? 'selected' : '' }}>Concluído</option>
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('agendamentos.index') }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold">Cancelar</a>
                <button type="submit" class="btn btn-blue-pill px-5 py-2">Salvar Agendamento</button>
            </div>
        </form>
    </div>

</div>

@endsection
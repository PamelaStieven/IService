@extends('main')
@section('titulo', $dado->exists ? 'Editar Agendamento' : 'Novo Agendamento')

@section('conteudo')
@php($isConcluido = isset($dado) && $dado->status_servico === 'Concluido')

<div class="container my-4" style="max-width: 700px;">
    
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <h3 class="fw-bold text-dark mb-3">{{ $dado->exists ? 'Editar Agendamento' : 'Novo Agendamento' }}</h3>
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

        <form id="form-agendamento" action="{{ $dado->exists ? route('agendamentos.update', $dado->AgendamentoID) : route('agendamentos.store') }}" method="POST">
            @csrf
            @if($dado->exists)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="UserID" class="form-label fw-semibold">Usuário *</label>
                <select name="UserID" id="UserID" class="form-select rounded-pill py-2 bg-light border-0" required>
                    <option value="">Selecione um usuário</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->UserID }}" {{ old('UserID', $dado->UserID ?? '') == $usuario->UserID ? 'selected' : '' }}>
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
                        <option value="{{ $tecnico->TecnicoID }}" {{ old('TecnicoID', $dado->TecnicoID ?? '') == $tecnico->TecnicoID ? 'selected' : '' }}>
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
                        <option value="{{ $servico->ServicoID }}" {{ old('ServicoID', $dado->ServicoID ?? '') == $servico->ServicoID ? 'selected' : '' }}>
                            {{ $servico->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="data_hora_inicio" class="form-label fw-semibold">Data e Hora de Início *</label>
                    <input type="datetime-local" name="data_hora_inicio" id="data_hora_inicio" class="form-control rounded-pill py-2 bg-light border-0 px-3" value="{{ old('data_hora_inicio', $dado->exists ? date('Y-m-d\TH:i', strtotime($dado->data_hora_inicio)) : '') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="data_hora_fim" class="form-label fw-semibold">Data e Hora de Fim *</label>
                    <input type="datetime-local" name="data_hora_fim" id="data_hora_fim" class="form-control rounded-pill py-2 bg-light border-0 px-3" value="{{ old('data_hora_fim', $dado->exists ? date('Y-m-d\TH:i', strtotime($dado->data_hora_fim)) : '') }}" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="status_servico" class="form-label fw-semibold">Status do Serviço *</label>
                @if($isConcluido)
                    <input type="hidden" name="status_servico" value="Concluido">
                    <input type="text" id="status_servico" class="form-control rounded-pill py-2 bg-light border-0"
                           value="Concluído — encerrado" readonly>
                    <div class="form-text">Serviços concluídos não podem ser reabertos.</div>
                @else
                    <select name="status_servico" id="status_servico" class="form-select rounded-pill py-2 bg-light border-0" required>
                        @foreach(['Pendente' => 'Pendente', 'Aceito' => 'Aceito', 'Cancelado' => 'Cancelado', 'Concluido' => 'Concluído'] as $value => $label)
                            <option value="{{ $value }}" {{ old('status_servico', $dado->status_servico ?? 'Pendente') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                @endif
                <input type="hidden" name="metodo_pagamento"
                       value="{{ old('metodo_pagamento', $dado->metodo_pagamento ?? '') }}">
                @if($isConcluido && $dado->metodo_pagamento)
                    <div class="form-text">Método de pagamento registrado: <strong>{{ $dado->metodo_pagamento }}</strong>.</div>
                @elseif(!$isConcluido)
                    <div class="form-text">Ao marcar como concluído, será solicitado o método de pagamento.</div>
                @endif
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('agendamentos.index') }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold">Cancelar</a>
                <button type="submit" class="btn btn-blue-pill px-5 py-2">Salvar Agendamento</button>
            </div>
        </form>
    </div>

</div>

<dialog id="dialog-metodo-pagamento" class="border-0 rounded-4 p-0 shadow-lg" style="width: min(92vw, 460px);">
    <div class="p-4 p-md-5">
        <div class="d-flex align-items-center gap-3 mb-3">
            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-bold"
                  style="width: 44px; height: 44px;">R$</span>
            <div>
                <h2 class="h5 fw-bold mb-1">Concluir serviço</h2>
                <p class="small text-muted mb-0">Informe como o cliente pagará este serviço.</p>
            </div>
        </div>
        <label for="metodo-pagamento-selecao" class="form-label fw-semibold">Método de pagamento *</label>
        <select id="metodo-pagamento-selecao" class="form-select rounded-3">
            <option value="">Selecione</option>
            <option value="PIX" {{ old('metodo_pagamento', $dado->metodo_pagamento ?? '') === 'PIX' ? 'selected' : '' }}>PIX</option>
            <option value="Boleto" {{ old('metodo_pagamento', $dado->metodo_pagamento ?? '') === 'Boleto' ? 'selected' : '' }}>Boleto</option>
        </select>
        <div id="erro-metodo-pagamento" class="small text-danger mt-2" role="alert"></div>
        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" id="cancelar-conclusao" class="btn btn-light rounded-pill px-4">Agora não</button>
            <button type="button" id="confirmar-conclusao" class="btn btn-primary rounded-pill px-4">Confirmar conclusão</button>
        </div>
    </div>
</dialog>
<style>
    #dialog-metodo-pagamento::backdrop { background: rgba(15, 23, 42, .55); backdrop-filter: blur(3px); }
</style>
<script>
    (function () {
        const form = document.getElementById('form-agendamento');
        const status = form.querySelector('[name="status_servico"]');
        const metodo = form.querySelector('[name="metodo_pagamento"]');
        const dialog = document.getElementById('dialog-metodo-pagamento');
        const selecao = document.getElementById('metodo-pagamento-selecao');
        const erro = document.getElementById('erro-metodo-pagamento');
        let aguardandoConfirmacao = false;

        function solicitarMetodo() {
            if (status.value === 'Concluido' && !metodo.value && !dialog.open) {
                selecao.value = '';
                erro.textContent = '';
                dialog.showModal();
            }
        }

        if (status.tagName === 'SELECT') {
            status.addEventListener('change', solicitarMetodo);
        }
        form.addEventListener('submit', function (event) {
            if (status.value === 'Concluido' && !metodo.value && !aguardandoConfirmacao) {
                event.preventDefault();
                solicitarMetodo();
            }
        });

        document.getElementById('cancelar-conclusao').addEventListener('click', function () {
            dialog.close();
        });
        document.getElementById('confirmar-conclusao').addEventListener('click', function () {
            if (!selecao.value) {
                erro.textContent = 'Selecione PIX ou Boleto para continuar.';
                selecao.focus();
                return;
            }

            metodo.value = selecao.value;
            aguardandoConfirmacao = true;
            dialog.close();
            form.requestSubmit();
        });
    })();
</script>

@endsection
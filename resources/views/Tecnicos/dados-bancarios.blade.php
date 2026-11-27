@extends('main')

@section('titulo', 'Dados bancários do técnico')

@section('conteudo')
<div class="container my-4" style="max-width: 760px">
    <a href="{{ route('tecnicos.index') }}" class="text-decoration-none small">&larr; Voltar para técnicos</a>
    <div class="card border-0 shadow-sm rounded-4 mt-3">
        <div class="card-body p-4">
            <h1 class="h4 fw-bold mb-1">Dados bancários</h1>
            <p class="text-muted mb-4">{{ $tecnico->usuario->nome_razao ?? 'Técnico' }}</p>
            @if($tecnico->dadosBancarios)
                @php($conta = $tecnico->dadosBancarios)
                <dl class="row mb-0">
                    <dt class="col-sm-5">Banco</dt><dd class="col-sm-7">{{ $conta->banco }}</dd>
                    <dt class="col-sm-5">Agência</dt><dd class="col-sm-7">{{ $conta->agencia }}</dd>
                    <dt class="col-sm-5">Número da conta</dt><dd class="col-sm-7">{{ $conta->numero_conta }}</dd>
                    <dt class="col-sm-5">Tipo da conta</dt><dd class="col-sm-7">{{ $conta->tipo_conta == 1 ? 'Corrente' : 'Poupança' }}</dd>
                    <dt class="col-sm-5">Titular</dt><dd class="col-sm-7">{{ $conta->titular }}</dd>
                    <dt class="col-sm-5">CPF/CNPJ do titular</dt><dd class="col-sm-7">{{ $conta->cpf_cnpj_titular }}</dd>
                </dl>
            @else
                <div class="alert alert-info mb-0">Este técnico ainda não possui dados bancários cadastrados.</div>
            @endif
        </div>
    </div>
</div>
@endsection

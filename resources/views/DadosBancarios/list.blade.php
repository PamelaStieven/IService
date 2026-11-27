
@extends('main')

@section('titulo', 'Dados Bancários')

@section('conteudo')

<div class="container">
    @include('components.report-actions', ['tipo' => 'dados-bancarios'])
    <h2>Dados Bancários</h2>

    <a href="{{ route('dados-bancarios.create') }}" class="btn btn-primary mb-3">
        Cadastrar Dados Bancários
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Técnico</th>
                <th>Banco</th>
                <th>Agência</th>
                <th>Número da Conta</th>
                <th>Tipo de Conta</th>
                <th>Titular</th>
                <th>CPF/CNPJ do Titular</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($dados as $item)
                <tr>
                    <td>{{ $item->ContaID }}</td>
                    <td>{{ $item->tecnico->usuario->nome_razao ?? 'Não informado' }}</td>
                    <td>{{ $item->banco }}</td>
                    <td>{{ $item->agencia }}</td>
                    <td>{{ $item->numero_conta }}</td>
                    <td>{{ $item->tipo_conta }}</td>
                    <td>{{ $item->titular }}</td>
                    <td>{{ $item->cpf_cnpj_titular }}</td>

                    <td>
                        <a href="{{ route('dados-bancarios.edit', $item->ContaID) }}"
                           class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('dados-bancarios.destroy', $item->ContaID) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja excluir estes dados bancários?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">
                        Nenhum dado bancário cadastrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

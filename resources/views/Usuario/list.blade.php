@extends('main')
@section('titulo', 'Listagem de Usuários')

@section('conteudo')
<div class="container my-4">
    <div class="row mb-3">
        <h3>Listagem de Usuários</h3>
        <form action="{{ route('usuario.search') }}" method="POST">
            @csrf
            <div class="row align-items-end g-2">
                <div class="col-md-3">
                    <label for="tipo" class="form-label">Filtrar por Campo</label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="nome_razao" {{ request('tipo') == 'nome_razao' ? 'selected' : '' }}>Nome / Razão</option>
                        <option value="email" {{ request('tipo') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="cpf_cnpj" {{ request('tipo') == 'cpf_cnpj' ? 'selected' : '' }}>CPF/CNPJ</option>
                        <option value="telefone" {{ request('tipo') == 'telefone' ? 'selected' : '' }}>Telefone</option>
                        <option value="tipo" {{ request('tipo') == 'tipo' ? 'selected' : '' }}>Tipo de Usuário</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="valor" class="form-label">Valor</label>
                    <input type="text" name="valor" id="valor" class="form-control" placeholder="Digite para pesquisar..." value="{{ request('valor') }}">
                </div>
                <div class="col-md-5 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ route('usuario.index') }}" class="btn btn-secondary">Limpar</a>
                    <a href="{{ route('usuario.create') }}" class="btn btn-success ms-auto">Novo</a>
                </div>
            </div>
        </form>
    </div>
    
    <div class="row mt-4">
        <table class="table table-striped table-hover shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome / Razão</th>
                    <th>Email</th>
                    <th>CPF/CNPJ</th>
                    <th>Data de Nascimento</th>
                    <th>Telefone</th>
                    <th>Tipo</th>
                    <th class="text-center" >Ações</th>
                    <th class="text-center" >Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dados as $item)
                    <tr>
                        <td>{{ $item->UserID }}</td>
                        <td>{{ $item->nome_razao }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->cpf_cnpj }}</td>
                        <td>{{ $item->data_nascimento ? \Illuminate\Support\Carbon::parse($item->data_nascimento)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $item->telefone ?? '-' }}</td>
                        <td>
                            @php
                                $badgeClass = match($item->tipo) {
                                    'Administrador' => 'bg-danger',
                                    'Técnico' => 'bg-warning text-dark',
                                    default => 'bg-primary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ $item->tipo ?? 'Usuário' }}
                            </span>
                        </td>
                        <td class="text-center" style="width: 80px;">
                            <a href="{{ route('usuario.edit', $item->UserID) }}" class="btn btn-warning btn-sm" title="Editar">Editar</a>
                        </td>
                        <td class="text-center" style="width: 80px;">
                            <form action="{{ route('usuario.destroy', $item->UserID) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    title="Excluir"
                                    onclick="return confirm('Deseja realmente excluir este usuário?')">
                                    Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Nenhum usuário encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
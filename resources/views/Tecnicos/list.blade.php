<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IService - Técnicos</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F7F8FA; }
        .bg-cobalto { background-color: #0047AB; }
        .hover-bg-cobalto:hover { background-color: #003580; }
        .text-cobalto { color: #0047AB; }
        .bg-diamante-suave { background-color: #E6F7FF; }
        .text-diamante { color: #0095D9; }
        .border-diamante { border-color: #B3E5FC; }
    </style>
</head>
<body class="text-gray-800 antialiased" x-data="{ search: '' }">

    <header class="bg-white border-b border-gray-100 sticky top-0 z-10 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-xl bg-cobalto flex items-center justify-center text-white font-bold text-lg shadow-sm">
                    IS
                </div>
                <span class="font-bold text-xl tracking-tight text-gray-900">IService</span>
            </div>

            <a href="{{ route('tecnicos.create') }}"
               class="bg-cobalto hover-bg-cobalto text-white font-semibold text-sm px-5 py-2.5 rounded-full shadow-sm transition-all duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Novo Técnico
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                 class="mb-6 bg-diamante-suave border border-diamante text-cobalto px-5 py-4 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-cobalto"></span>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-cobalto hover:opacity-75 font-bold">&times;</button>
            </div>
        @endif

        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Técnicos Cadastrados</h1>
                <p class="text-sm text-gray-500 mt-0.5">Gerencie os técnicos vinculados à plataforma.</p>
            </div>

            <div class="relative">
                <input type="text" x-model="search" placeholder="Buscar por nome, e-mail ou CPF..."
                       class="w-full sm:w-72 pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-full text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/10 transition">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($dados as $tecnico)
                @php $u = $tecnico->usuario; @endphp
                <div x-show="search === ''
                        || '{{ strtolower($tecnico->usuario->nome_razao ?? '') }}'.includes(search.toLowerCase())
                        || '{{ $tecnico->usuario->email ?? '' }}'.includes(search.toLowerCase())
                        || '{{ $tecnico->usuario->cpf_cnpj ?? '' }}'.includes(search)"
                     x-transition
                     class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between">

                    <div>
                        {{-- Avatar + nome --}}
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-diamante-suave text-cobalto font-bold flex items-center justify-center text-base shrink-0">
                                    {{ strtoupper(substr($u->nome_razao ?? 'T', 0, 2)) }}
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-900 text-base leading-snug line-clamp-1">{{ $u->nome_razao ?? '—' }}</h2>
                                    <span class="text-xs text-gray-400">Técnico #{{ $tecnico->TecnicoID }}</span>
                                </div>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-diamante-suave text-cobalto border border-diamante whitespace-nowrap">
                                Técnico
                            </span>
                        </div>

                        {{-- Dados do usuário vinculado --}}
                        <div class="space-y-1.5 text-sm text-gray-600 mt-4 pt-3 border-t border-gray-50">
                            <p class="flex items-center gap-2 truncate">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                                {{ $u->email ?? '—' }}
                            </p>
                            <p class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
                                {{ $u->cpf_cnpj ?? '—' }}
                            </p>
                            <p class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $u->telefone ?? '—' }}
                            </p>
                            @if($tecnico->documento)
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Doc: {{ $tecnico->documento }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Ações --}}
                    <div class="mt-5 pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                        <a href="{{ route('tecnicos.edit', $tecnico->TecnicoID) }}"
                           class="px-4 py-1.5 rounded-full text-xs font-semibold text-cobalto bg-diamante-suave hover:bg-[#cceeff] transition">
                            Editar
                        </a>

                @forelse($dados as $item)

                    <tr>
                        <td>{{ $item->TecnicoID }}</td>

                        <td>{{ $item->usuario->nome_razao ?? '-' }}</td>

                        <td>
                            {{ !empty($item->documento) ? 'Anexado' : 'Não anexado' }}
                        </td>

                        <td class="text-center">

                            <a
                                href="{{ route('tecnicos.edit', $item->TecnicoID) }}"
                                class="btn btn-warning btn-sm"
                                title="Editar"
                            >
                                Editar
                            </a>

                            <form
                                action="{{ route('tecnicos.destroy', $item->TecnicoID) }}"
                                method="POST"
                                class="d-inline"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja realmente excluir?')"
                                >
                                    Deletar
                                </button>
                            </form>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="text-center">
                            Nenhum técnico encontrado.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

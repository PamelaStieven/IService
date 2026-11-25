<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IService - Locações de Equipamentos</title>

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

    @include('navbar')

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

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition
                 class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl flex items-center justify-between shadow-sm">
                <span class="font-medium text-sm">{{ session('error') }}</span>
                <button @click="show = false" class="font-bold hover:opacity-75">&times;</button>
            </div>
        @endif

        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Locações de Equipamentos</h1>
                <p class="text-sm text-gray-500 mt-0.5">Gerencie as locações de equipamentos cadastradas.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="relative">
                    <input type="text" x-model="search" placeholder="Buscar por usuário ou equipamento..."
                           class="w-full sm:w-72 pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-full text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/10 transition">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <a href="{{ route('locacoes-equipamentos.create') }}"
                   class="bg-cobalto hover-bg-cobalto text-white font-semibold text-sm px-5 py-2.5 rounded-full shadow-sm transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Cadastrar Locação
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($dados as $locacao)
                @php
                    $u = $locacao->usuario;
                    $eq = $locacao->equipamento;
                    $nomeUsuario = $u->nome_razao ?? $u->nome ?? $u->name ?? 'Não informado';
                    $nomeEquip = $eq->nome ?? $eq->descricao ?? $eq->titulo ?? $eq->modelo ?? 'Não informado';
                    $retirada = !empty($locacao->data_retirada) ? \Carbon\Carbon::parse($locacao->data_retirada)->format('d/m/Y H:i') : '—';
                    $devolucao = !empty($locacao->data_devolucao) ? \Carbon\Carbon::parse($locacao->data_devolucao)->format('d/m/Y H:i') : '—';
                @endphp

                <div x-show="search === ''
                        || '{{ strtolower($nomeUsuario) }}'.includes(search.toLowerCase())
                        || '{{ strtolower($nomeEquip) }}'.includes(search.toLowerCase())
                        || '{{ $locacao->LocEquipID }}'.includes(search)"
                     x-transition
                     class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between overflow-hidden">

                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            
                            <!-- <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-diamante-suave text-cobalto font-bold flex items-center justify-center text-base shrink-0">
                                    {{ strtoupper(substr($nomeEquip, 0, 2)) }}
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-900 text-base leading-snug line-clamp-1">{{ $nomeEquip }}</h2>
                                    <span class="text-xs text-gray-400">Locação #{{ $locacao->LocEquipID }}</span>
                                </div>
                            </div> -->

                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-diamante-suave text-cobalto border border-diamante whitespace-nowrap">
                                Locação
                            </span>
                        </div>

                        <div class="space-y-1.5 text-sm text-gray-600 mt-4 pt-3 border-t border-gray-50">
                            <p class="flex items-center gap-2 truncate">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ $nomeUsuario }}
                            </p>
                            <p class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Retirada: {{ $retirada }}
                            </p>
                            <p class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Devolução: {{ $devolucao }}
                            </p>
                        </div>
                    </div>

                    <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-2">
                        <a href="{{ route('locacoes-equipamentos.edit', $locacao->LocEquipID) }}"
                           class="px-4 py-1.5 rounded-full text-xs font-semibold text-cobalto bg-diamante-suave hover:bg-[#cceeff] transition">
                            Editar
                        </a>
                        <form action="{{ route('locacoes-equipamentos.destroy', $locacao->LocEquipID) }}" method="POST"
                              onsubmit="return confirm('Deseja excluir esta locação?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-1.5 rounded-full text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-100">
                    <p class="text-gray-500 font-medium">Nenhuma locação cadastrada até o momento.</p>
                    <a href="{{ route('locacoes-equipamentos.create') }}" class="inline-block mt-3 text-sm font-semibold text-cobalto hover:underline">
                        + Cadastrar a primeira locação
                    </a>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>
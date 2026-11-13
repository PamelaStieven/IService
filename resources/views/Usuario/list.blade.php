<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IService - Usuários</title>

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
<body class="text-gray-800 antialiased" x-data="{ search: '', filtroTipo: '' }">

    <header class="bg-white border-b border-gray-100 sticky top-0 z-10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
        
        <!-- Logo e Nome -->
        <div class="flex items-center gap-3">
            <div class="bg-cobalto text-white font-bold w-10 h-10 rounded-xl flex items-center justify-center shadow-sm">
                I
            </div>
            <span class="font-bold text-lg text-gray-900">Service</span>
        </div>

        <nav class="hidden md:flex items-center gap-2">
            <a href="{{ route('enderecos.index') }}" class="px-3 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-cobalto transition">
               Endereços
            </a>
            <a href="{{ route('tecnicos.index') }}" class="px-3 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-cobalto transition">
                Técnicos
            </a>
            <a href="{{ route('agendamentos.index') }}" class="px-3 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-cobalto transition">
                Agendamentos
            </a>
            <a href="{{ route('equipamentos.index') }}" class="px-3 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-cobalto transition">
                Equipamentos
            </a>
        </nav>

        <div>
            <a href="{{ route('usuario.create') }}" class="bg-cobalto hover-bg-cobalto text-white font-bold py-2.5 px-4 rounded-2xl shadow-sm hover:shadow transition-all text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Novo Usuário
            </a>
        </div>
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
                <h1 class="text-2xl font-bold text-gray-900">Usuários Cadastrados</h1>
                <p class="text-sm text-gray-500 mt-0.5">Gerencie técnicos, administradores e clientes da plataforma.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <input type="text" x-model="search" placeholder="Buscar por nome ou CPF..."
                           class="w-full sm:w-64 pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-full text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/10 transition">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <select x-model="filtroTipo" class="px-4 py-2.5 bg-white border border-gray-200 rounded-full text-sm text-gray-700 focus:outline-none focus:border-[#0047AB] transition">
                    <option value="">Todos os Perfis</option>
                    <option value="Técnico">Técnico</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Usuário">Usuário</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($usuario as $usuario)
                <div x-show="(search === '' || '{{ strtolower($usuario->nome_razao) }}'.includes(search.toLowerCase()) || '{{ $usuario->cpf_cnpj }}'.includes(search)) && (filtroTipo === '' || '{{ $usuario->tipo }}' === filtroTipo)"
                     x-transition
                     class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                    
                    <div>
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-diamante-suave text-cobalto font-bold flex items-center justify-center text-base shrink-0">
                                    {{ strtoupper(substr($usuario->nome_razao, 0, 2)) }}
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-900 text-base leading-snug line-clamp-1">{{ $usuario->nome_razao }}</h2>
                                    <span class="text-xs text-gray-400">ID #{{ $usuario->UserID }}</span>
                                </div>
                            </div>

                            @php
                                $badgeClass = match($usuario->tipo) {
                                    'Administrador' => 'bg-cobalto text-white',
                                    'Técnico'       => 'bg-diamante-suave text-cobalto border border-diamante',
                                    default         => 'bg-gray-100 text-gray-600'
                                };
                            @endphp
                            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $badgeClass }}">
                                {{ $usuario->tipo }}
                            </span>
                        </div>

                        <div class="space-y-1.5 text-sm text-gray-600 mt-4 pt-3 border-t border-gray-50">
                            <p class="flex items-center gap-2 truncate">
                                <span class="text-gray-400"></span> {{ $usuario->email }}
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="text-gray-400"></span> {{ $usuario->cpf_cnpj }}
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="text-gray-400"></span> {{ $usuario->telefone }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                        <a href="{{ route('usuario.edit', $usuario->UserID) }}" 
                           class="px-4 py-1.5 rounded-full text-xs font-semibold text-cobalto bg-diamante-suave hover:bg-[#cceeff] transition">
                            Editar
                        </a>

                        <form action="{{ route('usuario.destroy', $usuario->UserID) }}" method="POST" 
                              onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
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
                    <p class="text-gray-500 font-medium">Nenhum usuário cadastrado até o momento.</p>
                    <a href="{{ route('usuario.create') }}" class="inline-block mt-3 text-sm font-semibold text-cobalto hover:underline">
                        + Cadastrar o primeiro usuário
                    </a>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($usuario) ? 'Editar Usuário' : 'Novo Usuário' }} - IService</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F7F8FA; }
        .bg-cobalto { background-color: #0047AB; }
        .hover-bg-cobalto:hover { background-color: #003580; }
        .text-cobalto { color: #0047AB; }
        .bg-diamante-suave { background-color: #E6F7FF; }
    </style>
</head>
<body class="text-gray-800 antialiased" x-data="formMasks()">

    <header class="bg-white border-b border-gray-100 sticky top-0 z-10 shadow-sm">
        <div class="max-w-2xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('usuario.index') }}" class="flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-cobalto transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Voltar para lista
            </a>
            <span class="font-bold text-cobalto">IService</span>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100">
            
            <div class="mb-6">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-diamante-suave text-cobalto mb-2">
                    {{ isset($usuario) ? 'Atualização de Cadastro' : 'Novo Cadastro' }}
                </span>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ isset($usuario) ? 'Editar dados de ' . $usuario->nome_razao : 'Criar conta de usuário' }}
                </h1>
                <p class="text-sm text-gray-500 mt-1">Preencha os dados abaixo com atenção.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm">
                    <p class="font-bold mb-1">Ops! Verifique os campos abaixo:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($usuario) ? route('usuario.update', $usuario->UserID) : route('usuario.store') }}" method="POST" class="space-y-5">
                @csrf
                @if(isset($usuario))
                    @method('PUT')
                @endif

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Perfil</label>
                    <div class="grid grid-cols-3 gap-3" x-data="{ selected: '{{ old('tipo', $usuario->tipo ?? 'Usuário') }}' }">
                        @foreach(['Usuário', 'Técnico', 'Administrador'] as $tipoOption)
                            <label @click="selected = '{{ $tipoOption }}'"
                                   :class="selected === '{{ $tipoOption }}' ? 'bg-cobalto text-white border-[#0047AB] shadow-sm' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-diamante-suave/50'"
                                   class="cursor-pointer border rounded-2xl py-3 px-2 text-center text-sm font-semibold transition-all select-none">
                                <input type="radio" name="tipo" value="{{ $tipoOption }}" class="hidden" :checked="selected === '{{ $tipoOption }}'">
                                {{ $tipoOption }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label for="nome_razao" class="block text-sm font-semibold text-gray-700 mb-1.5">Nome Completo ou Razão Social</label>
                    <input type="text" id="nome_razao" name="nome_razao" maxlength="55" required
                           value="{{ old('nome_razao', $usuario->nome_razao ?? '') }}"
                           placeholder="Ex: João da Silva ou Tech Serviços Ltda"
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/15 transition">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">E-mail</label>
                    <input type="email" id="email" name="email" maxlength="55" required
                           value="{{ old('email', $usuario->email ?? '') }}"
                           placeholder="exemplo@email.com"
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/15 transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="cpf_cnpj" class="block text-sm font-semibold text-gray-700 mb-1.5">CPF ou CNPJ</label>
                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" maxlength="18" required
                               x-model="cpfCnpj" @input="maskCpfCnpj()"
                               placeholder="000.000.000-00"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/15 transition">
                    </div>

                    <div>
                        <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-1.5">Telefone / WhatsApp</label>
                        <input type="text" id="telefone" name="telefone" maxlength="14" required
                               x-model="telefone" @input="maskPhone()"
                               placeholder="(00)00000-0000"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/15 transition">
                    </div>
                </div>

                <div>
                    <label for="data_nascimento" class="block text-sm font-semibold text-gray-700 mb-1.5">Data de Nascimento / Fundação</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" required
                           value="{{ old('data_nascimento', isset($usuario->data_nascimento) ? $usuario->data_nascimento->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/15 transition">
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-cobalto hover-bg-cobalto text-white font-bold py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-200 text-sm">
                        {{ isset($usuario) ? 'Salvar Alterações' : 'Concluir Cadastro' }}
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- É o rodapé do formulário, com informações de copyright e links úteis -->
    <script>
        function formMasks() {
            return {
                cpfCnpj: "{{ old('cpf_cnpj', $usuario->cpf_cnpj ?? '') }}",
                telefone: "{{ old('telefone', $usuario->telefone ?? '') }}",

                maskCpfCnpj() {
                    let v = this.cpfCnpj.replace(/\D/g, '');
                    if (v.length <= 11) {
                        v = v.replace(/(\d{3})(\d)/, '$1.$2');
                        v = v.replace(/(\d{3})(\d)/, '$1.$2');
                        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    } else {
                        v = v.substring(0, 14);
                        v = v.replace(/^(\d{2})(\d)/, '$1.$2');
                        v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
                        v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
                        v = v.replace(/(\d{4})(\d)/, '$1-$2');
                    }
                    this.cpfCnpj = v;
                },

                maskPhone() {
                    let v = this.telefone.replace(/\D/g, '').substring(0, 11);
                    if (v.length > 2) {
                        v = '(' + v.substring(0, 2) + ')' + v.substring(2);
                    }
                    if (v.length > 9) {
                        v = v.substring(0, 9) + '-' + v.substring(9);
                    }
                    this.telefone = v;
                }
            }
        }
    </script>
</body>
</html>
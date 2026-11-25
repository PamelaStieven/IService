<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - IService</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAFBFC; }
        .bg-cobalto { background-color: #0047AB; }
        .hover-bg-cobalto:hover { background-color: #003580; }
        .text-cobalto { color: #0047AB; }
        .bg-diamante-suave { background-color: #E6F7FF; }
        .border-diamante { border-color: #B3E5FC; }
    </style>
</head>
<body class="text-slate-800 antialiased" x-data="registerUserForm()">

    <!-- Header Simples -->
    <header class="bg-white border-b border-slate-100 py-4 px-6">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <a href="{{ route('login') }}" class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-xl bg-cobalto flex items-center justify-center text-white font-bold text-lg shadow-sm">
                    IS
                </div>
                <span class="font-bold text-xl text-slate-900">IService</span>
            </a>

            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-600 hover:text-cobalto transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Já tem conta? Fazer Login
            </a>
        </div>
    </header>

    <main class="max-w-xl mx-auto px-4 py-10">
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-100 shadow-xl shadow-slate-200/50">
            
            <div class="mb-8 text-center">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-diamante-suave text-cobalto mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Conta de Cliente / Usuário
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Crie sua Conta Gratuita</h1>
                <p class="text-sm text-slate-500 mt-1.5 max-w-sm mx-auto">
                    Contrate manutenções especializadas e alugue equipamentos com garantia.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm">
                    <p class="font-bold mb-1">Por favor, verifique os campos:</p>
                    <ul class="list-disc list-inside space-y-0.5 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.usuario.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nome / Razão Social -->
                <div>
                    <label for="nome_razao" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nome Completo ou Razão Social
                    </label>
                    <input type="text" id="nome_razao" name="nome_razao" maxlength="55" required
                           value="{{ old('nome_razao') }}"
                           placeholder="Ex: Ana Maria Silva"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition">
                </div>

                <!-- E-mail -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Seu E-mail
                    </label>
                    <input type="email" id="email" name="email" maxlength="55" required
                           value="{{ old('email') }}"
                           placeholder="exemplo@email.com"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition">
                </div>

                <!-- Senhas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Criar Senha
                        </label>
                        <input type="password" id="password" name="password" required minlength="6"
                               placeholder="Mínimo 6 caracteres"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Confirmar Senha
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6"
                               placeholder="Repita a senha"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition">
                    </div>
                </div>

                <!-- CPF/CNPJ e Telefone -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="cpf_cnpj" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            CPF ou CNPJ
                        </label>
                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" maxlength="18" required
                               x-model="cpfCnpj" @input="maskCpfCnpj()"
                               placeholder="000.000.000-00"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition">
                    </div>

                    <div>
                        <label for="telefone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Telefone / WhatsApp
                        </label>
                        <input type="text" id="telefone" name="telefone" maxlength="14" required
                               x-model="telefone" @input="maskPhone()"
                               placeholder="(00)00000-0000"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition">
                    </div>
                </div>

                <!-- Data de Nascimento -->
                <div>
                    <label for="data_nascimento" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Data de Nascimento
                    </label>
                    <input type="date" id="data_nascimento" name="data_nascimento" required
                           value="{{ old('data_nascimento') }}"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition">
                </div>

                <!-- Termos e Botão -->
                <div class="pt-3">
                    <p class="text-xs text-slate-500 text-center mb-4">
                        Ao criar uma conta, você concorda com nossos Termos de Uso e Política de Privacidade.
                    </p>

                    <button type="submit" 
                            class="w-full bg-cobalto hover-bg-cobalto text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg shadow-blue-800/20 hover:shadow-xl hover:shadow-blue-900/30 transition-all duration-200 text-sm">
                        Concluir Cadastro de Usuário
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Deseja prestar serviços como profissional autônomo?
                    <a href="{{ route('register.tecnico') }}" class="font-bold text-cobalto hover:underline ml-1">
                        Cadastre-se como Técnico Parceiro
                    </a>
                </p>
            </div>

        </div>
    </main>

    <script>
        function registerUserForm() {
            return {
                cpfCnpj: "{{ old('cpf_cnpj', '') }}",
                telefone: "{{ old('telefone', '') }}",

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

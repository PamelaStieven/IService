<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Técnico Parceiro - IService</title>

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
<body class="text-slate-800 antialiased" x-data="registerTecnicoForm()">

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

    <main class="max-w-2xl mx-auto px-4 py-10">
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-100 shadow-xl shadow-slate-200/50">
            
            <div class="mb-8 text-center">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Credenciamento de Especialistas
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Seja um Técnico Parceiro</h1>
                <p class="text-sm text-slate-500 mt-1.5 max-w-md mx-auto">
                    Conecte-se a clientes que buscam seus serviços e receba pagamentos com total transparência e garantia.
                </p>
            </div>

            <!-- Vantagens do Técnico -->
            <div class="grid grid-cols-3 gap-3 mb-8 p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                <div>
                    <span class="block text-lg font-bold text-cobalto">100%</span>
                    <span class="text-[11px] text-slate-500 font-medium">Repasses Garantidos</span>
                </div>
                <div>
                    <span class="block text-lg font-bold text-cobalto">Flexível</span>
                    <span class="text-[11px] text-slate-500 font-medium">Seus Próprios Horários</span>
                </div>
                <div>
                    <span class="block text-lg font-bold text-cobalto">+ Demandas</span>
                    <span class="text-[11px] text-slate-500 font-medium">Clientes na sua Região</span>
                </div>
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

            <form action="{{ route('register.tecnico.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Nome / Razão Social -->
                <div>
                    <label for="nome_razao" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nome Completo ou Razão Social
                    </label>
                    <input type="text" id="nome_razao" name="nome_razao" maxlength="55" required
                           value="{{ old('nome_razao') }}"
                           placeholder="Ex: Carlos Eduardo de Oliveira"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition">
                </div>

                <!-- E-mail -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        E-mail Profissional
                    </label>
                    <input type="email" id="email" name="email" maxlength="55" required
                           value="{{ old('email') }}"
                           placeholder="tecnico@exemplo.com"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition">
                </div>

                <!-- Senhas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Criar Senha de Acesso
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
                            Telefone / WhatsApp Comercial
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
                        Data de Nascimento ou Fundação
                    </label>
                    <input type="date" id="data_nascimento" name="data_nascimento" required
                           value="{{ old('data_nascimento') }}"
                           class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition">
                </div>

                <!-- Upload de Certificado / Documento Profissional -->
                <div x-data="{ fileName: '', isDragging: false }"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="isDragging = false; fileName = $event.dataTransfer.files[0]?.name ?? ''">

                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Certificado ou Documento Profissional
                        <span class="text-slate-400 font-normal lowercase">(CREA, CRQ, Diploma técnico ou cursos)</span>
                    </label>

                    <label for="documento"
                           :class="isDragging ? 'border-[#0047AB] bg-[#E6F7FF]' : 'border-slate-200 bg-slate-50 hover:bg-blue-50/50'"
                           class="flex flex-col items-center justify-center gap-2 w-full px-4 py-8 rounded-2xl border-2 border-dashed cursor-pointer transition">
                        
                        <div class="w-12 h-12 rounded-2xl bg-white text-cobalto flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        </div>

                        <div class="text-center">
                            <p class="text-sm font-semibold text-slate-700" x-text="fileName || 'Clique aqui ou arraste seu certificado'"></p>
                            <p class="text-xs text-slate-400 mt-0.5">Formato PDF, JPG ou PNG (máx. 5 MB)</p>
                        </div>

                        <input id="documento" name="documento" type="file"
                               accept=".pdf,.jpg,.jpeg,.png"
                               class="sr-only"
                               @change="fileName = $event.target.files[0]?.name ?? ''">
                    </label>
                </div>

                <!-- Termos e Botão -->
                <div class="pt-3">
                    <p class="text-xs text-slate-500 text-center mb-4">
                        Seu perfil passará pela validação dos certificados para liberação dos agendamentos na plataforma.
                    </p>

                    <button type="submit" 
                            class="w-full bg-cobalto hover-bg-cobalto text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg shadow-blue-800/20 hover:shadow-xl hover:shadow-blue-900/30 transition-all duration-200 text-sm">
                        Cadastrar como Técnico Parceiro
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Deseja apenas contratar serviços ou alugar equipamentos?
                    <a href="{{ route('register.usuario') }}" class="font-bold text-cobalto hover:underline ml-1">
                        Cadastre-se como Usuário / Cliente
                    </a>
                </p>
            </div>

        </div>
    </main>

    <script>
        function registerTecnicoForm() {
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

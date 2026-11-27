<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IService - Assistência Técnica & Gestão de Equipamentos</title>

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
        .gradient-hero {
            background: radial-gradient(circle at top right, rgba(0, 71, 171, 0.08) 0%, transparent 60%),
                        radial-gradient(circle at bottom left, rgba(0, 149, 217, 0.07) 0%, transparent 50%);
        }
        .card-blur {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.94);
        }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-[#0047AB] selection:text-white" x-data="{ showPass: false, mobileMenu: false }">

    <!-- Top Announcement Bar -->
    <div class="bg-cobalto text-white text-xs font-semibold py-2 px-4 text-center tracking-wide">
        Conectando técnicos especialistas e clientes com segurança, garantia e agilidade em todo o Brasil.
    </div>

    <!-- Header / Navbar Landing -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                <div class="w-10 h-10 rounded-xl bg-cobalto flex items-center justify-center text-white font-extrabold text-xl shadow-md shadow-blue-900/20 group-hover:scale-105 transition duration-200">
                    IS
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-2xl tracking-tight text-slate-900 leading-none">IService</span>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-[#0047AB] mt-0.5">Soluções Técnicas</span>
                </div>
            </a>

            <!-- Menu Links (Desktop) -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="#inicio" class="hover:text-cobalto transition">Início</a>
                <a href="#servicos" class="hover:text-cobalto transition">Serviços</a>
                <a href="#como-funciona" class="hover:text-cobalto transition">Como Funciona</a>
                <a href="#profissionais" class="hover:text-cobalto transition">Para Profissionais</a>
                <a href="#sobre" class="hover:text-cobalto transition">Sobre Nós</a>
            </nav>

            <!-- Ações Direita -->
            <div class="hidden sm:flex items-center gap-3">
                <a href="{{ route('register.usuario') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-cobalto transition">
                    Cadastrar
                </a>
                <a href="#login-box" class="bg-cobalto hover-bg-cobalto text-white font-bold text-sm px-5 py-2.5 rounded-full shadow-sm shadow-blue-800/20 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Acessar Conta
                </a>
            </div>

            <!-- Hamburger Button (Mobile) -->
            <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-slate-600 hover:text-slate-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenu" x-transition class="md:hidden bg-white border-b border-slate-100 px-4 pt-2 pb-6 space-y-3">
            <a href="#inicio" @click="mobileMenu = false" class="block py-2 text-slate-700 font-medium">Início</a>
            <a href="#servicos" @click="mobileMenu = false" class="block py-2 text-slate-700 font-medium">Serviços</a>
            <a href="#como-funciona" @click="mobileMenu = false" class="block py-2 text-slate-700 font-medium">Como Funciona</a>
            <a href="#profissionais" @click="mobileMenu = false" class="block py-2 text-slate-700 font-medium">Para Profissionais</a>
            <a href="#sobre" @click="mobileMenu = false" class="block py-2 text-slate-700 font-medium">Sobre Nós</a>
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                <a href="{{ route('register.usuario') }}" class="w-full text-center py-2.5 text-sm font-bold text-cobalto bg-diamante-suave rounded-xl">
                    Cadastrar como Usuário
                </a>
                <a href="{{ route('register.tecnico') }}" class="w-full text-center py-2.5 text-sm font-bold text-slate-700 bg-slate-100 rounded-xl">
                    Cadastrar como Técnico
                </a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION + LOGIN CARD -->
    <section id="inicio" class="gradient-hero py-12 lg:py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                     class="mb-8 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-2xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="font-medium text-sm">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-700 hover:opacity-70 font-bold">&times;</button>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Coluna Esquerda: Apresentação da Plataforma -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-cobalto text-xs font-bold tracking-wide">
                        <span class="w-2 h-2 rounded-full bg-cobalto animate-pulse"></span>
                        PLATAFORMA INTEGRADA DE MANUTENÇÃO & LOCAÇÃO
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-[1.12] tracking-tight">
                        A assistência técnica certa para <span class="text-cobalto">resolver seu problema</span> com tranquilidade.
                    </h1>

                    <p class="text-lg text-slate-600 leading-relaxed max-w-2xl">
                        Conectamos você aos técnicos mais bem avaliados e credenciados do mercado. Agende consertos, manutenções preventivas ou alugue equipamentos certificados em poucos cliques.
                    </p>

                    <!-- Selos e Vantagens -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                        <div class="flex items-center gap-3 p-3 bg-white rounded-2xl border border-slate-100 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-diamante-suave text-cobalto flex items-center justify-center font-bold text-lg shrink-0">
                                ✓
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Profissionais</h4>
                                <p class="text-xs text-slate-500">100% Verificados</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-white rounded-2xl border border-slate-100 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg shrink-0">
                                ⚡
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Agilidade</h4>
                                <p class="text-xs text-slate-500">Resposta em até 24h</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-white rounded-2xl border border-slate-100 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg shrink-0">
                                🛡️
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Garantia</h4>
                                <p class="text-xs text-slate-500">Em todos os reparos</p>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de Ação para novos cadastros -->
                    <div class="pt-4 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('register.usuario') }}" 
                           class="flex-1 bg-cobalto hover-bg-cobalto text-white text-center font-bold py-3.5 px-6 rounded-2xl shadow-lg shadow-blue-800/20 transition duration-200 text-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Cadastrar como Usuário
                        </a>

                        <a href="{{ route('register.tecnico') }}" 
                           class="flex-1 bg-white hover:bg-slate-50 text-slate-800 border-2 border-slate-200 text-center font-bold py-3.5 px-6 rounded-2xl shadow-sm hover:border-[#0047AB] hover:text-cobalto transition duration-200 text-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-cobalto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Quero Ser Técnico Parceiro
                        </a>
                    </div>
                </div>

                <!-- Coluna Direita: Box de Login -->
                <div class="lg:col-span-5" id="login-box">
                    <div class="card-blur border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 relative">
                        
                        <!-- Topo do Card de Login -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-extrabold uppercase tracking-widest text-[#0047AB] bg-diamante-suave px-3 py-1 rounded-full">
                                    Área de Acesso
                                </span>
                                <span class="text-xs text-slate-400">Portal IService</span>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900">Entrar na Conta</h2>
                            <p class="text-sm text-slate-500 mt-1">Informe seu e-mail e senha para acessar o painel.</p>
                        </div>

                        <!-- Erros de validação -->
                        @if ($errors->any())
                            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm">
                                <div class="flex items-center gap-2 font-bold mb-1">
                                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    Não foi possível entrar:
                                </div>
                                <ul class="list-disc list-inside text-xs space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Formulário de Login -->
                        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    E-mail de Cadastro
                                </label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" required autofocus
                                           value="{{ old('email') }}"
                                           placeholder="seuemail@exemplo.com"
                                           class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition bg-white">
                                    <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                            </div>

                            <div>
                                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Senha de Acesso
                                </label>
                                <div class="relative">
                                    <input :type="showPass ? 'text' : 'password'" id="password" name="password" required
                                           placeholder="••••••••"
                                           class="w-full pl-11 pr-11 py-3 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-4 focus:ring-blue-500/10 transition bg-white">
                                    <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <button type="button" @click="showPass = !showPass" class="absolute right-3.5 top-3.5 text-slate-400 hover:text-slate-600 focus:outline-none">
                                        <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-xs pt-1">
                                <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600">
                                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-cobalto focus:ring-blue-500">
                                    Lembrar meu acesso
                                </label>
                                <!-- <span class="text-slate-400">Segurança SSL 256-bit</span> -->
                            </div>

                            <button type="submit" 
                                    class="w-full bg-cobalto hover-bg-cobalto text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg shadow-blue-800/20 hover:shadow-xl hover:shadow-blue-900/30 transition-all duration-200 text-sm flex items-center justify-center gap-2">
                                <span>Acessar o Painel</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </form>

                        <!-- Box Informativo do Administrador 
                        <div class="mt-5 p-3.5 bg-blue-50/70 border border-blue-100 rounded-2xl text-xs text-slate-600">
                            <div class="flex items-center gap-1.5 font-bold text-cobalto mb-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                Credencial Administrativa:
                            </div>
                            <p class="font-mono text-[11px] text-slate-700">
                                <strong>admin@iservice.com</strong> &bull; senha: <strong>admin123</strong>
                            </p>
                        </div> -->

                        <!-- Opções de cadastro rápido -->
                        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                            <p class="text-xs text-slate-500 mb-3">Ainda não possui uma conta cadastrada?</p>
                            <div class="grid grid-cols-2 gap-2 text-xs font-bold">
                                <a href="{{ route('register.usuario') }}" class="py-2.5 px-3 rounded-xl bg-diamante-suave text-cobalto hover:bg-blue-100 transition">
                                    Sou Cliente
                                </a>
                                <a href="{{ route('register.tecnico') }}" class="py-2.5 px-3 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                                    Sou Técnico
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SEÇÃO DE SERVIÇOS & EQUIPAMENTOS -->
    <section id="servicos" class="py-20 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold uppercase tracking-widest text-[#0047AB] bg-diamante-suave px-3.5 py-1.5 rounded-full">
                    Nossos Serviços
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-4 tracking-tight">
                    Tudo o que você precisa em uma única plataforma
                </h2>
                <p class="text-slate-600 mt-3 text-base">
                    Desde consertos eletrônicos e climatização até a locação de maquinários e suporte especializado.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="bg-slate-50 hover:bg-white rounded-3xl p-6 border border-slate-100 hover:border-blue-200 hover:shadow-lg transition duration-200">
                    <div class="w-12 h-12 rounded-2xl bg-cobalto text-white flex items-center justify-center font-bold text-xl mb-5 shadow-md shadow-blue-800/20">
                        ⚙️
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Manutenção Geral</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Reparo de motores, equipamentos eletrônicos, linhas brancas e dispositivos de precisão.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-50 hover:bg-white rounded-3xl p-6 border border-slate-100 hover:border-blue-200 hover:shadow-lg transition duration-200">
                    <div class="w-12 h-12 rounded-2xl bg-[#0095D9] text-white flex items-center justify-center font-bold text-xl mb-5 shadow-md shadow-cyan-800/20">
                        📦
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Locação de Equipamentos</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Ferramentas e máquinas revisadas disponíveis para aluguel diário, semanal ou mensal.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-50 hover:bg-white rounded-3xl p-6 border border-slate-100 hover:border-blue-200 hover:shadow-lg transition duration-200">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-bold text-xl mb-5 shadow-md shadow-indigo-800/20">
                        📅
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Agendamento Fácil</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Escolha o dia, horário e técnico ideal diretamente na plataforma com confirmação instantânea.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="bg-slate-50 hover:bg-white rounded-3xl p-6 border border-slate-100 hover:border-blue-200 hover:shadow-lg transition duration-200">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xl mb-5 shadow-md shadow-emerald-800/20">
                        💳
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pagamento Protegido</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Valores mantidos em segurança até a conclusão e aprovação formal do serviço prestado.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="como-funciona" class="py-16 bg-slate-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-8">
                <span class="text-xs font-extrabold uppercase tracking-widest text-cobalto">Simples e direto</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Como funciona</h2>
                <p class="text-slate-600 mt-2">Do primeiro contato à conclusão do serviço, acompanhe tudo em um só lugar.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <article class="bg-white border border-slate-200 rounded-2xl p-5">
                    <span class="text-sm font-bold text-cobalto">01</span>
                    <h3 class="font-bold text-slate-900 mt-2">Escolha o serviço</h3>
                    <p class="text-sm text-slate-600 mt-1">Encontre o atendimento ou equipamento adequado à sua necessidade.</p>
                </article>
                <article class="bg-white border border-slate-200 rounded-2xl p-5">
                    <span class="text-sm font-bold text-cobalto">02</span>
                    <h3 class="font-bold text-slate-900 mt-2">Agende com um técnico</h3>
                    <p class="text-sm text-slate-600 mt-1">Combine o horário e acompanhe o andamento do agendamento.</p>
                </article>
                <article class="bg-white border border-slate-200 rounded-2xl p-5">
                    <span class="text-sm font-bold text-cobalto">03</span>
                    <h3 class="font-bold text-slate-900 mt-2">Acompanhe até concluir</h3>
                    <p class="text-sm text-slate-600 mt-1">Consulte o histórico e os detalhes da solicitação no seu painel.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- SEÇÃO PARA TÉCNICOS PARCEIROS (BANNER CTA) -->
    <section id="profissionais" class="py-16 bg-slate-900 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-gradient-to-r from-blue-900 to-indigo-950 border border-blue-800/50 rounded-3xl p-8 sm:p-12 flex flex-col lg:flex-row items-center justify-between gap-8 shadow-2xl">
                <div class="space-y-4 max-w-2xl text-center lg:text-left">
                    <span class="inline-block px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full text-xs font-bold uppercase tracking-wider">
                        Para Técnicos & Especialistas
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                        Aumente sua renda e conquiste novos clientes todos os dias.
                    </h2>
                    <p class="text-blue-100/80 text-base leading-relaxed">
                        Envie seus certificados, cadastre suas habilidades e receba solicitações de serviço com repasse garantido e controle de recebimentos bancários.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 shrink-0">
                    <a href="{{ route('register.tecnico') }}" 
                       class="bg-white hover:bg-blue-50 text-cobalto font-bold text-base px-8 py-4 rounded-2xl shadow-lg transition duration-200 flex items-center justify-center gap-2">
                        Cadastre-se Gratuitamente
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="sobre" class="bg-white border-t border-slate-100 py-12 text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-cobalto flex items-center justify-center text-white font-bold text-sm">
                    IS
                </div>
                <span class="font-bold text-lg text-slate-900">IService</span>
                <span class="text-xs text-slate-400 ml-2">&copy; {{ date('Y') }} Todos os direitos reservados.</span>
            </div>

            <p class="max-w-md text-center md:text-left text-xs leading-relaxed">
                A IService conecta clientes, técnicos e equipamentos em um único fluxo de atendimento.
            </p>

            <div class="flex items-center gap-6 text-xs font-semibold text-slate-600">
                <a href="{{ route('register.usuario') }}" class="hover:text-cobalto transition">Cadastro de Usuário</a>
                <a href="{{ route('register.tecnico') }}" class="hover:text-cobalto transition">Cadastro de Técnico</a>
                <a href="#login-box" class="hover:text-cobalto transition">Acessar Login</a>
            </div>
        </div>
    </footer>

</body>
</html>

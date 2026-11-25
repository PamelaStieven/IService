<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $dado->exists ? 'Editar Técnico' : 'Novo Técnico' }} - IService</title>
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
            <a href="{{ route('tecnicos.index') }}" class="flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-cobalto transition">
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
                    {{ $dado->exists ? 'Atualização de Cadastro' : 'Novo Cadastro' }}
                </span>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $dado->exists ? 'Editar dados de ' . ($dado->usuario->nome_razao ?? 'Técnico') : 'Cadastrar novo técnico' }}
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

            <form action="{{ $dado->exists ? route('tecnicos.update', $dado->TecnicoID) : route('tecnicos.store') }}"
                  method="POST" class="space-y-5">
                @csrf
                @if($dado->exists)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nome_razao" class="form-label">Nome completo ou razão social *</label>
                        <input
                            type="text"
                            name="nome_razao"
                            id="nome_razao"
                            class="form-control"
                            maxlength="55"
                            value="{{ old('nome_razao', $dado->usuario->nome_razao ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail *</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            maxlength="55"
                            value="{{ old('email', $dado->usuario->email ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="cpf_cnpj" class="form-label">CPF ou CNPJ *</label>
                        <input
                            type="text"
                            name="cpf_cnpj"
                            id="cpf_cnpj"
                            class="form-control"
                            maxlength="18"
                            value="{{ old('cpf_cnpj', $dado->usuario->cpf_cnpj ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="telefone" class="form-label">Telefone *</label>
                        <input
                            type="text"
                            name="telefone"
                            id="telefone"
                            class="form-control"
                            maxlength="14"
                            value="{{ old('telefone', $dado->usuario->telefone ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="data_nascimento" class="form-label">Data de nascimento *</label>
                        <input
                            type="date"
                            name="data_nascimento"
                            id="data_nascimento"
                            class="form-control"
                            value="{{ old('data_nascimento', isset($dado->usuario->data_nascimento) ? $dado->usuario->data_nascimento->format('Y-m-d') : '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">

                        <label for="documento" class="form-label">
                            Documento
                        </label>

                        <input
                            type="file"
                            name="documento"
                            id="documento"
                            class="form-control"
                            accept=".pdf,.jpg,.jpeg,.png"
                        >

                        @if(isset($dado->TecnicoID) && !empty($dado->documento))
                            <small class="text-success">
                                Já existe um documento cadastrado.
                                Envie outro somente se desejar substituí-lo.
                            </small>
                        @endif
                        <small class="form-text text-muted">Arquivo opcional, até 60 KB.</small>

                    </div>

                </div>

                {{-- E-mail --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">E-mail</label>
                    <input type="email" id="email" name="email" maxlength="55" required
                           value="{{ old('email', $dado->usuario->email ?? '') }}"
                           placeholder="exemplo@email.com"
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/15 transition">
                </div>

                {{-- CPF/CNPJ + Telefone --}}
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
                        <input type="text" id="telefone" name="telefone" maxlength="14"
                               x-model="telefone" @input="maskPhone()"
                               placeholder="(00)00000-0000"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/15 transition">
                    </div>
                </div>

                {{-- Data de Nascimento --}}
                <div>
                    <label for="data_nascimento" class="block text-sm font-semibold text-gray-700 mb-1.5">Data de Nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento"
                           value="{{ old('data_nascimento', isset($dado->usuario->data_nascimento) ? \Carbon\Carbon::parse($dado->usuario->data_nascimento)->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/15 transition">
                </div>

                {{-- Documento (campo exclusivo do técnico) --}}
                <div>
                    <label for="documento" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Documento
                        <span class="text-gray-400 font-normal">(opcional — CREA, CRQ, etc.)</span>
                    </label>
                    <input type="text" id="documento" name="documento"
                           value="{{ old('documento', $dado->documento ?? '') }}"
                           placeholder="Ex: CREA-SP 123456"
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/15 transition">
                </div>

                {{-- Botão --}}
                <div class="pt-4">
                    <button type="submit"
                            class="w-full bg-cobalto hover-bg-cobalto text-white font-bold py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-200 text-sm">
                        {{ $dado->exists ? 'Salvar Alterações' : 'Concluir Cadastro' }}
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function formMasks() {
            return {
                cpfCnpj: "{{ old('cpf_cnpj', $dado->usuario->cpf_cnpj ?? '') }}",
                telefone: "{{ old('telefone', $dado->usuario->telefone ?? '') }}",

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

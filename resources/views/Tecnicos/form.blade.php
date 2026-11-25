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
        .border-diamante { border-color: #B3E5FC; }
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

            {{-- enctype obrigatório para upload de arquivo --}}
            <form action="{{ $dado->exists ? route('tecnicos.update', $dado->TecnicoID) : route('tecnicos.store') }}"
                  method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @if($dado->exists)
                    @method('PUT')
                @endif

                {{-- Nome --}}
                <div>
                    <label for="nome_razao" class="block text-sm font-semibold text-gray-700 mb-1.5">Nome Completo</label>
                    <input type="text" id="nome_razao" name="nome_razao" maxlength="55" required
                           value="{{ old('nome_razao', $dado->usuario->nome_razao ?? '') }}"
                           placeholder="Ex: João da Silva"
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/15 transition">
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

                {{-- Certificado / Documento --}}
                <div x-data="{ fileName: '', isDragging: false }"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="isDragging = false; fileName = $event.dataTransfer.files[0]?.name ?? ''">

                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Certificado / Documento Profissional
                        @if(!$dado->exists)
                            <span class="text-gray-400 font-normal">(opcional)</span>
                        @else
                            <span class="text-gray-400 font-normal">(deixe em branco para manter o atual)</span>
                        @endif
                    </label>

                    {{-- Prévia do certificado atual (modo edição) --}}
                    @if($dado->exists && $dado->documento)
                        <div class="mb-3 flex items-center gap-3 p-3 bg-green-50 border border-green-200 rounded-2xl">
                            <svg class="w-8 h-8 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-green-800 truncate">Certificado já enviado</p>
                                <p class="text-xs text-green-600 truncate">{{ basename($dado->documento) }}</p>
                            </div>
                            <a href="{{ route('tecnicos.certificado', $dado->TecnicoID) }}"
                               target="_blank"
                               class="text-xs font-semibold text-cobalto hover:underline whitespace-nowrap">
                                Visualizar
                            </a>
                        </div>
                    @endif

                    {{-- Área de drag-and-drop --}}
                    <label for="documento"
                           :class="isDragging ? 'border-[#0047AB] bg-[#E6F7FF]' : 'border-gray-200 bg-gray-50 hover:bg-[#f0f9ff]'"
                           class="flex flex-col items-center justify-center gap-2 w-full px-4 py-8 rounded-2xl border-2 border-dashed cursor-pointer transition">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div class="text-center">
                            <p class="text-sm font-semibold text-gray-700" x-text="fileName || 'Clique ou arraste o arquivo aqui'"></p>
                            <p class="text-xs text-gray-400 mt-0.5">PDF, JPG ou PNG · máx. 5 MB</p>
                        </div>
                        <input id="documento" name="documento" type="file"
                               accept=".pdf,.jpg,.jpeg,.png"
                               class="sr-only"
                               @change="fileName = $event.target.files[0]?.name ?? ''">
                    </label>
                </div>

                {{-- Nota sobre conta bancária --}}
                @if($dado->exists)
                    <div class="p-4 bg-diamante-suave border border-diamante rounded-2xl text-sm text-cobalto flex items-start gap-3">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="font-semibold">Dados bancários</p>
                            <p class="text-xs mt-0.5 text-blue-700">
                                Os dados bancários do técnico são gerenciados em
                                <a href="{{ route('dados-bancarios.index') }}" class="font-bold underline">Dados Bancários</a>.
                            </p>
                        </div>
                    </div>
                @endif

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

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IService - {{ !empty($dado->ItemServicoID) ? 'Editar Item de Serviço' : 'Cadastrar Item de Serviço' }}</title>

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
<body class="text-gray-800 antialiased">

    @include('navbar')

    @php
        $registro = $dado ?? $data ?? null;
        $editando = !empty($registro) && !empty($registro->ItemServicoID);
        $dataValor = old('data_item');
        if (empty($dataValor) && !empty($registro?->data_item)) {
            $dataValor = \Carbon\Carbon::parse($registro->data_item)->format('Y-m-d');
        }
    @endphp

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $editando ? 'Editar Item de Serviço' : 'Cadastrar Item de Serviço' }}
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ $editando ? 'Atualize os dados do item #' . $registro->ItemServicoID : 'Vincule um item a um agendamento e serviço.' }}
                </p>
            </div>
            <a href="{{ route('itens-servico.index') }}"
               class="text-sm font-semibold text-gray-600 hover:text-gray-900 px-4 py-2 rounded-full bg-white border border-gray-200 transition">
                Voltar
            </a>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl shadow-sm">
                <p class="font-semibold text-sm mb-1">Verifique os campos abaixo:</p>
                <ul class="list-disc list-inside text-sm space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $editando ? route('itens-servico.update', $registro->ItemServicoID) : route('itens-servico.store') }}"
              method="POST"
              class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            @csrf
            @if($editando)
                @method('PUT')
            @endif

            <div>
                <label for="AgendamentoID" class="block text-sm font-semibold text-gray-700 mb-1.5">Agendamento</label>
                <select name="AgendamentoID" id="AgendamentoID" required
                        class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/10">
                    <option value="">Selecione um agendamento...</option>
                    @foreach($agendamentos as $ag)
                        @php
                            $agId = $ag->AgendamentoID ?? $ag->AgendaID ?? $ag->id;
                            $labelAg = 'Agendamento #' . $agId
                                . (!empty($ag->data_agendamento) ? ' (' . \Carbon\Carbon::parse($ag->data_agendamento)->format('d/m/Y') . ')' : '');
                        @endphp
                        <option value="{{ $agId }}" {{ (string) old('AgendamentoID', $registro->AgendamentoID ?? '') === (string) $agId ? 'selected' : '' }}>
                            {{ $labelAg }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="ServicoID" class="block text-sm font-semibold text-gray-700 mb-1.5">Serviço</label>
                <select name="ServicoID" id="ServicoID" required
                        class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/10">
                    <option value="">Selecione um serviço...</option>
                    @foreach($servicos as $srv)
                        @php
                            $srvId = $srv->ServicoID ?? $srv->id;
                            $labelSrv = $srv->titulo ?? $srv->nome ?? $srv->descricao ?? ('Serviço #' . $srvId);
                        @endphp
                        <option value="{{ $srvId }}" {{ (string) old('ServicoID', $registro->ServicoID ?? '') === (string) $srvId ? 'selected' : '' }}>
                            {{ $labelSrv }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="data_item" class="block text-sm font-semibold text-gray-700 mb-1.5">Data do Item</label>
                <input type="date" name="data_item" id="data_item" value="{{ $dataValor }}" required
                       class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/10">
            </div>

            <div>
                <label for="descricao_item" class="block text-sm font-semibold text-gray-700 mb-1.5">Descrição do Item</label>
                <textarea name="descricao_item" id="descricao_item" rows="4" required
                          placeholder="Descreva o item ou etapa realizada..."
                          class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#0047AB] focus:ring-2 focus:ring-[#0047AB]/10">{{ old('descricao_item', $registro->descricao_item ?? '') }}</textarea>
            </div>

            <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('itens-servico.index') }}"
                   class="px-5 py-2.5 rounded-full text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-cobalto hover-bg-cobalto text-white font-semibold text-sm px-6 py-2.5 rounded-full shadow-sm transition">
                    {{ $editando ? 'Salvar Alterações' : 'Cadastrar Item' }}
                </button>
            </div>
        </form>
    </main>
</body>
</html>
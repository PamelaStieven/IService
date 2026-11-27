<section class="rounded-3xl border border-slate-200 bg-slate-50 p-4 sm:p-6"
         data-habilidades-root data-next-index="{{ count($habilidadesForm) }}">
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <span class="mb-2 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-[#0047AB]">
                Perfil profissional
            </span>
            <h2 class="text-lg font-bold text-slate-900">Habilidades e comprovantes</h2>
            <p class="mt-1 text-sm text-slate-500">Cadastre cada especialidade separadamente e anexe um comprovante, se tiver.</p>
        </div>
        <button type="button" data-add-habilidade
                class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#0047AB] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#003580] focus:outline-none focus:ring-4 focus:ring-blue-500/20">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
            </svg>
            Adicionar habilidade
        </button>
    </div>

    <div class="space-y-3" data-habilidades-list>
        @foreach ($habilidadesForm as $index => $habilidade)
            <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5" data-habilidade-card>
                <div class="mb-4 flex items-center justify-between gap-3">
                    <span class="inline-flex items-center gap-2 text-sm font-bold text-slate-800">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-xs font-extrabold text-[#0047AB]" data-habilidade-numero>{{ $index + 1 }}</span>
                        Especialidade
                    </span>
                    <button type="button" data-remove-habilidade aria-label="Remover habilidade"
                            class="rounded-lg px-3 py-1.5 text-xs font-bold text-slate-500 transition hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-40">
                        Remover
                    </button>
                </div>

                <input type="hidden" name="habilidades[{{ $index }}][id]" value="{{ $habilidade['id'] ?? '' }}">

                <div>
                    <label for="habilidade-descricao-{{ $index }}" data-habilidade-label
                           class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Nome da habilidade</label>
                    <input type="text" id="habilidade-descricao-{{ $index }}" name="habilidades[{{ $index }}][descricao]"
                           value="{{ $habilidade['descricao'] ?? '' }}" required maxlength="300"
                           placeholder="Ex.: elétrica residencial"
                           data-habilidade-descricao
                           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm transition focus:border-[#0047AB] focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                </div>

                <div class="mt-4">
                    <label for="habilidade-comprovante-{{ $index }}"
                           class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Comprovante de curso (opcional)</label>
                    <input type="file" id="habilidade-comprovante-{{ $index }}" name="habilidades[{{ $index }}][cursos]"
                           accept=".pdf,.jpg,.jpeg,.png" data-comprovante
                           class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-white file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-[#0047AB]">
                    <p class="mt-1.5 text-xs text-slate-500" data-nome-arquivo>
                        @if (!empty($habilidade['has_curso']))
                            Comprovante já cadastrado. Selecione outro arquivo para substituí-lo.
                        @else
                            PDF, JPG ou PNG; até 5 MB.
                        @endif
                    </p>
                </div>
            </article>
        @endforeach
    </div>

    <template data-habilidade-template>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5" data-habilidade-card>
            <div class="mb-4 flex items-center justify-between gap-3">
                <span class="inline-flex items-center gap-2 text-sm font-bold text-slate-800">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-xs font-extrabold text-[#0047AB]" data-habilidade-numero></span>
                    Especialidade
                </span>
                <button type="button" data-remove-habilidade aria-label="Remover habilidade"
                        class="rounded-lg px-3 py-1.5 text-xs font-bold text-slate-500 transition hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-40">
                    Remover
                </button>
            </div>

            <input type="hidden" data-field="id" value="">
            <div>
                <label data-habilidade-label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Nome da habilidade</label>
                <input type="text" data-field="descricao" data-habilidade-descricao required maxlength="300"
                       placeholder="Ex.: elétrica residencial"
                       class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm transition focus:border-[#0047AB] focus:outline-none focus:ring-4 focus:ring-blue-500/10">
            </div>
            <div class="mt-4">
                <label data-comprovante-label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Comprovante de curso (opcional)</label>
                <input type="file" data-field="cursos" data-comprovante accept=".pdf,.jpg,.jpeg,.png"
                       class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-white file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-[#0047AB]">
                <p class="mt-1.5 text-xs text-slate-500" data-nome-arquivo>PDF, JPG ou PNG; até 5 MB.</p>
            </div>
        </article>
    </template>
</section>

<script>
    (function () {
        const root = document.querySelector('[data-habilidades-root]');
        if (!root || root.dataset.initialized) return;
        root.dataset.initialized = 'true';

        const list = root.querySelector('[data-habilidades-list]');
        const template = root.querySelector('[data-habilidade-template]');
        let nextIndex = Number(root.dataset.nextIndex) || 0;

        function refreshHabilidades() {
            const cards = Array.from(list.querySelectorAll('[data-habilidade-card]'));
            cards.forEach(function (card, index) {
                card.querySelector('[data-habilidade-numero]').textContent = index + 1;
                card.querySelector('[data-remove-habilidade]').disabled = cards.length === 1;
            });
        }

        root.querySelector('[data-add-habilidade]').addEventListener('click', function () {
            const card = template.content.cloneNode(true);
            card.querySelectorAll('[data-field]').forEach(function (field) {
                field.name = 'habilidades[' + nextIndex + '][' + field.dataset.field + ']';
            });
            const inputId = 'habilidade-descricao-' + nextIndex;
            const fileId = 'habilidade-comprovante-' + nextIndex;
            card.querySelector('[data-habilidade-descricao]').id = inputId;
            card.querySelector('[data-habilidade-label]').htmlFor = inputId;
            card.querySelector('[data-comprovante]').id = fileId;
            card.querySelector('[data-comprovante-label]').htmlFor = fileId;
            nextIndex += 1;
            list.appendChild(card);
            refreshHabilidades();
            list.lastElementChild.querySelector('[data-habilidade-descricao]').focus();
        });

        list.addEventListener('click', function (event) {
            const button = event.target.closest('[data-remove-habilidade]');
            if (!button || list.querySelectorAll('[data-habilidade-card]').length === 1) return;
            button.closest('[data-habilidade-card]').remove();
            refreshHabilidades();
        });

        list.addEventListener('change', function (event) {
            if (!event.target.matches('[data-comprovante]')) return;
            const file = event.target.files[0];
            const name = event.target.closest('[data-habilidade-card]').querySelector('[data-nome-arquivo]');
            name.textContent = file ? file.name : 'PDF, JPG ou PNG; até 5 MB.';
        });

        refreshHabilidades();
    })();
</script>

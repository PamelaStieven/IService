<div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1rem">
    <a href="{{ route('relatorios.csv', $tipo) }}" style="display:inline-block;padding:.45rem .9rem;border:1px solid #198754;color:#198754;border-radius:999px;text-decoration:none;font-size:.85rem">
        Exportar CSV
    </a>
    <a href="{{ route('relatorios.listagem', $tipo) }}" style="display:inline-block;padding:.45rem .9rem;border:1px solid #0047AB;color:#0047AB;border-radius:999px;text-decoration:none;font-size:.85rem" target="_blank">
        Imprimir / Salvar PDF
    </a>
</div>

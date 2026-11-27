<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de {{ $titulo }} - IService</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { color: #1e293b; font-family: Arial, sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { font-size: 11px; }
            .table { font-size: 10px; }
        }
    </style>
</head>
<body class="bg-light">
    <main class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="javascript:window.close()" class="btn btn-outline-secondary">Fechar</a>
            <button type="button" class="btn btn-primary" onclick="window.print()">Imprimir / Salvar PDF</button>
        </div>
        <h1 class="h3 mb-1">Relatório de {{ $titulo }}</h1>
        <p class="text-muted mb-4">Gerado em {{ now()->format('d/m/Y H:i') }} · {{ $linhas->count() }} registros</p>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered bg-white">
                <thead class="table-light">
                    <tr>
                        @foreach($colunas as $rotulo)
                            <th>{{ $rotulo }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($linhas as $linha)
                        <tr>
                            @foreach(array_keys($colunas) as $chave)
                                <td>{{ $linha->{$chave} ?? '—' }}</td>
                            @endforeach
                        </tr>
                    @empty
                        <tr><td colspan="{{ count($colunas) }}" class="text-center text-muted">Nenhum registro encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

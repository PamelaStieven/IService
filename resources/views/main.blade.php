<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'iService')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Inter/Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --iservice-primary: #0077B6;
            --iservice-primary-dark: #005F91;
            --iservice-accent: #0095D9;
            --iservice-ink: #17243a;
            --iservice-muted: #64748b;
            --iservice-border: #e4eaf2;
            --iservice-surface: #ffffff;
            --iservice-background: #f4f7fb;
            --iservice-radius: 18px;
            --iservice-shadow: 0 10px 28px rgba(15, 35, 65, .06);
        }

        html {
            background: var(--iservice-background);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at 5% 0%, rgba(0, 149, 217, .045), transparent 28rem),
                var(--iservice-background);
            color: var(--iservice-ink);
            min-height: 100vh;
        }

        main.py-4 {
            padding-top: 1.75rem !important;
            padding-bottom: 3rem !important;
        }

        .container {
            --bs-gutter-x: 1.5rem;
        }

        .iservice-form-shell {
            max-width: 880px;
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--iservice-ink);
            letter-spacing: -.025em;
        }

        .text-muted {
            color: var(--iservice-muted) !important;
        }

        .card {
            background-color: var(--iservice-surface);
            border: 1px solid rgba(220, 229, 240, .82);
            border-radius: var(--iservice-radius);
            box-shadow: var(--iservice-shadow);
        }

        .card-header {
            padding: 1.15rem 1.4rem;
            border-bottom: 1px solid rgba(255, 255, 255, .16);
            border-radius: var(--iservice-radius) var(--iservice-radius) 0 0 !important;
        }

        .card-header.bg-primary {
            background: linear-gradient(115deg, #0077B6, #0095D9) !important;
            color: #fff !important;
        }

        .card-header.bg-primary h1,
        .card-header.bg-primary h2,
        .card-header.bg-primary h3,
        .card-header.bg-primary h4,
        .card-header.bg-primary h5,
        .card-header.bg-primary h6 {
            color: #fff !important;
        }

        .card-body {
            padding: 1.5rem;
        }

        .bg-primary,
        .btn-primary {
            background-color: var(--iservice-primary) !important;
            border-color: var(--iservice-primary) !important;
        }

        .btn-primary:hover,
        .btn-primary:focus-visible {
            background-color: var(--iservice-primary-dark) !important;
            border-color: var(--iservice-primary-dark) !important;
        }

        .text-primary {
            color: var(--iservice-primary) !important;
        }

        .btn {
            min-height: 40px;
            padding: .55rem 1rem;
            border-radius: 999px;
            font-weight: 600;
            letter-spacing: -.01em;
            transition: transform .16s ease, box-shadow .16s ease, background-color .16s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-sm {
            min-height: 34px;
            padding: .4rem .8rem;
        }

        .btn-outline-primary {
            color: var(--iservice-primary);
            border-color: rgba(0, 119, 182, .32);
        }

        .btn-outline-primary:hover {
            background-color: var(--iservice-primary);
            border-color: var(--iservice-primary);
        }

        .form-label {
            margin-bottom: .45rem;
            color: #34445c;
            font-size: .9rem;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            min-height: 46px;
            border: 1px solid #dce5ef;
            border-radius: 12px;
            background-color: #fff;
            color: var(--iservice-ink);
            box-shadow: 0 1px 2px rgba(15, 35, 65, .025);
            transition: border-color .16s ease, box-shadow .16s ease;
        }

        textarea.form-control {
            min-height: 112px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(0, 119, 182, .55);
            box-shadow: 0 0 0 .22rem rgba(0, 119, 182, .11);
        }

        .form-control::placeholder {
            color: #9aa8ba;
        }

        .table {
            --bs-table-color: #34445c;
            --bs-table-hover-bg: #f6f9fd;
            vertical-align: middle;
        }

        .table thead th {
            padding-top: .9rem;
            padding-bottom: .9rem;
            border-bottom-color: var(--iservice-border);
            color: #53647b;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .045em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .table td {
            padding-top: .85rem;
            padding-bottom: .85rem;
            border-color: #edf1f6;
        }

        .alert {
            border: 1px solid transparent;
            border-radius: 14px;
        }

        .alert-success {
            color: #176b48;
            background: #edf9f3;
            border-color: #ccebd9;
        }

        .alert-danger {
            color: #a23838;
            background: #fff2f1;
            border-color: #f2d1cf;
        }

        .alert-info {
            color: #155878;
            background: #edf8fc;
            border-color: #cfeaf5;
        }

        @media (max-width: 575.98px) {
            main.py-4 {
                padding-top: 1rem !important;
            }

            .card-body {
                padding: 1.15rem;
            }

            .container {
                --bs-gutter-x: 1.15rem;
            }
        }
    </style>
</head>
<body>

    <!-- Barra de Navegação Superior Unificada -->
    @include('navbar')

    <!-- Conteúdo Dinâmico -->
    <main class="py-4">
        @yield('conteudo')
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
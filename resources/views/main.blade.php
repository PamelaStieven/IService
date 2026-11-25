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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .navbar-iservice {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.8rem 2rem;
        }
        .logo-box {
            width: 40px;
            height: 40px;
            background-color: #0b5ed7;
            color: #ffffff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.15rem;
        }
        .nav-link-custom {
            color: #475569 !important;
            font-weight: 500;
            margin: 0 15px;
            font-size: 1rem;
            transition: color 0.2s;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            color: #0b5ed7 !important;
            font-weight: 600;
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
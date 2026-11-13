<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Sistema iService')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Barra de Navegação Superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('equipamentos.index') }}">iService</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('equipamentos.index') }}">Equipamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tecnicos.index') }}">Técnicos</a>       
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('servicos.index') }}">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agendamentos.index') }}">Agendamentos</a>   
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('usuario.index') }}">Usuários</a>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Dinâmico -->
    <main class="py-4">
        @yield('conteudo')
    </main>

    <!-- Bootstrap 5 JS Bundle (com Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
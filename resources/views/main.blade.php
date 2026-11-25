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

    <!-- Barra de Navegação Superior Exatamente como na Referência -->
    <nav class="navbar navbar-expand-lg navbar-iservice sticky-top">
        <div class="container-fluid px-4">
            
            <!-- Esquerda: Logo "I" + "Service" -->
            <a class="navbar-brand d-flex align-items-center text-decoration-none me-auto" href="{{ route('equipamentos.index') }}">
                <div class="logo-box me-2">I</div>
                <span class="fw-bold fs-4 text-dark tracking-tight">Service</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Centro: Links de Navegação -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('enderecos.index') }}">Endereços</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link nav-link-custom" href="{{ route('tecnicos.index') }}">Técnicos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('agendamentos.index') }}">Agendamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active" href="{{ route('equipamentos.index') }}">Equipamentos</a>
                    </li>
            
                </ul>
            </div>

            <!-- Direita: Botão de Ação Dinâmico -->
            <div class="ms-auto d-none d-lg-block">
                @yield('botao_topo')
            </div>

        </div>
    </nav>

    <!-- Conteúdo Dinâmico -->
    <main class="py-4">
        @yield('conteudo')
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
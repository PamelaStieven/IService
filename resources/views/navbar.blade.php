<style>
    html,
    body {
        overflow-x: clip;
    }

    /* IService Navbar Styles - Funciona perfeitamente com Tailwind ou Bootstrap */
    .iservice-navbar {
        background-color: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    }
    .iservice-nav-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.25rem;
        height: 4.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    .iservice-nav-brand {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        text-decoration: none !important;
        flex-shrink: 0;
    }
    .iservice-logo-box {
        width: 38px;
        height: 38px;
        background-color: #0077B6;
        color: #ffffff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 2px 4px rgba(0, 119, 182, 0.2);
    }
    .iservice-brand-text {
        font-weight: 700;
        font-size: 1.25rem;
        color: #0f172a;
        letter-spacing: -0.02em;
    }
    .iservice-nav-links {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .iservice-nav-item {
        position: relative;
    }
    .iservice-nav-link {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 0.85rem;
        font-size: 0.9rem;
        font-weight: 500;
        color: #475569 !important;
        text-decoration: none !important;
        border-radius: 9999px;
        transition: all 0.18s ease-in-out;
        white-space: nowrap;
        background: transparent;
        border: none;
        cursor: pointer;
    }
    .iservice-nav-link:hover {
        color: #0077B6 !important;
        background-color: #f1f5f9;
    }
    .iservice-nav-link.active {
        color: #0077B6 !important;
        background-color: #E6F7FF;
        font-weight: 600;
    }
    /* Mobile Toggle */
    .iservice-nav-toggle {
        display: none;
        background: #f3f7fc;
        border: 1px solid #e3eaf3;
        padding: 0.55rem;
        color: #34445c;
        cursor: pointer;
        border-radius: 0.75rem;
        line-height: 0;
        transition: background .16s ease, border-color .16s ease;
    }
    .iservice-nav-toggle:hover {
        background-color: #eaf3fb;
        border-color: #cbd9e9;
    }
    /* Mobile Menu */
    .iservice-mobile-menu {
        display: none;
        background: #ffffff;
        border-top: 1px solid #edf1f6;
        padding: 0.8rem max(1.25rem, calc((100% - 1200px) / 2)) 1.25rem;
    }
    .iservice-mobile-menu.show {
        display: block;
    }
    .iservice-mobile-link {
        display: block;
        padding: 0.65rem 0.75rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #334155 !important;
        text-decoration: none !important;
        border-radius: 0.5rem;
        transition: background 0.15s;
    }
    .iservice-mobile-link:hover, .iservice-mobile-link.active {
        background-color: #E6F7FF;
        color: #0077B6 !important;
        font-weight: 600;
    }

    .iservice-nav-actions {
        display: flex;
        align-items: center;
        gap: .75rem;
        flex-shrink: 0;
    }

    .iservice-account {
        display: flex;
        align-items: center;
        gap: .65rem;
        border-left: 1px solid #e5ebf2;
        padding-left: .85rem;
    }

    @media (max-width: 767.98px) {
        .iservice-desktop-account {
            display: none;
        }
    }

    .iservice-account-link,
    .iservice-login-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 36px;
        padding: .45rem .9rem;
        border-radius: 999px;
        background: #eaf5fb;
        color: #0077B6 !important;
        font-size: .79rem;
        font-weight: 700;
        text-decoration: none !important;
        white-space: nowrap;
        transition: background .16s ease, transform .16s ease;
    }

    .iservice-account-link:hover,
    .iservice-login-link:hover {
        background: #dceef8;
        transform: translateY(-1px);
    }

    .iservice-login-link {
        padding: .5rem 1.05rem;
        background: #0077B6;
        color: #fff !important;
    }

    .iservice-login-link:hover {
        background: #005F91;
    }

    .iservice-account-info {
        text-align: right;
        line-height: 1.2;
    }

    .iservice-user-name {
        display: block;
        max-width: 150px;
        overflow: hidden;
        color: #1e293b;
        font-size: .82rem;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .iservice-user-role {
        color: #64748b;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .iservice-logout {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        min-height: 36px;
        padding: .4rem .8rem;
        border: 1px solid #f0d7d6;
        border-radius: 999px;
        background: #fff7f6;
        color: #b54747;
        cursor: pointer;
        font-size: .78rem;
        font-weight: 700;
        transition: background .16s ease;
    }

    .iservice-logout:hover {
        background: #ffedeb;
    }

    .iservice-mobile-account {
        margin-top: .75rem;
        padding-top: .85rem;
        border-top: 1px solid #edf1f6;
    }

    .iservice-mobile-actions {
        display: flex;
        gap: .5rem;
        padding: .4rem .75rem 0;
    }

    .iservice-mobile-actions a,
    .iservice-mobile-actions button {
        flex: 1;
        justify-content: center;
        text-align: center;
    }

    .iservice-mobile-actions form {
        flex: 1;
    }

    .iservice-mobile-actions button {
        width: 100%;
    }

    @media (max-width: 1199px) {
        .iservice-nav-links {
            display: none;
        }
        .iservice-nav-toggle {
            display: block;
        }
    }

    @media (max-width: 575px) {
        .iservice-nav-container {
            height: 4rem;
            padding: 0 1rem;
        }
        .iservice-brand-text {
            font-size: 1.1rem;
        }
        .iservice-logo-box {
            width: 35px;
            height: 35px;
            border-radius: 10px;
        }
        .iservice-mobile-menu {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>

<nav class="iservice-navbar">
    <div class="iservice-nav-container">
        <!-- Logo / Marca -->
        <a href="{{ url('/') }}" class="iservice-nav-brand">
            <div class="iservice-logo-box">IS</div>
            <span class="iservice-brand-text">IService</span>
        </a>

        <!-- Links Desktop -->
        <ul class="iservice-nav-links">
            <li class="iservice-nav-item">
                <a href="{{ route('usuario.index') }}" 
                   class="iservice-nav-link {{ request()->is('usuario*') || request()->is('usuarios*') ? 'active' : '' }}">
                    Usuários
                </a>
            </li>

            <li class="iservice-nav-item">
                <a href="{{ route('tecnicos.index') }}" 
                   class="iservice-nav-link {{ request()->is('tecnico*') ? 'active' : '' }}">
                    Técnicos
                </a>
            </li>

            <li class="iservice-nav-item">
                <a href="{{ route('equipamentos.index') }}" 
                   class="iservice-nav-link {{ request()->is('equipamento*') ? 'active' : '' }}">
                    Equipamentos
                </a>
            </li>

            <li class="iservice-nav-item">
                <a href="{{ route('servicos.index') }}" 
                   class="iservice-nav-link {{ request()->is('servico*') ? 'active' : '' }}">
                    Serviços
                </a>
            </li>

            <li class="iservice-nav-item">
                <a href="{{ route('agendamentos.index') }}" 
                   class="iservice-nav-link {{ request()->is('agendamento*') ? 'active' : '' }}">
                    Agendamentos
                </a>
            </li>

            <li class="iservice-nav-item">
                <a href="{{ route('modulos.index') }}"
                   class="iservice-nav-link {{ request()->is('modulos*') ? 'active' : '' }}">
                    Módulos
                </a>
            </li>
        </ul>

        <div class="iservice-nav-actions">
            @if(Auth::check())
                @php
                    $painelRoute = match(Auth::user()->tipo) {
                        'Técnico'       => route('tecnico.dashboard'),
                        'Administrador' => route('dashboard.graficos'),
                        default         => route('cliente.dashboard')
                    };
                @endphp
                <div class="iservice-account iservice-desktop-account">
                    <a href="{{ $painelRoute }}" class="iservice-account-link" title="Acessar meu painel">
                        Meu Painel
                    </a>
                    <div class="iservice-account-info">
                        <span class="iservice-user-name">
                            {{ Auth::user()->nome_razao }}
                        </span>
                        <span class="iservice-user-role">
                            {{ Auth::user()->tipo }}
                        </span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="iservice-logout" title="Sair da conta">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Sair</span>
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="iservice-login-link">
                    Entrar
                </a>
            @endif

            <button type="button" class="iservice-nav-toggle" onclick="toggleIserviceMobileMenu(this)" aria-label="Abrir menu"
                    aria-controls="iserviceMobileMenu" aria-expanded="false">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div class="iservice-mobile-menu" id="iserviceMobileMenu">
        <a href="{{ route('usuario.index') }}" class="iservice-mobile-link {{ request()->is('usuario*') || request()->is('usuarios*') ? 'active' : '' }}">Usuários</a>
        <a href="{{ route('tecnicos.index') }}" class="iservice-mobile-link {{ request()->is('tecnico*') ? 'active' : '' }}">Técnicos</a>
        <a href="{{ route('equipamentos.index') }}" class="iservice-mobile-link {{ request()->is('equipamento*') ? 'active' : '' }}">Equipamentos</a>
        <a href="{{ route('servicos.index') }}" class="iservice-mobile-link {{ request()->is('servico*') ? 'active' : '' }}">Serviços</a>
        <a href="{{ route('agendamentos.index') }}" class="iservice-mobile-link {{ request()->is('agendamento*') ? 'active' : '' }}">Agendamentos</a>
        <a href="{{ route('modulos.index') }}" class="iservice-mobile-link {{ request()->is('modulos*') ? 'active' : '' }}">Módulos por categoria</a>

        @if(Auth::check())
            <div class="iservice-mobile-account">
                <div style="padding: 0 0.75rem 0.4rem;">
                    <span class="iservice-user-name" style="max-width:none">
                        {{ Auth::user()->nome_razao }}
                    </span>
                    <span class="iservice-user-role">
                        {{ Auth::user()->tipo }}
                    </span>
                </div>
                <div class="iservice-mobile-actions">
                    <a href="{{ $painelRoute }}" class="iservice-account-link">Meu painel</a>
                    <form action="{{ route('logout') }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="iservice-logout w-100">Sair da conta</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</nav>

<script>
    function toggleIserviceMobileMenu(button) {
        var mobileMenu = document.getElementById('iserviceMobileMenu');
        if (mobileMenu) {
            var isOpen = mobileMenu.classList.toggle('show');
            button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            button.setAttribute('aria-label', isOpen ? 'Fechar menu' : 'Abrir menu');
        }
    }

</script>

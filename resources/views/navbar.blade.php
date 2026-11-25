<style>
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
        background-color: #0047AB;
        color: #ffffff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 2px 4px rgba(0, 71, 171, 0.25);
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
        color: #0047AB !important;
        background-color: #f1f5f9;
    }
    .iservice-nav-link.active {
        color: #0047AB !important;
        background-color: #E6F7FF;
        font-weight: 600;
    }
    /* Dropdown */
    .iservice-dropdown-menu {
        display: none;
        position: absolute;
        top: calc(100% + 0.4rem);
        right: 0;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        padding: 0.5rem;
        min-width: 190px;
        z-index: 1050;
    }
    .iservice-dropdown-menu.show {
        display: block;
    }
    .iservice-dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 0.85rem;
        font-size: 0.875rem;
        color: #334155 !important;
        text-decoration: none !important;
        border-radius: 0.65rem;
        transition: background-color 0.15s;
    }
    .iservice-dropdown-item:hover {
        background-color: #f8fafc;
        color: #0047AB !important;
    }
    .iservice-dropdown-item.active {
        background-color: #E6F7FF;
        color: #0047AB !important;
        font-weight: 600;
    }
    /* Mobile Toggle */
    .iservice-nav-toggle {
        display: none;
        background: none;
        border: none;
        padding: 0.5rem;
        color: #334155;
        cursor: pointer;
        border-radius: 0.5rem;
    }
    .iservice-nav-toggle:hover {
        background-color: #f1f5f9;
    }
    /* Mobile Menu */
    .iservice-mobile-menu {
        display: none;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        padding: 0.75rem 1.25rem 1.25rem;
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
        color: #0047AB !important;
        font-weight: 600;
    }

    @media (max-width: 991px) {
        .iservice-nav-links {
            display: none;
        }
        .iservice-nav-toggle {
            display: block;
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
                <a href="{{ route('locacoes-equipamentos.index') }}" 
                   class="iservice-nav-link {{ request()->is('locac*') ? 'active' : '' }}">
                    Locações
                </a>
            </li>

            <li class="iservice-nav-item">
                <a href="{{ route('enderecos.index') }}" 
                   class="iservice-nav-link {{ request()->is('endereco*') ? 'active' : '' }}">
                    Endereços
                </a>
            </li>

            <!-- Dropdown Mais -->
            @php
                $isMaisActive = request()->is('dashboard/graficos*') ||
                                request()->is('relatorios*') ||
                                request()->is('itens-servico*') || 
                                request()->is('pagamento*') || 
                                request()->is('dados-bancario*') || 
                                request()->is('dadosbancarios*') || 
                                request()->is('habilidade*');
            @endphp
            <li class="iservice-nav-item" id="iserviceDropdownContainer">
                <button type="button" 
                        class="iservice-nav-link {{ $isMaisActive ? 'active' : '' }}" 
                        onclick="toggleIserviceDropdown(event)">
                    <span>Mais</span>
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="iservice-dropdown-menu" id="iserviceDropdownMenu">
                    <a href="{{ route('dashboard.graficos') }}" 
                       class="iservice-dropdown-item {{ request()->is('dashboard/graficos*') ? 'active' : '' }}">
                        📊 Gráficos & Métricas
                    </a>
                    <a href="{{ route('relatorios.index') }}" 
                       class="iservice-dropdown-item {{ request()->is('relatorios*') ? 'active' : '' }}">
                        📑 Relatório Financeiro
                    </a>
                    <div style="border-top: 1px solid #f1f5f9; margin: 0.35rem 0;"></div>
                    <a href="{{ route('pagamentos.index') }}" 
                       class="iservice-dropdown-item {{ request()->is('pagamento*') ? 'active' : '' }}">
                        Pagamentos
                    </a>
                    <a href="{{ route('itens-servico.index') }}" 
                       class="iservice-dropdown-item {{ request()->is('itens-servico*') ? 'active' : '' }}">
                        Itens de Serviço
                    </a>
                    <a href="{{ route('dados-bancarios.index') }}" 
                       class="iservice-dropdown-item {{ request()->is('dados-bancario*') || request()->is('dadosbancarios*') ? 'active' : '' }}">
                        Dados Bancários
                    </a>
                    <a href="{{ route('habilidades.index') }}" 
                       class="iservice-dropdown-item {{ request()->is('habilidade*') ? 'active' : '' }}">
                        Habilidades
                    </a>
                </div>
            </li>
        </ul>

        <!-- Botão Ação Topo Opcional, Usuário Logado e Toggle Mobile -->
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            @hasSection('botao_topo')
                <div class="d-none d-lg-block">
                    @yield('botao_topo')
                </div>
            @endif

            @if(Auth::check())
                @php
                    $painelRoute = match(Auth::user()->tipo) {
                        'Técnico'       => route('tecnico.dashboard'),
                        'Administrador' => route('dashboard.graficos'),
                        default         => route('cliente.dashboard')
                    };
                @endphp
                <div class="d-none d-md-flex align-items-center" style="gap: 0.6rem; border-left: 1px solid #e2e8f0; padding-left: 0.85rem;">
                    <a href="{{ $painelRoute }}" 
                       style="background: #E6F7FF; color: #0047AB; border-radius: 9999px; padding: 0.35rem 0.85rem; font-size: 0.8rem; font-weight: 700; text-decoration: none;"
                       title="Acessar meu painel">
                        Meu Painel
                    </a>
                    <div style="text-align: right; line-height: 1.2;">
                        <span style="font-size: 0.85rem; font-weight: 700; color: #1e293b; display: block;">
                            {{ Auth::user()->nome_razao }}
                        </span>
                        <span style="font-size: 0.7rem; font-weight: 600; color: #0047AB; text-transform: uppercase;">
                            {{ Auth::user()->tipo }}
                        </span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" 
                                style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; border-radius: 9999px; padding: 0.35rem 0.85rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem;"
                                title="Sair da Conta">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Sair</span>
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" 
                   style="background: #0047AB; color: #ffffff; border-radius: 9999px; padding: 0.45rem 1.15rem; font-size: 0.85rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                    Entrar
                </a>
            @endif

            <button type="button" class="iservice-nav-toggle" onclick="toggleIserviceMobileMenu()" aria-label="Abrir Menu">
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
        <a href="{{ route('locacoes-equipamentos.index') }}" class="iservice-mobile-link {{ request()->is('locac*') ? 'active' : '' }}">Locações</a>
        <a href="{{ route('enderecos.index') }}" class="iservice-mobile-link {{ request()->is('endereco*') ? 'active' : '' }}">Endereços</a>
        <div style="border-top: 1px solid #f1f5f9; margin: 0.5rem 0; padding-top: 0.5rem;">
            <span style="font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; padding: 0 0.75rem;">Análises & Gestão</span>
            <a href="{{ route('dashboard.graficos') }}" class="iservice-mobile-link {{ request()->is('dashboard/graficos*') ? 'active' : '' }}">📊 Gráficos & Métricas</a>
            <a href="{{ route('relatorios.index') }}" class="iservice-mobile-link {{ request()->is('relatorios*') ? 'active' : '' }}">📑 Relatório Financeiro</a>
            <span style="font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; padding: 0 0.75rem; display: block; margin-top: 0.5rem;">Outros Módulos</span>
            <a href="{{ route('itens-servico.index') }}" class="iservice-mobile-link {{ request()->is('itens-servico*') ? 'active' : '' }}">Itens de Serviço</a>
            <a href="{{ route('pagamentos.index') }}" class="iservice-mobile-link {{ request()->is('pagamento*') ? 'active' : '' }}">Pagamentos</a>
            <a href="{{ route('dados-bancarios.index') }}" class="iservice-mobile-link {{ request()->is('dados-bancario*') || request()->is('dadosbancarios*') ? 'active' : '' }}">Dados Bancários</a>
            <a href="{{ route('habilidades.index') }}" class="iservice-mobile-link {{ request()->is('habilidade*') ? 'active' : '' }}">Habilidades</a>
        </div>

        @if(Auth::check())
            <div style="border-top: 1px solid #f1f5f9; margin-top: 0.75rem; padding-top: 0.75rem;">
                <div style="padding: 0 0.75rem 0.5rem;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: #1e293b; display: block;">
                        {{ Auth::user()->nome_razao }}
                    </span>
                    <span style="font-size: 0.75rem; color: #0047AB; font-weight: 600;">
                        Perfil: {{ Auth::user()->tipo }}
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="iservice-mobile-link" style="width: 100%; text-align: left; background: none; border: none; color: #dc2626 !important; font-weight: 600;">
                        Sair da Conta
                    </button>
                </form>
            </div>
        @else
            <div style="border-top: 1px solid #f1f5f9; margin-top: 0.75rem; padding-top: 0.75rem;">
                <a href="{{ route('login') }}" class="iservice-mobile-link" style="color: #0047AB !important; font-weight: 700;">
                    Fazer Login
                </a>
            </div>
        @endif
    </div>
</nav>

<script>
    function toggleIserviceDropdown(event) {
        event.stopPropagation();
        var menu = document.getElementById('iserviceDropdownMenu');
        if (menu) {
            menu.classList.toggle('show');
        }
    }

    function toggleIserviceMobileMenu() {
        var mobileMenu = document.getElementById('iserviceMobileMenu');
        if (mobileMenu) {
            mobileMenu.classList.toggle('show');
        }
    }

    // Fecha dropdown ao clicar fora
    document.addEventListener('click', function(e) {
        var menu = document.getElementById('iserviceDropdownMenu');
        var container = document.getElementById('iserviceDropdownContainer');
        if (menu && container && !container.contains(e.target)) {
            menu.classList.remove('show');
        }
    });
</script>

<?php

namespace App\Http\Controllers;

class ModuleController extends Controller
{
    private function categorias(): array
    {
        return [
            'cadastros' => [
                'titulo' => 'Cadastros',
                'descricao' => 'Gerencie usuários, profissionais e recursos cadastrados.',
                'modulos' => [
                    ['nome' => 'Usuários', 'descricao' => 'Administradores e clientes.', 'route' => 'usuario.index'],
                    ['nome' => 'Técnicos', 'descricao' => 'Perfis, habilidades e dados bancários.', 'route' => 'tecnicos.index'],
                    ['nome' => 'Equipamentos', 'descricao' => 'Equipamentos, conservação e diárias.', 'route' => 'equipamentos.index'],
                    ['nome' => 'Endereços', 'descricao' => 'Endereços cadastrados na plataforma.', 'route' => 'enderecos.index'],
                    ['nome' => 'Habilidades', 'descricao' => 'Habilidades profissionais dos técnicos.', 'route' => 'habilidades.index'],
                ],
            ],
            'operacoes' => [
                'titulo' => 'Operações',
                'descricao' => 'Acompanhe serviços, agendas e locações.',
                'modulos' => [
                    ['nome' => 'Serviços', 'descricao' => 'Catálogo de serviços oferecidos.', 'route' => 'servicos.index'],
                    ['nome' => 'Agendamentos', 'descricao' => 'Horários, clientes e técnicos.', 'route' => 'agendamentos.index'],
                    ['nome' => 'Itens de serviço', 'descricao' => 'Itens executados nos agendamentos.', 'route' => 'itens-servico.index'],
                    ['nome' => 'Locações', 'descricao' => 'Locações de equipamentos.', 'route' => 'locacoes-equipamentos.index'],
                ],
            ],
            'financeiro' => [
                'titulo' => 'Financeiro',
                'descricao' => 'Consulte pagamentos e consolidados financeiros.',
                'modulos' => [
                    ['nome' => 'Pagamentos', 'descricao' => 'Transações e situação dos pagamentos.', 'route' => 'pagamentos.index'],
                    ['nome' => 'Dados bancários', 'descricao' => 'Contas vinculadas aos técnicos.', 'route' => 'dados-bancarios.index'],
                    ['nome' => 'Relatório financeiro', 'descricao' => 'Faturamento, taxas e repasses.', 'route' => 'relatorios.index'],
                ],
            ],
            'analises' => [
                'titulo' => 'Análises',
                'descricao' => 'Visualize indicadores e relatórios da plataforma.',
                'modulos' => [
                    ['nome' => 'Gráficos e métricas', 'descricao' => 'Indicadores de operação e receita.', 'route' => 'dashboard.graficos'],
                    ['nome' => 'Relatório financeiro', 'descricao' => 'Consolidado de pagamentos e serviços.', 'route' => 'relatorios.index'],
                ],
            ],
        ];
    }

    public function index()
    {
        $categorias = $this->categorias();

        return view('hubs.index', compact('categorias'));
    }

    public function show(string $categoria)
    {
        $categorias = $this->categorias();
        abort_unless(isset($categorias[$categoria]), 404);
        $grupo = $categorias[$categoria];

        return view('hubs.show', compact('categoria', 'grupo', 'categorias'));
    }
}

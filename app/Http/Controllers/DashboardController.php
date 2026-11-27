<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Tecnicos;
use App\Models\Agendamento;
use App\Models\Servico;
use App\Models\Pagamento;
use App\Models\LocacaoEquip;
use App\Models\Habilidade;
use App\Models\DadosBancarios;
use App\Models\Enderecos;
use App\Services\CalculadoraFinanceiraServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tela / Dashboard exclusivo para o Cliente (Usuário).
     */
    public function cliente()
    {
        $user = Auth::user();

        // Agendamentos solicitados pelo cliente logado
        $agendamentos = Agendamento::where('UserID', $user ? $user->UserID : 0)
            ->with(['tecnico.usuario', 'servico'])
            ->orderBy('data_hora_inicio', 'desc')
            ->get();

        // Locações de equipamentos do cliente
        $locacoes = LocacaoEquip::where('UserID', $user ? $user->UserID : 0)
            ->with('pagamento')
            ->orderBy('data_retirada', 'desc')
            ->get();

        $enderecos = Enderecos::where('userID', $user ? $user->UserID : 0)
            ->orderBy('apelido')
            ->get();

        // Métricas rápidas
        $metricas = [
            'total_agendamentos' => $agendamentos->count(),
            'concluidos'         => $agendamentos->where('status_servico', 'Concluido')->count(),
            'pendentes'          => $agendamentos->whereIn('status_servico', ['Pendente', 'Aceito'])->count(),
            'total_locacoes'     => $locacoes->count(),
        ];

        return view('dashboard.cliente', compact('user', 'agendamentos', 'locacoes', 'enderecos', 'metricas'));
    }

    /**
     * Tela / Dashboard exclusivo para o Técnico Parceiro.
     */
    public function tecnico()
    {
        $user = Auth::user();

        // Busca o registro de técnico vinculado
        $tecnico = null;
        if ($user) {
            $tecnico = Tecnicos::where('UserID', $user->UserID)
                ->with(['usuario', 'dadosBancarios', 'habilidades'])
                ->first();
        }

        // Se for admin testando, pega o primeiro técnico se o usuário logado não for técnico
        if (!$tecnico && $user && $user->tipo === 'Administrador') {
            $tecnico = Tecnicos::with(['usuario', 'dadosBancarios', 'habilidades'])->first();
        }

        $agendamentos = collect();
        $servicos = collect();

        if ($tecnico) {
            $agendamentos = Agendamento::where('TecnicoID', $tecnico->TecnicoID)
                ->with(['usuario', 'servico'])
                ->orderBy('data_hora_inicio', 'desc')
                ->get();

            $servicos = Servico::where('TecnicoID', $tecnico->TecnicoID)->get();
        }

        $metricas = [
            'total_trabalhos' => $agendamentos->count(),
            'concluidos'      => $agendamentos->where('status_servico', 'Concluido')->count(),
            'pendentes'       => $agendamentos->whereIn('status_servico', ['Pendente', 'Aceito'])->count(),
            'total_servicos'  => $servicos->count(),
            'tem_banco'       => $tecnico && $tecnico->dadosBancarios ? true : false,
            'tem_certificado' => $tecnico && !empty($tecnico->documento),
        ];

        return view('dashboard.tecnico', compact('user', 'tecnico', 'agendamentos', 'servicos', 'metricas'));
    }

    /**
     * Tela de Gráficos e Métricas (Trabalhos Realizados e Técnicos X Usuários).
     */
    public function graficos(CalculadoraFinanceiraServico $calculadora)
    {
        // 1. Quantia de Técnicos X Usuários X Administradores
        $totalTecnicos = Usuario::where('tipo', 'Técnico')->count();
        $totalUsuarios = Usuario::where('tipo', 'Usuário')->count();
        $totalAdmins   = Usuario::where('tipo', 'Administrador')->count();

        // 2. Trabalhos Realizados por Status
        $statusCounts = Agendamento::select('status_servico', DB::raw('count(*) as total'))
            ->groupBy('status_servico')
            ->pluck('total', 'status_servico')
            ->toArray();

        $statusLabels = ['Concluido', 'Aceito', 'Pendente', 'Cancelado'];
        $statusData = [];
        foreach ($statusLabels as $s) {
            $statusData[] = $statusCounts[$s] ?? 0;
        }

        // 3. Serviços por Categoria
        $categorias = Servico::select('categoria', DB::raw('count(*) as total'))
            ->groupBy('categoria')
            ->pluck('total', 'categoria')
            ->toArray();

        // 4. Métodos de Pagamento (PIX vs Boleto) e Totais
        $pagamentosMetodo = Pagamento::select('metodo', DB::raw('count(*) as qtd'), DB::raw('sum(valor_total) as total'))
            ->groupBy('metodo')
            ->get();

        $pagamentosConfirmados = Pagamento::where('status_pagamento', true);
        $faturamentoConfirmado = (clone $pagamentosConfirmados)->sum('valor_total');
        $taxaConfirmada = (clone $pagamentosConfirmados)
            ->selectRaw('COALESCE(SUM(COALESCE(comissao_empresa, taxa_site)), 0) as total')
            ->value('total');
        $faturamentoMes = (clone $pagamentosConfirmados)
            ->whereMonth('data_pagamento', now()->month)
            ->whereYear('data_pagamento', now()->year)
            ->sum('valor_total');
        $comissaoServicosTotalCentavos = 0;
        $comissaoServicosRecebidaCentavos = 0;
        $comissaoServicosPendenteCentavos = 0;
        $agendamentosConcluidos = Agendamento::with(['servico', 'pagamento'])
            ->where('status_servico', 'Concluido')
            ->get();
        foreach ($agendamentosConcluidos as $agendamento) {
            $comissao = $agendamento->pagamento
                ? (float) ($agendamento->pagamento->comissao_empresa ?? $agendamento->pagamento->taxa_site)
                : (float) $calculadora->calcular($agendamento)['comissao_empresa'];
            $comissaoCentavos = (int) round($comissao * 100);

            $comissaoServicosTotalCentavos += $comissaoCentavos;
            if ($agendamento->pagamento && $agendamento->pagamento->status_pagamento) {
                $comissaoServicosRecebidaCentavos += $comissaoCentavos;
            } else {
                $comissaoServicosPendenteCentavos += $comissaoCentavos;
            }
        }
        $comissaoServicosTotal = $comissaoServicosTotalCentavos / 100;
        $comissaoServicosRecebida = $comissaoServicosRecebidaCentavos / 100;
        $comissaoServicosPendente = $comissaoServicosPendenteCentavos / 100;
        $pagamentosRecentes = Pagamento::with(['agendamento.usuario', 'locacaoEquip.usuario'])
            ->orderByDesc('data_pagamento')
            ->limit(8)
            ->get();

        // Totais gerais para KPI cards
        $kpi = [
            'total_usuarios'     => $totalUsuarios,
            'total_tecnicos'     => $totalTecnicos,
            'total_agendamentos' => Agendamento::count(),
            'total_servicos'     => Servico::count(),
            'total_faturamento'  => $faturamentoConfirmado,
            'total_taxa_site'    => $taxaConfirmada,
            'total_repasses'     => $faturamentoConfirmado - $taxaConfirmada,
            'faturamento_mes'    => $faturamentoMes,
            'comissao_servicos_total' => $comissaoServicosTotal,
            'comissao_servicos_recebida' => $comissaoServicosRecebida,
            'comissao_servicos_pendente' => $comissaoServicosPendente,
        ];

        return view('dashboard.graficos', compact(
            'totalTecnicos',
            'totalUsuarios',
            'totalAdmins',
            'statusLabels',
            'statusData',
            'categorias',
            'pagamentosMetodo',
            'kpi',
            'pagamentosRecentes'
        ));
    }

    /**
     * Relatório detalhado e consolidado de Pagamentos e Serviços.
     */
    public function relatorios(Request $request)
    {
        $metodoFiltro = $request->input('metodo');
        $categoriaFiltro = $request->input('categoria');

        // Relatório de Pagamentos
        $pagamentos = Pagamento::with(['agendamento.usuario', 'agendamento.servico', 'locacaoEquip.usuario'])
            ->when(!empty($metodoFiltro), function ($query) use ($metodoFiltro) {
                $query->where('metodo', $metodoFiltro);
            })
            ->orderBy('data_pagamento', 'desc')
            ->get();

        // Relatório de Serviços
        $servicos = Servico::with('tecnico.usuario')
            ->when(!empty($categoriaFiltro), function ($query) use ($categoriaFiltro) {
                $query->where('categoria', $categoriaFiltro);
            })
            ->get();

        // Categorias disponíveis para filtro
        $todasCategorias = Servico::select('categoria')->distinct()->pluck('categoria');

        // Totais Consolidados
        $faturamentoTotal = $pagamentos->sum('valor_total');
        $taxaSiteTotal    = $pagamentos->sum(function ($pagamento) {
            return $pagamento->comissao_empresa ?? $pagamento->taxa_site;
        });
        $repassesTecnico  = $faturamentoTotal - $taxaSiteTotal;

        return view('dashboard.relatorios', compact(
            'pagamentos',
            'servicos',
            'todasCategorias',
            'metodoFiltro',
            'categoriaFiltro',
            'faturamentoTotal',
            'taxaSiteTotal',
            'repassesTecnico'
        ));
    }
}

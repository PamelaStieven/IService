<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function show(string $tipo)
    {
        [$titulo, $colunas, $linhas] = $this->dados($tipo);

        return view('relatorios.listagem', compact('titulo', 'colunas', 'linhas'));
    }

    public function csv(string $tipo)
    {
        [$titulo, $colunas, $linhas] = $this->dados($tipo);
        $nome = 'relatorio-' . $tipo . '-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($colunas, $linhas) {
            $arquivo = fopen('php://output', 'w');
            fwrite($arquivo, "\xEF\xBB\xBF");
            fputcsv($arquivo, array_values($colunas), ';');

            foreach ($linhas as $linha) {
                $valores = [];
                foreach (array_keys($colunas) as $chave) {
                    $valor = (string) ($linha->{$chave} ?? '');
                    if (preg_match('/^\s*[=+\-@]/', $valor)) {
                        $valor = "'" . $valor;
                    }
                    $valores[] = $valor;
                }
                fputcsv($arquivo, $valores, ';');
            }

            fclose($arquivo);
        }, $nome, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function dados(string $tipo): array
    {
        switch ($tipo) {
            case 'usuarios':
                $colunas = ['id' => 'ID', 'nome' => 'Nome', 'email' => 'E-mail', 'documento' => 'CPF/CNPJ', 'telefone' => 'Telefone', 'tipo' => 'Perfil'];
                $linhas = DB::table('usuario')
                    ->whereIn('tipo', ['Administrador', 'Usuário'])
                    ->select('UserID as id', 'nome_razao as nome', 'email', 'cpf_cnpj as documento', 'telefone', 'tipo')
                    ->orderBy('nome_razao')->get();
                return ['Usuários', $colunas, $linhas];

            case 'tecnicos':
                $colunas = ['id' => 'ID', 'nome' => 'Técnico', 'email' => 'E-mail', 'documento' => 'CPF/CNPJ', 'telefone' => 'Telefone', 'certificado' => 'Certificado'];
                $linhas = DB::table('tecnicos')
                    ->join('usuario', 'usuario.UserID', '=', 'tecnicos.UserID')
                    ->select('tecnicos.TecnicoID as id', 'usuario.nome_razao as nome', 'usuario.email', 'usuario.cpf_cnpj as documento', 'usuario.telefone')
                    ->selectRaw("CASE WHEN tecnicos.documento IS NULL OR tecnicos.documento = '' THEN 'Não' ELSE 'Sim' END as certificado")
                    ->orderBy('usuario.nome_razao')->get();
                return ['Técnicos', $colunas, $linhas];

            case 'equipamentos':
                $colunas = ['id' => 'ID', 'nome' => 'Equipamento', 'modelo' => 'Modelo', 'conservacao' => 'Conservação', 'diaria' => 'Valor da diária', 'status' => 'Status'];
                $linhas = DB::table('equipamentos')
                    ->select('EquipID as id', 'nome', 'modelo', 'estado_conservacao as conservacao', 'valor_diaria as diaria', 'status')
                    ->orderBy('nome')->get();
                return ['Equipamentos', $colunas, $linhas];

            case 'enderecos':
                $colunas = ['id' => 'ID', 'usuario' => 'Usuário', 'apelido' => 'Identificação', 'rua' => 'Rua', 'numero' => 'Número', 'bairro' => 'Bairro', 'cidade' => 'Cidade', 'estado' => 'Estado', 'cep' => 'CEP'];
                $linhas = DB::table('enderecos')
                    ->leftJoin('usuario', 'usuario.UserID', '=', 'enderecos.userID')
                    ->select('enderecos.EnderecosID as id', 'usuario.nome_razao as usuario', 'enderecos.apelido', 'enderecos.rua', 'enderecos.numero', 'enderecos.bairro', 'enderecos.cidade', 'enderecos.estado', 'enderecos.cep')
                    ->orderBy('usuario')->get();
                return ['Endereços', $colunas, $linhas];

            case 'servicos':
                $colunas = ['id' => 'ID', 'titulo' => 'Serviço', 'categoria' => 'Categoria', 'tecnico' => 'Técnico', 'preco' => 'Preço base', 'tipo_preco' => 'Tipo de preço'];
                $linhas = DB::table('servico')
                    ->leftJoin('tecnicos', 'tecnicos.TecnicoID', '=', 'servico.TecnicoID')
                    ->leftJoin('usuario', 'usuario.UserID', '=', 'tecnicos.UserID')
                    ->select('servico.ServicoID as id', 'servico.titulo', 'servico.categoria', 'usuario.nome_razao as tecnico', 'servico.preco_base as preco', 'servico.tipo_preco')
                    ->orderBy('servico.titulo')->get();
                return ['Serviços', $colunas, $linhas];

            case 'agendamentos':
                $colunas = ['id' => 'ID', 'cliente' => 'Cliente', 'tecnico' => 'Técnico', 'servico' => 'Serviço', 'inicio' => 'Início', 'fim' => 'Fim', 'status' => 'Status'];
                $linhas = DB::table('agendamento')
                    ->leftJoin('usuario as cliente', 'cliente.UserID', '=', 'agendamento.UserID')
                    ->leftJoin('tecnicos', 'tecnicos.TecnicoID', '=', 'agendamento.TecnicoID')
                    ->leftJoin('usuario as tecnico', 'tecnico.UserID', '=', 'tecnicos.UserID')
                    ->leftJoin('servico', 'servico.ServicoID', '=', 'agendamento.ServicoID')
                    ->select('agendamento.AgendamentoID as id', 'cliente.nome_razao as cliente', 'tecnico.nome_razao as tecnico', 'servico.titulo as servico', 'agendamento.data_hora_inicio as inicio', 'agendamento.data_hora_fim as fim', 'agendamento.status_servico as status')
                    ->orderByDesc('agendamento.data_hora_inicio')->get();
                return ['Agendamentos', $colunas, $linhas];

            case 'itens-servico':
                $colunas = ['id' => 'ID', 'agendamento' => 'Agendamento', 'servico' => 'Serviço', 'descricao' => 'Descrição', 'data' => 'Data'];
                $linhas = DB::table('itemservico')
                    ->leftJoin('servico', 'servico.ServicoID', '=', 'itemservico.ServicoID')
                    ->select('itemservico.ItemServicoID as id', 'itemservico.AgendamentoID as agendamento', 'servico.titulo as servico', 'itemservico.descricao_item as descricao', 'itemservico.data_item as data')
                    ->orderByDesc('itemservico.data_item')->get();
                return ['Itens de serviço', $colunas, $linhas];

            case 'pagamentos':
                $colunas = ['id' => 'ID', 'agendamento' => 'Agendamento', 'locacao' => 'Locação', 'metodo' => 'Método', 'valor' => 'Valor total', 'taxa' => 'Taxa da plataforma', 'status' => 'Pago', 'data' => 'Data do pagamento'];
                $linhas = DB::table('pagamentos')
                    ->select('PagamentoID as id', 'AgendamentoID as agendamento', 'LocEquipID as locacao', 'metodo', 'valor_total as valor')
                    ->selectRaw('COALESCE(comissao_empresa, taxa_site) as taxa')
                    ->selectRaw("CASE WHEN status_pagamento = 1 THEN 'Sim' ELSE 'Não' END as status")
                    ->addSelect('data_pagamento as data')
                    ->orderByDesc('data_pagamento')->get();
                return ['Pagamentos', $colunas, $linhas];

            case 'locacoes':
                $colunas = ['id' => 'ID', 'usuario' => 'Usuário', 'equipamento' => 'Equipamento', 'retirada' => 'Retirada', 'devolucao' => 'Devolução'];
                $linhas = DB::table('locacao_equips')
                    ->leftJoin('usuario', 'usuario.UserID', '=', 'locacao_equips.UserID')
                    ->leftJoin('equipamentos', 'equipamentos.EquipID', '=', 'locacao_equips.EquipID')
                    ->select('locacao_equips.LocEquipID as id', 'usuario.nome_razao as usuario', 'equipamentos.nome as equipamento', 'locacao_equips.data_retirada as retirada', 'locacao_equips.data_devolucao as devolucao')
                    ->orderByDesc('locacao_equips.data_retirada')->get();
                return ['Locações de equipamentos', $colunas, $linhas];

            case 'dados-bancarios':
                $colunas = ['id' => 'ID', 'tecnico' => 'Técnico', 'banco' => 'Banco', 'agencia' => 'Agência', 'conta' => 'Número da conta', 'tipo' => 'Tipo de conta', 'titular' => 'Titular', 'documento' => 'CPF/CNPJ do titular'];
                $linhas = DB::table('dados_bancarios')
                    ->leftJoin('tecnicos', 'tecnicos.TecnicoID', '=', 'dados_bancarios.TecnicoID')
                    ->leftJoin('usuario', 'usuario.UserID', '=', 'tecnicos.UserID')
                    ->select('dados_bancarios.ContaID as id', 'usuario.nome_razao as tecnico', 'dados_bancarios.banco', 'dados_bancarios.agencia', 'dados_bancarios.numero_conta as conta', 'dados_bancarios.tipo_conta as tipo', 'dados_bancarios.titular', 'dados_bancarios.cpf_cnpj_titular as documento')
                    ->orderBy('usuario.nome_razao')->get();
                return ['Dados bancários', $colunas, $linhas];

            case 'habilidades':
                $colunas = ['id' => 'ID', 'tecnico' => 'Técnico', 'descricao' => 'Habilidade'];
                $linhas = DB::table('habilidade')
                    ->leftJoin('tecnicos', 'tecnicos.TecnicoID', '=', 'habilidade.TecnicoID')
                    ->leftJoin('usuario', 'usuario.UserID', '=', 'tecnicos.UserID')
                    ->select('habilidade.HabilidadeID as id', 'usuario.nome_razao as tecnico', 'habilidade.descricao')
                    ->orderBy('usuario.nome_razao')->get();
                return ['Habilidades', $colunas, $linhas];

            default:
                abort(404);
        }
    }
}

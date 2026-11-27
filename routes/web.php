<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\TecnicosController;
use App\Http\Controllers\EnderecosController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\ItemServicoController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\LocacaoEquipController;
use App\Http\Controllers\DadosBancariosController;
use App\Http\Controllers\HabilidadeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ModuleController;

// --- AUTENTICAÇÃO E LANDING PAGE ---
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Cadastro Público (Distinto do formulário administrativo)
Route::get('/cadastrar/usuario', [AuthController::class, 'showRegisterUsuario'])->name('register.usuario');
Route::post('/cadastrar/usuario', [AuthController::class, 'registerUsuario'])->name('register.usuario.submit');
Route::get('/cadastrar/tecnico', [AuthController::class, 'showRegisterTecnico'])->name('register.tecnico');
Route::post('/cadastrar/tecnico', [AuthController::class, 'registerTecnico'])->name('register.tecnico.submit');

// --- DASHBOARDS ESPECÍFICOS & ANÁLISES & RELATÓRIOS ---
Route::middleware('auth')->get('/dashboard/cliente', [DashboardController::class, 'cliente'])->name('cliente.dashboard');
Route::get('/dashboard/tecnico', [DashboardController::class, 'tecnico'])->name('tecnico.dashboard');
Route::get('/dashboard/graficos', [DashboardController::class, 'graficos'])->name('dashboard.graficos');
Route::get('/relatorios', [DashboardController::class, 'relatorios'])->name('relatorios.index');
Route::get('/relatorios/listagem/{tipo}/csv', [ReportController::class, 'csv'])->name('relatorios.csv');
Route::get('/relatorios/listagem/{tipo}', [ReportController::class, 'show'])->name('relatorios.listagem');
Route::get('/modulos', [ModuleController::class, 'index'])->name('modulos.index');
Route::get('/modulos/{categoria}', [ModuleController::class, 'show'])->name('modulos.show');

Route::get('usuario/search', [UsuarioController::class, 'search'])->name('usuario.search');
Route::get('usuario/{id}/foto', [UsuarioController::class, 'foto'])->name('usuario.foto');
Route::resource('usuario', UsuarioController::class)->except(['show']);
Route::get('usuario/{usuario}/enderecos', [EnderecosController::class, 'usuarioIndex'])->name('usuario.enderecos.index');
Route::get('usuario/{usuario}/enderecos/criar', [EnderecosController::class, 'usuarioCreate'])->name('usuario.enderecos.create');
Route::post('usuario/{usuario}/enderecos', [EnderecosController::class, 'usuarioStore'])->name('usuario.enderecos.store');
Route::get('usuarios/search', [UsuarioController::class, 'search'])->name('usuarios.search');
Route::resource('usuarios', UsuarioController::class)->except(['show']);

Route::get('equipamentos/search', [EquipamentoController::class, 'search'])->name('equipamentos.search');
Route::get('equipamentos/{id}/imagem', [EquipamentoController::class, 'imagem'])->name('equipamentos.imagem');
Route::resource('equipamentos', EquipamentoController::class)->except(['show']);

Route::get('tecnicos/search', [TecnicosController::class, 'search'])->name('tecnicos.search');
Route::get('tecnicos/{tecnico}/certificado', [TecnicosController::class, 'certificado'])->name('tecnicos.certificado');
Route::get('tecnicos/{id}/dados-bancarios', [TecnicosController::class, 'dadosBancarios'])->name('tecnicos.dados-bancarios');
Route::resource('tecnicos', TecnicosController::class)->except(['show']);

Route::get('enderecos/search', [EnderecosController::class, 'search'])->name('enderecos.search');
Route::resource('enderecos', EnderecosController::class)->except(['show']);
Route::middleware('auth')->prefix('minha-conta/enderecos')->name('cliente.enderecos.')->group(function () {
    Route::get('/', [EnderecosController::class, 'clienteIndex'])->name('index');
    Route::post('/', [EnderecosController::class, 'clienteStore'])->name('store');
    Route::get('/{id}/editar', [EnderecosController::class, 'clienteEdit'])->name('edit');
    Route::put('/{id}', [EnderecosController::class, 'clienteUpdate'])->name('update');
    Route::delete('/{id}', [EnderecosController::class, 'clienteDestroy'])->name('destroy');
});

Route::get('servicos/search', [ServicoController::class, 'search'])->name('servicos.search');
Route::resource('servicos', ServicoController::class)->except(['show']);
Route::get('servico/search', [ServicoController::class, 'search'])->name('servico.search');
Route::resource('servico', ServicoController::class)->except(['show']);

Route::get('agendamentos/search', [AgendamentoController::class, 'search'])->name('agendamentos.search');
Route::resource('agendamentos', AgendamentoController::class)
    ->parameters(['agendamentos' => 'agendamento:AgendamentoID']);

Route::get('itens-servico/search', [ItemServicoController::class, 'search'])->name('itens-servico.search');
Route::resource('itens-servico', ItemServicoController::class)->except(['show']);

Route::get('pagamentos/search', [PagamentoController::class, 'search'])->name('pagamentos.search');
Route::resource('pagamentos', PagamentoController::class)->except(['show']);

Route::get('locacoes-equipamentos/search', [LocacaoEquipController::class, 'search'])->name('locacoes-equipamentos.search');
Route::resource('locacoes-equipamentos', LocacaoEquipController::class)->except(['show']);

Route::get('dados-bancarios/search', [DadosBancariosController::class, 'search'])->name('dados-bancarios.search');
Route::resource('dados-bancarios', DadosBancariosController::class)->except(['show']);

Route::get('habilidades/search', [HabilidadeController::class, 'search'])->name('habilidades.search');
Route::resource('habilidades', HabilidadeController::class)->except(['show']);


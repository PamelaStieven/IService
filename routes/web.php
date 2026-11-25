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

// --- AUTENTICAÇÃO E LANDING PAGE ---
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']);

// Cadastro Público (Distinto do formulário administrativo)
Route::get('/cadastrar/usuario', [AuthController::class, 'showRegisterUsuario'])->name('register.usuario');
Route::post('/cadastrar/usuario', [AuthController::class, 'registerUsuario'])->name('register.usuario.submit');
Route::get('/cadastrar/tecnico', [AuthController::class, 'showRegisterTecnico'])->name('register.tecnico');
Route::post('/cadastrar/tecnico', [AuthController::class, 'registerTecnico'])->name('register.tecnico.submit');

// --- DASHBOARDS ESPECÍFICOS & ANÁLISES & RELATÓRIOS ---
Route::get('/dashboard/cliente', [DashboardController::class, 'cliente'])->name('cliente.dashboard');
Route::get('/dashboard/tecnico', [DashboardController::class, 'tecnico'])->name('tecnico.dashboard');
Route::get('/dashboard/graficos', [DashboardController::class, 'graficos'])->name('dashboard.graficos');
Route::get('/relatorios', [DashboardController::class, 'relatorios'])->name('relatorios.index');

Route::get('usuario/search', [UsuarioController::class, 'search'])->name('usuario.search');
Route::resource('usuario', UsuarioController::class);
Route::get('usuarios/search', [UsuarioController::class, 'search'])->name('usuarios.search');
Route::resource('usuarios', UsuarioController::class);

Route::get('equipamentos/search', [EquipamentoController::class, 'search'])->name('equipamentos.search');
Route::resource('equipamentos', EquipamentoController::class);

Route::get('tecnicos/search', [TecnicosController::class, 'search'])->name('tecnicos.search');
Route::get('tecnicos/{tecnico}/certificado', [TecnicosController::class, 'certificado'])->name('tecnicos.certificado');
Route::resource('tecnicos', TecnicosController::class);

Route::get('enderecos/search', [EnderecosController::class, 'search'])->name('enderecos.search');
Route::resource('enderecos', EnderecosController::class);

Route::get('servicos/search', [ServicoController::class, 'search'])->name('servicos.search');
Route::resource('servicos', ServicoController::class);
Route::get('servico/search', [ServicoController::class, 'search'])->name('servico.search');
Route::resource('servico', ServicoController::class);

Route::get('agendamentos/search', [AgendamentoController::class, 'search'])->name('agendamentos.search');
Route::resource('agendamentos', AgendamentoController::class)->parameters([
    'agendamentos' => 'agendamento:AgendamentoID'
]);

Route::get('itens-servico/search', [ItemServicoController::class, 'search'])->name('itens-servico.search');
Route::resource('itens-servico', ItemServicoController::class);

Route::get('pagamentos/search', [PagamentoController::class, 'search'])->name('pagamentos.search');
Route::resource('pagamentos', PagamentoController::class);

Route::get('locacoes-equipamentos/search', [LocacaoEquipController::class, 'search'])->name('locacoes-equipamentos.search');
Route::resource('locacoes-equipamentos', LocacaoEquipController::class);

Route::get('dados-bancarios/search', [DadosBancariosController::class, 'search'])->name('dados-bancarios.search');
Route::resource('dados-bancarios', DadosBancariosController::class);
Route::get('dadosbancarios/search', [DadosBancariosController::class, 'search'])->name('dadosbancarios.search');
Route::resource('dadosbancarios', DadosBancariosController::class);
Route::get('dados_bancarios/search', [DadosBancariosController::class, 'search'])->name('dados_bancarios.search');
Route::resource('dados_bancarios', DadosBancariosController::class);

Route::get('habilidades/search', [HabilidadeController::class, 'search'])->name('habilidades.search');
Route::resource('habilidades', HabilidadeController::class);


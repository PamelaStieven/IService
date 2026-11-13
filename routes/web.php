<?php

use Illuminate\Support\Facades\Route;

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

// Página Inicial
Route::get('/', function () {
    return view('welcome');
});

// --- USUÁRIOS ---
Route::get('usuarios/search', [UsuarioController::class, 'search'])->name('usuarios.search');
Route::resource('usuarios', UsuarioController::class);

// --- EQUIPAMENTOS ---
Route::get('equipamentos/search', [EquipamentoController::class, 'search'])->name('equipamentos.search');
Route::resource('equipamentos', EquipamentoController::class);

// ---TÉCNICOS ---
Route::get('tecnicos/search', [TecnicosController::class, 'search'])->name('tecnicos.search');
Route::resource('tecnicos', TecnicosController::class);

// --- ENDEREÇOS ---
Route::get('enderecos/search', [EnderecosController::class, 'search'])->name('enderecos.search');
Route::resource('enderecos', EnderecosController::class);

// --- SERVIÇOS ---
Route::get('servicos/search', [ServicoController::class, 'search'])->name('servicos.search');
Route::resource('servicos', ServicoController::class);

// --- AGENDAMENTOS ---
Route::get('agendamentos/search', [AgendamentoController::class, 'search'])->name('agendamentos.search');
Route::resource('agendamentos', AgendamentoController::class);

// --- ITENS DE SERVIÇO ---
Route::get('itens-servico/search', [ItemServicoController::class, 'search'])->name('itens-servico.search');
Route::resource('itens-servico', ItemServicoController::class);

// --- PAGAMENTOS ---
Route::get('pagamentos/search', [PagamentoController::class, 'search'])->name('pagamentos.search');
Route::resource('pagamentos', PagamentoController::class);

// --- LOCAÇÕES DE EQUIPAMENTOS ---
Route::get('locacoes-equipamentos/search', [LocacaoEquipController::class, 'search'])->name('locacoes-equipamentos.search');
Route::resource('locacoes-equipamentos', LocacaoEquipController::class);

// --- DADOS BANCÁRIOS ---
Route::get('dados-bancarios/search', [DadosBancariosController::class, 'search'])->name('dados-bancarios.search');
Route::resource('dados-bancarios', DadosBancariosController::class);

// --- HABILIDADES ---
Route::get('habilidades/search', [HabilidadeController::class, 'search'])->name('habilidades.search');
Route::resource('habilidades', HabilidadeController::class);
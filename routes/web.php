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

Route::get('/', [App\Http\Controllers\UsuarioController::class, 'index']);

Route::get('usuarios/search', [UsuarioController::class, 'search'])->name('usuarios.search');
Route::resource('usuarios', UsuarioController::class);

Route::get('equipamentos/search', [EquipamentoController::class, 'search'])->name('equipamentos.search');
Route::resource('equipamentos', EquipamentoController::class);

Route::get('tecnicos/search', [TecnicosController::class, 'search'])->name('tecnicos.search');
Route::resource('tecnicos', TecnicosController::class);

Route::get('enderecos/search', [EnderecosController::class, 'search'])->name('enderecos.search');
Route::resource('enderecos', EnderecosController::class);

Route::get('servicos/search', [ServicoController::class, 'search'])->name('servicos.search');
Route::resource('servicos', ServicoController::class);

Route::get('agendamentos/search', [AgendamentoController::class, 'search'])->name('agendamentos.search');
Route::resource('agendamentos', AgendamentoController::class);

Route::get('itens-servico/search', [ItemServicoController::class, 'search'])->name('itens-servico.search');
Route::resource('itens-servico', ItemServicoController::class);

Route::get('pagamentos/search', [PagamentoController::class, 'search'])->name('pagamentos.search');
Route::resource('pagamentos', PagamentoController::class);

Route::get('locacoes-equipamentos/search', [LocacaoEquipController::class, 'search'])->name('locacoes-equipamentos.search');
Route::resource('locacoes-equipamentos', LocacaoEquipController::class);

Route::get('dados-bancarios/search', [DadosBancariosController::class, 'search'])->name('dados-bancarios.search');
Route::resource('dados-bancarios', DadosBancariosController::class);

Route::get('habilidades/search', [HabilidadeController::class, 'search'])->name('habilidades.search');
Route::resource('habilidades', HabilidadeController::class);
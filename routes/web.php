<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipamentosController;
use App\Http\Controllers\TecnicosController;
use App\Http\Controllers\EnderecosController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\ItemServicoController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\LocacaoEquipController;
use App\Http\Controllers\DadosBancariosController;
use App\Http\Controllers\HabilidadeController;


Route::get('/', function () {return view('welcome');});
Route::resource('users', UsuarioController::class);
Route::resource('equipamentos', EquipamentosController::class);
Route::resource('tecnicos', TecnicosController::class);
Route::resource('enderecos', EnderecosController::class);
Route::resource('servicos', ServicoController::class);
Route::resource('agendamentos', AgendamentoController::class);
Route::resource('itens-servico', ItemServicoController::class);
Route::resource('pagamentos', PagamentoController::class);
Route::resource('locacoes-equipamentos', LocacaoEquipController::class);
Route::resource('dados-bancarios', DadosBancariosController::class);
Route::resource('habilidades', HabilidadeController::class);


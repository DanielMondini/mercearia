<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitacaoCotacaoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AccessLinkController;
use App\Http\Controllers\CotacaoController;
use App\Http\Controllers\DashboardController;

// Rota inicial ou home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rotas para Solicitação de Cotação
Route::prefix('solicitacoes')->name('solicitacoes.')->group(function () {
    Route::get('/', [SolicitacaoCotacaoController::class, 'index'])->name('index');
    Route::get('/create', [SolicitacaoCotacaoController::class, 'create'])->name('create');
    Route::post('/', [SolicitacaoCotacaoController::class, 'store'])->name('store');

    Route::get('/{solicitacao}', [SolicitacaoCotacaoController::class, 'show'])->name('show');
    Route::get('/{solicitacao}/edit', [SolicitacaoCotacaoController::class, 'edit'])->name('edit');
    Route::put('/{solicitacao}', [SolicitacaoCotacaoController::class, 'update'])->name('update');
    Route::delete('/{solicitacao}', [SolicitacaoCotacaoController::class, 'destroy'])->name('destroy');

    Route::get('/{solicitacao}/dashboard', [SolicitacaoCotacaoController::class, 'dashboard'])->name('dashboard');
});
Route::post('solicitacoes/{solicitacao}/adicionar-fornecedores', [SolicitacaoCotacaoController::class, 'adicionarFornecedores'])->name('solicitacoes.adicionarFornecedores');
Route::post('solicitacoes/{solicitacao}/adicionar-item', [SolicitacaoCotacaoController::class, 'adicionarItem'])->name('solicitacoes.adicionarItem');

// Rotas para Cotações dos Fornecedores
Route::get('/cotacao/{token}', [CotacaoController::class, 'formCotacao'])->name('cotacao.formCotacao');
Route::post('/cotacao/{token}', [CotacaoController::class, 'salvarCotacao'])->name('cotacao.salvarCotacao');

// Rotas para Fornecedores
Route::resource('fornecedores', FornecedorController::class);

// Rotas para Itens
Route::resource('itens', ItemController::class);

// Rotas para Access Links
Route::get('links', [AccessLinkController::class, 'listarLinks'])->name('links.index');
Route::get('gerar-links', [AccessLinkController::class, 'gerarLinks'])->name('gerar.links');

// Rota para o dashboard principal
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rotas adicionais (se houver)
// ...

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SincronizacaoController;
use App\Http\Controllers\ProdutoController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sincronizar/produtos', [SincronizacaoController::class, 'sincronizarProdutos']);
Route::post('/sincronizar/precos', [SincronizacaoController::class, 'sincronizarPrecos']);
Route::get('/produtos/lista', [ProdutoController::class, 'lista']);
Route::post('/produtos', [ProdutoController::class, 'store']);

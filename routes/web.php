<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('sincronizacao');
});

Route::get('/cadastro-produto', function () {
    return view('cadastro-produto');
});

Route::get('/editar-produto/{id}', function ($id) {
    return view('cadastro-produto', ['produtoId' => $id]);
});

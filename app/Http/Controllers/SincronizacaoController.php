<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SincronizacaoService;
use Illuminate\Http\JsonResponse;

class SincronizacaoController extends Controller
{
    protected $sincronizacaoService;

    public function __construct(SincronizacaoService $sincronizacaoService)
    {
        $this->sincronizacaoService = $sincronizacaoService;
    }

    public function sincronizarProdutos(): JsonResponse
    {
        $resultado = $this->sincronizacaoService->sincronizarProdutos();
        
        return response()->json($resultado, $resultado['sucesso'] ? 200 : 500);
    }

    public function sincronizarPrecos(): JsonResponse
    {
        $resultado = $this->sincronizacaoService->sincronizarPrecos();
        
        return response()->json($resultado, $resultado['sucesso'] ? 200 : 500);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoInsercao;
use Illuminate\Http\JsonResponse;

class ProdutoController extends Controller
{
    public function lista(): JsonResponse
    {
        $produtos = ProdutoInsercao::with('precos')->get();
        
        $produtosFormatados = $produtos->map(function ($produto) {
            return [
                'id' => $produto->id,
                'codigo' => $produto->codigo,
                'nome' => $produto->nome,
                'categoria' => $produto->categoria,
                'subcategoria' => $produto->subcategoria,
                'descricao' => $produto->descricao,
                'fabricante' => $produto->fabricante,
                'modelo' => $produto->modelo,
                'cor' => $produto->cor,
                'peso' => $produto->peso,
                'largura' => $produto->largura,
                'altura' => $produto->altura,
                'profundidade' => $produto->profundidade,
                'unidade' => $produto->unidade,
                'data_cadastro' => $produto->data_cadastro,
                'precos' => $produto->precos->map(function ($preco) {
                    return [
                        'id' => $preco->id,
                        'valor' => $preco->valor,
                        'moeda' => $preco->moeda,
                        'desconto_percentual' => $preco->desconto_percentual,
                        'acrescimo_percentual' => $preco->acrescimo_percentual,
                        'valor_promocional' => $preco->valor_promocional,
                        'data_inicio_promocao' => $preco->data_inicio_promocao,
                        'data_fim_promocao' => $preco->data_fim_promocao,
                        'tipo_cliente' => $preco->tipo_cliente,
                        'origem' => $preco->origem,
                        'vendedor_responsavel' => $preco->vendedor_responsavel,
                        'observacoes' => $preco->observacoes,
                    ];
                }),
            ];
        });

        return response()->json([
            'sucesso' => true,
            'produtos' => $produtosFormatados,
            'total' => $produtosFormatados->count()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ProdutoInsercao;
use App\Models\PrecoInsercao;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function store(StoreProdutoRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $dadosProduto = $request->only([
                'codigo',
                'nome',
                'categoria',
                'subcategoria',
                'descricao',
                'fabricante',
                'modelo',
                'cor',
                'peso',
                'largura',
                'altura',
                'profundidade',
                'unidade',
                'data_cadastro'
            ]);

            if (!isset($dadosProduto['data_cadastro'])) {
                $dadosProduto['data_cadastro'] = now()->toDateString();
            }

            $produto = ProdutoInsercao::create($dadosProduto);

            $dadosPreco = $request->input('preco');
            $dadosPreco['codigo_produto'] = $produto->codigo;
            $dadosPreco['data_atualizacao'] = now();

            $preco = PrecoInsercao::create($dadosPreco);

            DB::commit();

            $produto->load('precos');

            $produtoFormatado = [
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

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Produto cadastrado com sucesso.',
                'dados' => $produtoFormatado
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erro ao cadastrar produto', [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Erro ao cadastrar produto. Tente novamente.',
                'erro' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $produto = ProdutoInsercao::with('precos')->find($id);

            if (!$produto) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Produto não encontrado.'
                ], 404);
            }

            $produtoFormatado = [
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

            return response()->json([
                'sucesso' => true,
                'dados' => $produtoFormatado
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar produto', [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Erro ao buscar produto. Tente novamente.',
                'erro' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function update(UpdateProdutoRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $produto = ProdutoInsercao::find($id);

            if (!$produto) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Produto não encontrado.'
                ], 404);
            }

            $dadosProduto = $request->only([
                'codigo',
                'nome',
                'categoria',
                'subcategoria',
                'descricao',
                'fabricante',
                'modelo',
                'cor',
                'peso',
                'largura',
                'altura',
                'profundidade',
                'unidade',
                'data_cadastro'
            ]);

            $produto->update($dadosProduto);

            $dadosPreco = $request->input('preco');
            $dadosPreco['codigo_produto'] = $produto->codigo;
            $dadosPreco['data_atualizacao'] = now();

            $precoExistente = PrecoInsercao::where('codigo_produto', $produto->codigo)->first();

            if ($precoExistente) {
                $precoExistente->update($dadosPreco);
            } else {
                PrecoInsercao::create($dadosPreco);
            }

            DB::commit();

            $produto->load('precos');

            $produtoFormatado = [
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

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Produto atualizado com sucesso.',
                'dados' => $produtoFormatado
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erro ao atualizar produto', [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar produto. Tente novamente.',
                'erro' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}

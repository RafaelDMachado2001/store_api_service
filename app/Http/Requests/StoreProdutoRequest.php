<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => [
                'required',
                'string',
                'max:30',
                Rule::unique('produto_insercao', 'codigo')
            ],
            'nome' => [
                'required',
                'string',
                'max:150'
            ],
            'categoria' => [
                'required',
                'string',
                'max:50'
            ],
            'subcategoria' => [
                'nullable',
                'string',
                'max:50'
            ],
            'descricao' => [
                'nullable',
                'string'
            ],
            'fabricante' => [
                'nullable',
                'string',
                'max:100'
            ],
            'modelo' => [
                'nullable',
                'string',
                'max:50'
            ],
            'cor' => [
                'nullable',
                'string',
                'max:30'
            ],
            'peso' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999.999'
            ],
            'largura' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999.99'
            ],
            'altura' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999.99'
            ],
            'profundidade' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999.99'
            ],
            'unidade' => [
                'nullable',
                'string',
                'max:10'
            ],
            'data_cadastro' => [
                'nullable',
                'date'
            ],
            'preco' => [
                'required',
                'array'
            ],
            'preco.valor' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999999.99'
            ],
            'preco.moeda' => [
                'required',
                'string',
                'max:10'
            ],
            'preco.desconto_percentual' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100'
            ],
            'preco.acrescimo_percentual' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100'
            ],
            'preco.valor_promocional' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999999999.99'
            ],
            'preco.data_inicio_promocao' => [
                'nullable',
                'date'
            ],
            'preco.data_fim_promocao' => [
                'nullable',
                'date',
                'after_or_equal:preco.data_inicio_promocao'
            ],
            'preco.origem' => [
                'nullable',
                'string',
                'max:50'
            ],
            'preco.tipo_cliente' => [
                'nullable',
                'string',
                'max:30'
            ],
            'preco.vendedor_responsavel' => [
                'nullable',
                'string',
                'max:100'
            ],
            'preco.observacoes' => [
                'nullable',
                'string'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'O código do produto é obrigatório.',
            'codigo.unique' => 'Este código de produto já está em uso.',
            'codigo.max' => 'O código do produto não pode ter mais de 30 caracteres.',
            'nome.required' => 'O nome do produto é obrigatório.',
            'nome.max' => 'O nome do produto não pode ter mais de 150 caracteres.',
            'categoria.required' => 'A categoria do produto é obrigatória.',
            'categoria.max' => 'A categoria não pode ter mais de 50 caracteres.',
            'preco.required' => 'As informações de preço são obrigatórias.',
            'preco.array' => 'O preço deve ser um objeto.',
            'preco.valor.required' => 'O valor do preço é obrigatório.',
            'preco.valor.numeric' => 'O valor do preço deve ser um número.',
            'preco.valor.min' => 'O valor do preço não pode ser negativo.',
            'preco.moeda.required' => 'A moeda é obrigatória.',
            'preco.moeda.max' => 'A moeda não pode ter mais de 10 caracteres.',
            'preco.data_fim_promocao.after_or_equal' => 'A data de fim da promoção deve ser igual ou posterior à data de início.'
        ];
    }
}


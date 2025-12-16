<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecoInsercao extends Model
{
    use HasFactory;

    protected $table = 'preco_insercao';

    protected $fillable = [
        'codigo_produto',
        'valor',
        'moeda',
        'desconto_percentual',
        'acrescimo_percentual',
        'valor_promocional',
        'data_inicio_promocao',
        'data_fim_promocao',
        'data_atualizacao',
        'origem',
        'tipo_cliente',
        'vendedor_responsavel',
        'observacoes',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'desconto_percentual' => 'decimal:2',
        'acrescimo_percentual' => 'decimal:2',
        'valor_promocional' => 'decimal:2',
        'data_inicio_promocao' => 'date',
        'data_fim_promocao' => 'date',
        'data_atualizacao' => 'datetime',
    ];

    public function produto()
    {
        return $this->belongsTo(ProdutoInsercao::class, 'codigo_produto', 'codigo');
    }
}

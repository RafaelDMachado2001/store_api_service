<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoInsercao extends Model
{
    use HasFactory;

    protected $table = 'produto_insercao';

    protected $fillable = [
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
        'data_cadastro',
    ];

    protected $casts = [
        'peso' => 'decimal:3',
        'largura' => 'decimal:2',
        'altura' => 'decimal:2',
        'profundidade' => 'decimal:2',
        'data_cadastro' => 'date',
    ];

    public function precos()
    {
        return $this->hasMany(PrecoInsercao::class, 'codigo_produto', 'codigo');
    }
}

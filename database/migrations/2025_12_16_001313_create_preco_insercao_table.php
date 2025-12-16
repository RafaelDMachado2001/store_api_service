<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preco_insercao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_produto', 30);
            $table->decimal('valor', 15, 2)->nullable();
            $table->string('moeda', 10)->default('BRL');
            $table->decimal('desconto_percentual', 5, 2)->nullable();
            $table->decimal('acrescimo_percentual', 5, 2)->nullable();
            $table->decimal('valor_promocional', 15, 2)->nullable();
            $table->date('data_inicio_promocao')->nullable();
            $table->date('data_fim_promocao')->nullable();
            $table->dateTime('data_atualizacao')->nullable();
            $table->string('origem', 50)->nullable();
            $table->string('tipo_cliente', 30)->nullable();
            $table->string('vendedor_responsavel', 100)->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            $table->index('codigo_produto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preco_insercao');
    }
};

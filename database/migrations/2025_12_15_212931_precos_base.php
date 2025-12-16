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
        Schema::create('precos_base', function (Blueprint $table) {
            $table->bigIncrements('preco_id');
            $table->string('prc_cod_prod', 30);
            $table->text('prc_valor')->default(0);
            $table->string('prc_moeda', 10);
            $table->text('prc_desc')->nullable();
            $table->text('prc_acres')->nullable();
            $table->text('prc_promo')->nullable();
            $table->text('prc_dt_ini_promo')->nullable();
            $table->text('prc_dt_fim_promo')->nullable();
            $table->text('prc_dt_atual')->nullable();
            $table->string('prc_origem', 50)->nullable();
            $table->string('prc_tipo_cli', 30)->nullable();
            $table->string('prc_vend_resp', 100)->nullable();
            $table->text('prc_obs')->nullable();
            $table->string('prc_status', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precos_base');
    }
};

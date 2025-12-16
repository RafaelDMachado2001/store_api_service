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
        Schema::create('produtos_base', function (Blueprint $table) {
            $table->bigIncrements('prod_id');
            $table->string('prod_cod', 30);
            $table->string('prod_nome', 150);
            $table->string('prod_cat', 50);
            $table->string('prod_subcat', 50);
            $table->text('prod_desc');
            $table->string('prod_fab', 100);
            $table->string('prod_mod', 50);
            $table->string('prod_cor', 30);
            $table->text('prod_peso');
            $table->text('prod_larg');
            $table->text('prod_alt');
            $table->text('prod_prof');
            $table->string('prod_und', 10);
            $table->boolean('prod_atv');
            $table->text('prod_dt_cad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos_base');
    }
};

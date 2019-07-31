<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('idcategorias');
            $table->string('nombre',45);
            $table->unsignedInteger('idcategoriapadre')->nullable()->index();

            $table->foreign('idcategoriapadre')->references('idcategorias')->on('categorias');
        });
        /*
        DB::statement('ALTER TABLE `categorias`
        ADD KEY `fk_categorias_categorias_idx` (`idcategoriapadre`);
        ');*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}
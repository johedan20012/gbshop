<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('productos', function (Blueprint $table) {
            $table->increments('idproductos');
            $table->string('nombre',50);
            $table->text('descripcion')->nullable();
            $table->decimal('precio',11,2)->unsigned()->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('idmarca')->index();
            $table->unsignedInteger('idcategoria')->index();
            $table->timestamps();

            $table->foreign('idmarca')->references('idmarcas')->on('marcas');
            $table->foreign('idcategoria')->references('idcategorias')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
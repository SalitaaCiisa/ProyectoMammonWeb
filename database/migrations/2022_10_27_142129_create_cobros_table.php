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
        Schema::create('cobros', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('idUsuario');

            $table->foreign('idUsuario')->references('id')->on('usuarios');

            $table->string('nombreCobro', 50)->unique();
            $table->string('cobrador', 50);
            $table->integer('monto');
            $table->date('fechaCobro');
            $table->string('descripcion', 255);
            $table->enum('frecuencia',['mensual','semanal','unico',]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cobros');
    }
};

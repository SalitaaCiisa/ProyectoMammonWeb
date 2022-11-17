<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonos', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('idUsuario');

            $table->foreign('idUsuario')->references('id')->on('usuarios');
            
            $table->string('nombreAbono', 50);
            $table->string('abonador', 50);
            $table->integer('monto');
            $table->date('fechaAbono');
            $table->string('descripcion', 255)->nullable();
            $table->enum('frecuencia',['mensual','semanal','unico',]);

            $table->unique(['idUsuario','nombreAbono']);
            
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
        Schema::dropIfExists('abonos');
    }
};

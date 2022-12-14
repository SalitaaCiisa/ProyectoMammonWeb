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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('idUsuario');

            $table->foreign('idUsuario')->references('id')->on('usuarios');

            $table->string('nombreCuenta', 100);
            $table->string('link_token', 255);
            $table->string('api_key', 255);
            $table->string('id_cuenta', 255)->nullable();

            $table->unique(['idUsuario','link_token','api_key','id_cuenta']);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuentas');
    }
};

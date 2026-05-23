<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expedientes_digitalizados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_expediente');
            $table->string('nro_expediente');
            $table->string('tipo_expediente');
            $table->text('texto_expediente')->nullable();
            $table->string('url_documento')->nullable();

            $table->unsignedBigInteger('usuario_reg')->nullable(); 
            $table->unsignedBigInteger('usuario_mod')->nullable(); 

            $table->string('estado')->default('activo');

            $table->timestamps();

       

            $table->foreign('id_cliente')->references('id')->on('personas')->onDelete('cascade');

            $table->foreign('id_expediente')->references('id')->on('expedientes')->onDelete('cascade');

            $table->foreign('usuario_reg')->references('id')->on('usuarios')->onDelete('set null');

            $table->foreign('usuario_mod')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expedientes_digitalizados');
    }
};

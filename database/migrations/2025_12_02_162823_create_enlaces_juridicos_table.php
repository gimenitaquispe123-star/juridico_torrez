<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enlaces_juridicos', function (Blueprint $table) {

            $table->id();

            $table->string('nombre');
            $table->text('enlace');
            $table->text('descripcion')->nullable();

            $table->unsignedBigInteger('registrado_por')->nullable();
            $table->unsignedBigInteger('modificado_por')->nullable();

            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            $table->timestamps();
    
            $table->foreign('registrado_por')->references('id')->on('usuarios')->onDelete('set null');
            $table->foreign('modificado_por')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enlaces_juridicos');
    }
};

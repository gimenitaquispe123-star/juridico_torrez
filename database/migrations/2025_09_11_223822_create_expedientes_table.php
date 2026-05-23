<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente')->nullable();

            $table->string('codigo_expediente', 50)->unique();
            $table->string('nro_expediente', 50)->nullable();
            $table->string('demandante', 150)->nullable();
            $table->string('demandado', 150)->nullable();
            $table->string('materia', 100)->nullable();
            $table->string('contingencia', 50)->nullable();
            
            $table->timestamp('registrado')->useCurrent();
            $table->timestamp('modificado')->nullable()->useCurrentOnUpdate();
         
            $table->unsignedBigInteger('usuario_reg')->nullable();
            $table->unsignedBigInteger('usuario_mod')->nullable();

            $table->boolean('estado')->default(true);
            $table->text('observaciones')->nullable();
            $table->string('estado_expediente', 50)->nullable();
            
            $table->foreign('id_cliente')->references('id')->on('personas')->onDelete('set null');
            $table->foreign('usuario_reg')->references('id')->on('usuarios')->onDelete('set null');
            $table->foreign('usuario_mod')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};

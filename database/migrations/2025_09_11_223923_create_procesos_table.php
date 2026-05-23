<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->unsignedBigInteger('id_abogado')->nullable();
            $table->unsignedBigInteger('id_posicion')->nullable(); 
            $table->unsignedBigInteger('tipo_proceso')->nullable();
            $table->unsignedBigInteger('estado_proceso')->nullable();
            $table->unsignedBigInteger('id_expediente')->nullable();
            $table->string('contrario', 255)->nullable();
            $table->string('proceso', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->text('involucrados')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->string('usuario_reg', 100)->nullable();
            $table->string('usuario_mod', 100)->nullable();
            $table->string('estado', 50)->nullable();
            $table->timestamps(); 
        });

        
        Schema::table('procesos', function (Blueprint $table) {
            $table->foreign('id_cliente')->references('id')->on('personas')->onDelete('set null');
            $table->foreign('id_abogado')->references('id')->on('personas')->onDelete('set null');
            $table->foreign('id_posicion')->references('id')->on('posiciones')->onDelete('set null'); 
            $table->foreign('tipo_proceso')->references('id')->on('tipos_procesos')->onDelete('set null');
            $table->foreign('estado_proceso')->references('id')->on('estados_proceso')->onDelete('set null');
            $table->foreign('id_expediente')->references('id')->on('expedientes')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->dropForeign(['id_cliente']);
            $table->dropForeign(['id_abogado']);
            $table->dropForeign(['id_posicion']); 
            $table->dropForeign(['tipo_proceso']);
            $table->dropForeign(['estado_proceso']);
            $table->dropForeign(['id_expediente']);
        });

        Schema::dropIfExists('procesos');
    }
};

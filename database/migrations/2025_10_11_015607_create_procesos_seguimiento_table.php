<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procesos_seguimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_proceso');  
            $table->unsignedBigInteger('id_cliente')->nullable(); 
            $table->date('fecha');                      
            $table->string('etapa', 255)->nullable();   
            $table->string('accion', 255)->nullable();  
            $table->text('observaciones')->nullable();
            $table->integer('dias_plazo')->nullable(); 
            $table->date('fecha_vencimiento')->nullable(); 
            $table->string('estado_plazo', 50)->nullable();  
            $table->unsignedBigInteger('usuario_reg');      
            $table->unsignedBigInteger('usuario_mod')->nullable(); 
            $table->timestamps();

           
            $table->foreign('id_proceso')->references('id')->on('procesos')->onDelete('cascade');
            $table->foreign('id_cliente')->references('id')->on('personas')->onDelete('set null');
            $table->foreign('usuario_reg')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('usuario_mod')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('procesos_seguimiento', function (Blueprint $table) {
            $table->dropForeign(['id_proceso']);
            $table->dropForeign(['id_cliente']);
            $table->dropForeign(['usuario_reg']);
            $table->dropForeign(['usuario_mod']);
        });

        Schema::dropIfExists('procesos_seguimiento');
    }
};

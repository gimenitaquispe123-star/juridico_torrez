<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id('id_agenda');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('tipo_evento'); 
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin')->nullable();
            $table->string('lugar')->nullable();
            $table->string('estado')->default('Programado');
            $table->string('prioridad')->default('Media');
            $table->boolean('notificar')->default(false);
            $table->string('documento')->nullable();

           
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};


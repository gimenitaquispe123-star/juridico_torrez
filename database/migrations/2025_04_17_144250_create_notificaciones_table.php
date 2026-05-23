<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id('id_notificacion');

            
            
            $table->string('titulo');
            $table->text('mensaje');

         
            $table->dateTime('fecha_envio')->nullable();   
            $table->dateTime('fecha_evento')->nullable();  

            $table->enum('estado', ['pendiente', 'enviado'])->default('pendiente');
            $table->enum('canal', ['sistema', 'email', 'whatsapp'])->default('sistema');

            $table->boolean('leido')->default(false);

          
            $table->string('url_direccion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};

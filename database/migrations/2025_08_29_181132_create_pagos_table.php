<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('personas')->onDelete('cascade');
            $table->unsignedBigInteger('tarifa_id'); 
            $table->foreign('tarifa_id')->references('id_tarifa')->on('tarifas')->onDelete('cascade');
            $table->decimal('monto_total', 10, 2);   
            $table->text('glosa_pago')->nullable();      
            $table->decimal('monto_pagado', 10, 2)->default(0); 
           
            $table->date('fecha_pago')->nullable();
            $table->enum('estado', ['Pendiente', 'Pagado'])->default('Pendiente');
            $table->unsignedBigInteger('usuario_registro'); 
            $table->foreign('usuario_registro')->references('id')->on('usuarios')->onDelete('restrict');

            $table->unsignedBigInteger('usuario_modifico')->nullable(); 
            $table->foreign('usuario_modifico')->references('id')->on('usuarios')->onDelete('restrict');

            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};

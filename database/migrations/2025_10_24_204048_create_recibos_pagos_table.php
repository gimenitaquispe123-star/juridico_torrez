<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recibos_pagos', function (Blueprint $table) {
            $table->id(); 


            $table->unsignedBigInteger('id_pago');
            $table->foreign('id_pago')->references('id_pago')->on('pagos')->onDelete('cascade');
            $table->string('numero_recibo')->unique();     
            $table->text('glosa_pago')->nullable();      
            $table->decimal('monto_pago', 10, 2);        
            $table->enum('estado', ['Emitido', 'Anulado'])->default('Emitido'); 
            $table->enum('tipo_pago', ['Efectivo', 'Transferencia', 'Cheque']); 

            $table->unsignedBigInteger('usuario_registro');
            $table->foreign('usuario_registro')->references('id')->on('usuarios')->onDelete('restrict');

            $table->unsignedBigInteger('usuario_modifico')->nullable();
            $table->foreign('usuario_modifico')->references('id')->on('usuarios')->onDelete('restrict');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recibos_pagos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expedientes_documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_expediente');    
            $table->unsignedBigInteger('documento_id');     

            $table->text('observacion_descripcion')->nullable();
            $table->string('nombre_documento', 255)->nullable();  
            $table->string('ruta_documento', 255)->nullable();  

            $table->unsignedBigInteger('usuario_regi')->nullable();
            $table->unsignedBigInteger('usuario_modi')->nullable();
            $table->timestamp('registrado')->useCurrent();
            $table->timestamp('modificado')->nullable()->useCurrentOnUpdate();
            $table->boolean('estado')->default(true);
            $table->foreign('id_expediente')->references('id')->on('expedientes')->onDelete('cascade');
            $table->foreign('documento_id')->references('id_documento')->on('documentos')->onDelete('cascade');
            $table->foreign('usuario_regi')->references('id')->on('usuarios')->onDelete('set null');
            $table->foreign('usuario_modi')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expedientes_documentos');
    }
};

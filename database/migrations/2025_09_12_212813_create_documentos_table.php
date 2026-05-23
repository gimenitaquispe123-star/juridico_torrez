<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->bigIncrements('id_documento');
            $table->string('nombre')->nullable();
            $table->string('tipo')->nullable();
            $table->string('archivo')->nullable();
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_subida')->nullable();
            $table->longText('texto_extraido')->nullable();
            $table->string('hash')->nullable();
            $table->string('userid_sha256')->nullable();

            
            $table->unsignedBigInteger('id_usuario')->nullable(); 
            $table->unsignedBigInteger('carpeta_id')->nullable();
            $table->unsignedBigInteger('proceso_id')->nullable(); 

            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('set null');

            $table->foreign('carpeta_id')->references('id')->on('carpetas')->onDelete('set null');


            $table->foreign('proceso_id')->references('id')->on('procesos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
            $table->dropForeign(['carpeta_id']);
            $table->dropForeign(['proceso_id']);
        });

        Schema::dropIfExists('documentos');
    }
};

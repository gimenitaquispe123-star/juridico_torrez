<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carpetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('padre_id')->nullable();
            $table->unsignedBigInteger('tipo_proceso_id')->nullable();
            $table->unsignedBigInteger('proceso_id')->nullable();

            $table->timestamp('registrado')->nullable();
            $table->timestamp('modificado')->nullable();
            $table->string('usuario_reg', 100)->nullable();
            $table->string('usuario_mod', 100)->nullable();

            // Relaciones
            $table->foreign('padre_id')->references('id')->on('carpetas')->onDelete('cascade');
            $table->foreign('tipo_proceso_id')->references('id')->on('tipos_procesos')->onDelete('set null');
            $table->foreign('proceso_id')->references('id')->on('procesos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('carpetas', function (Blueprint $table) {
            $table->dropForeign(['padre_id']);
            $table->dropForeign(['tipo_proceso_id']);
            $table->dropForeign(['proceso_id']);
        });

        Schema::dropIfExists('carpetas');
    }
};

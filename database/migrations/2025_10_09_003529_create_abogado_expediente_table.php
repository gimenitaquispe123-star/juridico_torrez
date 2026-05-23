<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abogado_expediente', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_expediente');   
            $table->unsignedBigInteger('id_empleado');     

            $table->date('fecha_asignacion')->nullable();
            $table->date('fecha_desvinculacion')->nullable();
            $table->text('observacion')->nullable();

            $table->timestamp('registro')->useCurrent();
            $table->unsignedBigInteger('usuario_reg')->nullable();
            $table->unsignedBigInteger('usuario_mod')->nullable();
            $table->timestamp('modificado')->nullable()->useCurrentOnUpdate();

            $table->boolean('estado')->default(true);

            $table->foreign('id_expediente')->references('id')->on('expedientes')->onDelete('cascade');
            $table->foreign('id_empleado')->references('id')->on('personas')->onDelete('cascade');
            $table->foreign('usuario_reg')->references('id')->on('usuarios')->onDelete('set null');
            $table->foreign('usuario_mod')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abogado_expediente');
    }
};


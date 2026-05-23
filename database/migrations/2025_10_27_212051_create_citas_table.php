<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->unsignedBigInteger('id_empleado')->nullable();

            $table->string('titulo', 150)->nullable();
            $table->string('nota', 255)->nullable();
            $table->string('asunto', 255)->nullable();
            $table->text('mensaje')->nullable();

            $table->dateTime('fecha_hora_cita')->nullable();
            $table->string('lugar_cita', 255)->nullable();
            $table->string('estado_cita', 50)->default('Pendiente');

            $table->timestamp('registrado')->useCurrent();
            $table->timestamp('modificado')->nullable()->useCurrentOnUpdate();

            $table->unsignedBigInteger('usuario_registrado')->nullable();
            $table->unsignedBigInteger('usuario_modificado')->nullable();

            $table->string('estado', 20)->default('Activo');

            $table->foreign('id_cliente')->references('id')->on('personas')->onDelete('set null');
            $table->foreign('id_empleado')->references('id')->on('personas')->onDelete('set null');
            $table->foreign('usuario_registrado')->references('id')->on('usuarios')->onDelete('set null');
            $table->foreign('usuario_modificado')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};

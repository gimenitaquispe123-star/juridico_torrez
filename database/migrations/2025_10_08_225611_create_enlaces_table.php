<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enlaces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_persona')->nullable(); 

            $table->string('nombre', 150);
            $table->string('enlace', 255);
            $table->text('descripcion')->nullable();
            $table->timestamp('registrado')->useCurrent();
            $table->timestamp('modificado')->nullable()->useCurrentOnUpdate();

            $table->unsignedBigInteger('usuario_reg')->nullable();
            $table->unsignedBigInteger('usuario_mod')->nullable();
            $table->boolean('estado')->default(true);

            $table->foreign('usuario_reg')->references('id')->on('usuarios')->onDelete('set null');
            $table->foreign('usuario_mod')->references('id')->on('usuarios')->onDelete('set null');

            $table->foreign('id_persona')->references('id')->on('personas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enlaces');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estados_proceso', function (Blueprint $table) {
            $table->id();
            $table->string('estado_proceso');
            $table->text('descripcion')->nullable();
            $table->timestamp('registrado')->useCurrent();
            $table->timestamp('modificado')->nullable()->useCurrentOnUpdate();
            $table->unsignedBigInteger('usuario_reg')->nullable();
            $table->unsignedBigInteger('usuario_mod')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estados_proceso');
    }
};

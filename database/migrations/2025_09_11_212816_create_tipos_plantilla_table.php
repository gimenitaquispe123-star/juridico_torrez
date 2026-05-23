<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_plantilla', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_plantilla');
            $table->text('descripcion')->nullable();
            $table->timestamp('registrado')->useCurrent();
            $table->timestamp('modificado')->nullable()->useCurrentOnUpdate();
            $table->string('usuario_reg')->nullable();
            $table->string('usuario_mod')->nullable();
            $table->boolean('estado')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_plantilla');
    }
};

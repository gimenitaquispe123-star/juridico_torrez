<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('tipos_procesos', function (Blueprint $table) {
            $table->id(); 
            $table->string('tipo_proceso', 100);
            $table->text('descripcion')->nullable();
            $table->timestamp('registrado')->nullable();
            $table->timestamp('modificado')->nullable();
            $table->string('usuario_reg', 100)->nullable();
            $table->string('usuario_mod', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_procesos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_personas', function (Blueprint $table) {
            $table->id(); 
            $table->string('tipo_persona'); 
            $table->text('descripcion')->nullable(); 
            $table->timestamp('registrado')->useCurrent(); 
            $table->timestamp('modificado')->nullable()->useCurrentOnUpdate(); 

            $table->boolean('estado')->default(true); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_personas');
    }
};

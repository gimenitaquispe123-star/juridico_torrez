<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('departamento', function (Blueprint $table) {
            $table->id(); 
            $table->string('departamento', 100); 
            $table->string('codigo', 20)->unique(); 
            $table->timestamp('registrado')->useCurrent(); 
            $table->timestamp('modificado')->nullable()->useCurrentOnUpdate(); 
            $table->string('usuario_reg', 50); 
            $table->string('usuario_mod', 50)->nullable(); 
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('departamento');
    }
};


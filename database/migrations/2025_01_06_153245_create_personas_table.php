<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id(); 
          
            $table->unsignedBigInteger('id_tipo_persona')->nullable();
            $table->string('nombres')->nullable();
            $table->string('paterno')->nullable(); 
            $table->string('materno')->nullable();
            $table->string('ci', 20)->unique()->nullable();
            $table->string('ci_expedido', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('direccion')->nullable();
            $table->string('area')->nullable();
            $table->string('registrado')->nullable(); 
            $table->string('modificado')->nullable();   
            $table->string('email')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('matricula')->nullable();
            $table->string('foto')->nullable();  
            $table->unsignedBigInteger('usuario_reg')->nullable();
            $table->unsignedBigInteger('usuario_mod')->nullable();

            $table->timestamps();

            $table->foreign('id_tipo_persona')->references('id')->on('tipos_personas')->onDelete('set null');
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};

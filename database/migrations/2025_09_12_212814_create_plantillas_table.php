<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantillas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_tipo_plantilla');
            $table->foreign('id_tipo_plantilla')->references('id')->on('tipos_plantilla')->onDelete('cascade');

            
            $table->string('plantilla');
            $table->text('descripcion')->nullable();
            $table->string('ruta_archivo')->nullable(); 

           $table->boolean('es_original')->default(1); 
            $table->unsignedBigInteger('id_plantilla_origen')->nullable(); // referencia a la original si es copia

            // Auditoría
            $table->timestamp('registrado')->useCurrent();
            $table->timestamp('modificado')->nullable()->useCurrentOnUpdate();
            $table->string('usuario_reg')->nullable();
            $table->string('usuario_mod')->nullable();
            $table->boolean('estado')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('plantillas', function (Blueprint $table) {
            $table->dropForeign(['id_tipo_plantilla']);
        });

        Schema::dropIfExists('plantillas');
    }
};

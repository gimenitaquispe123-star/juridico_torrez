<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id('id_tarifa');

           
            $table->unsignedBigInteger('tipo_proceso_id');
            $table->foreign('tipo_proceso_id')->references('id')->on('tipos_procesos')->onDelete('cascade');
            $table->string('categoria')->nullable(); 

            $table->decimal('monto_min', 10, 2);
            $table->decimal('monto_max', 10, 2);
            $table->string('moneda')->default('Bs');
            $table->timestamp('registrado')->nullable();
            $table->timestamp('modificado')->nullable();
            $table->unsignedBigInteger('usuario_reg')->nullable();
            $table->unsignedBigInteger('usuario_mod')->nullable();
            $table->foreign('usuario_reg')->references('id')->on('usuarios')->onDelete('set null');
            $table->foreign('usuario_mod')->references('id')->on('usuarios')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};

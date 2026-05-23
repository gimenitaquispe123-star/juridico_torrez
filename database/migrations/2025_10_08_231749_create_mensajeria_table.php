<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajeria', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->unsignedBigInteger('id_empleado')->nullable();

            $table->string('asunto', 150);
            $table->text('mensaje');

            $table->timestamp('registrado')->useCurrent();
            $table->timestamp('modificado')->nullable()->useCurrentOnUpdate();

            $table->unsignedBigInteger('usuario_reg')->nullable();
            $table->unsignedBigInteger('usuario_mod')->nullable();

            $table->boolean('estado')->default(true);


            $table->boolean('enviado_email')->default(false);
            $table->timestamp('fecha_envio_email')->nullable();

            // 🔐 Relaciones
            $table->foreign('id_cliente')
                ->references('id')
                ->on('personas')
                ->onDelete('set null');

            $table->foreign('id_empleado')
                ->references('id')
                ->on('personas')
                ->onDelete('set null');

            $table->foreign('usuario_reg')
                ->references('id')
                ->on('usuarios')
                ->onDelete('set null');

            $table->foreign('usuario_mod')
                ->references('id')
                ->on('usuarios')
                ->onDelete('set null');

            $table->index('id_cliente');
            $table->index('id_empleado');
            $table->index('registrado');
            $table->index('enviado_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajeria');
    }
};


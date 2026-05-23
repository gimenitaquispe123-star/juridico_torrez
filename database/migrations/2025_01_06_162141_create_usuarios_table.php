<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('persona_id')->nullable();
    $table->foreign('persona_id')->references('id')->on('personas')->onDelete('set null');

    $table->string('usuario', 100)->unique();
    $table->string('password');
    $table->string('email', 150)->unique();
    $table->string('rol', 50)->nullable();
    $table->enum('estado', ['activo', 'inactivo'])->default('activo');
    $table->timestamp('fecha_registro')->default(DB::raw('CURRENT_TIMESTAMP'));
    $table->timestamp('modificado')->nullable();
    $table->string('usuario_reg', 100)->nullable();
    $table->string('usuario_mod', 100)->nullable();

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

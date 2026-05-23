<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagos', function (Blueprint $table) {

            $table->dropColumn('monto_pendiente');
        });

        Schema::table('pagos', function (Blueprint $table) {

            $table->decimal('monto_pendiente', 10, 2)
                  ->default(0)
                  ->after('monto_pagado');
        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {

            $table->dropColumn('monto_pendiente');
        });

        Schema::table('pagos', function (Blueprint $table) {

            $table->decimal('monto_pendiente', 10, 2)
                  ->virtualAs('monto_total - monto_pagado');
        });
    }
};
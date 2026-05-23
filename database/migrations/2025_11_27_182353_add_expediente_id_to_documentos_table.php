<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('documentos', function (Blueprint $table) {
        $table->unsignedBigInteger('expediente_id')->nullable()->after('proceso_id');

        $table->foreign('expediente_id')
              ->references('id')
              ->on('expedientes')
              ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('documentos', function (Blueprint $table) {
        $table->dropForeign(['expediente_id']);
        $table->dropColumn('expediente_id');
    });
}

};

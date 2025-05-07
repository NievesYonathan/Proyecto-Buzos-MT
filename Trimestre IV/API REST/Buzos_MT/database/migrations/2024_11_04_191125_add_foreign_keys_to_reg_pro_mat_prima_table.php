<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reg_pro_mat_prima', function (Blueprint $table) {
            $table->foreign(['id_pro_materia_prima'], 'fk_materiaPrima')->references(['id_materia_prima'])->on('materia_prima')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['id_produccion'], 'fk_produccion')->references(['id_produccion'])->on('produccion')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reg_pro_mat_prima', function (Blueprint $table) {
            $table->dropForeign('fk_materiaPrima');
            $table->dropForeign('fk_produccion');
        });
    }
};

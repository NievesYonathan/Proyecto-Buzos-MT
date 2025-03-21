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
        Schema::table('produccion', function (Blueprint $table) {
            $table->foreign(['pro_etapa'], 'fk_produccion_etapas1')->references(['id_etapas'])->on('etapas')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produccion', function (Blueprint $table) {
            $table->dropForeign('fk_produccion_etapas1');
        });
    }
};

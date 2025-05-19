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
        Schema::table('materia_prima', function (Blueprint $table) {
            $table->foreign(['mat_pri_estado'], 'fk_estado')->references(['id_estados'])->on('estados')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['proveedores_id_proveedores'], 'fk_proveedor')->references(['num_doc'])->on('usuarios')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materia_prima', function (Blueprint $table) {
            $table->dropForeign('fk_estado');
            $table->dropForeign('fk_proveedor');
        });
    }
};

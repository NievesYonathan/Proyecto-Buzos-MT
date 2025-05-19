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
        Schema::table('reg_pro_fabricados', function (Blueprint $table) {
            $table->foreign(['produccion_id_produccion'], 'fk_Registro_Productos_Fabricados_Producción1')->references(['id_produccion'])->on('produccion')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reg_pro_fabricados', function (Blueprint $table) {
            $table->dropForeign('fk_Registro_Productos_Fabricados_Producción1');
        });
    }
};

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
        Schema::table('salida_productos', function (Blueprint $table) {
            $table->foreign(['id_reg_prod_fabricados'], 'fk_salida_productos_reg_pro_fabricados1')->references(['id_reg_prod_fabricados'])->on('reg_pro_fabricados')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salida_productos', function (Blueprint $table) {
            $table->dropForeign('fk_salida_productos_reg_pro_fabricados1');
        });
    }
};

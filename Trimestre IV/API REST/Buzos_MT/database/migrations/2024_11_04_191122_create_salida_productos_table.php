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
        Schema::create('salida_productos', function (Blueprint $table) {
            $table->integer('id_salida_productos')->primary();
            $table->integer('sal_pro_cantidad');
            $table->string('sal_pro_motivo', 60);
            $table->dateTime('sal_pro_fecha');
            $table->string('sal_pro_destino', 45);
            $table->integer('id_reg_prod_fabricados')->index('fk_salida_productos_reg_pro_fabricados1_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salida_productos');
    }
};

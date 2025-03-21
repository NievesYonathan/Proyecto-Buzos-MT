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
        Schema::create('reg_pro_fabricados', function (Blueprint $table) {
            $table->integer('id_reg_prod_fabricados', true)->comment('Identificador unico de la tabla registro de productos fabricados');
            $table->integer('reg_pf_cantidad')->comment('Atrubuto que identifica la cantidad disponible en los registros de productos fabricados');
            $table->date('reg_pf_fecha_registro')->comment('Atrubuto que identifica la fecha de actualizacion');
            $table->string('reg_pf_talla', 4)->comment('Atrinuto que identifica  la talla ');
            $table->string('reg_pf_color', 25)->comment('Atrinuto que identifica el color');
            $table->string('reg_pf_material', 45)->comment('Atrinuto que identifica el material');
            $table->string('reg_pf_tipo_prenda', 45)->comment('Atrinuto que identifica el tipo de prenda');
            $table->integer('produccion_id_produccion')->index('fk_registro_productos_fabricados_producción1_idx')->comment('Fk que comunica con la tabla produccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reg_pro_fabricados');
    }
};

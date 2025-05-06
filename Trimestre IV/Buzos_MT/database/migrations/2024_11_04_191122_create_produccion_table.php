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
        Schema::create('produccion', function (Blueprint $table) {
            $table->integer('id_produccion', true)->comment('Identificador unico de la tabla produccion');
            $table->string('pro_nombre', 50)->comment('Atrubuto que identifica el nombre del producto en produccion');
            $table->dateTime('pro_fecha_inicio')->comment('Atrubuto que identifica la fecha de inicio de la producion');
            $table->dateTime('pro_fecha_fin')->comment('Atrubuto que identifica la fecha de fin de la producion');
            $table->integer('pro_cantidad')->comment('Atrubuto que identifica la cantidad de la producion');
            $table->integer('pro_etapa')->index('fk_produccion_etapas1_idx')->comment('fk que comunica con la tabla etapas ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produccion');
    }
};

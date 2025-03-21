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
        Schema::create('materia_prima', function (Blueprint $table) {
            $table->integer('id_materia_prima', true)->comment('Identificador unico de la tabla materia prima');
            $table->string('mat_pri_nombre', 45)->comment('Atrubuto que identifica lel nombre de la materia prima');
            $table->string('mat_pri_descripcion', 45)->comment('Atrubuto que identifica la descripcion del amateria prima');
            $table->string('mat_pri_unidad_medida', 12)->comment('Atrubuto que identifica la unidad de medida que se utiliza en la amteria prima');
            $table->integer('mat_pri_cantidad')->comment('Atrubuto que identifica la la cantidad de la materia prima');
            $table->integer('mat_pri_estado')->index('fk_estado_idx')->comment('Atributo que identifica el estado de la materia prima(Agotado, Existente,  Deshabilitado)');
            $table->date('fecha_compra_mp')->comment('Atributo que identifica la fecha de la compra de la materia prima
');
            $table->integer('proveedores_id_proveedores')->index('fk_proveedor_idx')->comment('Fk que comunica con la tabla proveedores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materia_prima');
    }
};

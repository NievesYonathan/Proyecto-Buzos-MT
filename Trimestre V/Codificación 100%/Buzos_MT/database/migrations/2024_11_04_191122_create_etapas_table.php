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
        Schema::create('etapas', function (Blueprint $table) {
            $table->integer('id_etapas', true)->comment('Identificador unico de la tabla etapas');
            $table->string('eta_nombre', 45)->comment('Atributo que identifca el nombre d el a etapa');
            $table->string('eta_descripcion', 100)->comment('Atributo que identifica la descripcion de la etapa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etapas');
    }
};

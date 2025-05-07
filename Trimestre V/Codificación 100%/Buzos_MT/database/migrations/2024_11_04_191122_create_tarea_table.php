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
        Schema::create('tarea', function (Blueprint $table) {
            $table->integer('id_tarea', true)->comment('Identificador unico de la tabla Tarea');
            $table->string('tar_nombre', 50)->comment('Atributo que identifica el nombre de la tarea');
            $table->string('tar_descripcion', 200)->comment('Atributo que identifica la descripcion de la tarea');
            $table->integer('tar_estado')->index('fk_estadot')->comment('Atributo que identifica el estado de la tarea');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea');
    }
};

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
        Schema::create('seguridad', function (Blueprint $table) {
            $table->integer('id_seguridad', true)->comment('Identificador unico de la tabla seguridad.');
            $table->integer('usu_num_doc')->index('fk_seguridad_usuarios1_idx')->comment('Atributo que identifica el nombre del perfil');
            $table->string('seg_clave_hash', 255)->comment('Atributo que identifica el el ultimo inicio de sesion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguridad');
    }
};

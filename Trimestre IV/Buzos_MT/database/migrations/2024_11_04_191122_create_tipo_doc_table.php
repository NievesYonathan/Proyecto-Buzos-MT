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
        Schema::create('tipo_doc', function (Blueprint $table) {
            $table->integer('id_tipo_documento', true)->comment('Identificador unico de la tabla tipo de documento');
            $table->string('tip_doc_descripcion', 20)->comment('Atributo que identifica la descripcion del tipo del documento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_doc');
    }
};

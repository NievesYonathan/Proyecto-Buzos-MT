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
        Schema::create('usuarios_espejo', function (Blueprint $table) {
            $table->integer('num_doc')->primary()->comment('Identificador unico de la tabla Usuario');
            $table->integer('t_doc')->index('fk_tipodoc_idx')->comment('Fk que comunica con el tipo de documento');
            $table->string('usu_nombres', 60)->comment('Atributo que identifica el primer nombre del Usuario');
            $table->string('usu_apellidos', 45)->comment('Atributo que identifica el apellido del usuario');
            $table->date('usu_fecha_nacimiento')->comment('Atributo que identifica la fecha de nacimiento del Usuario');
            $table->char('usu_sexo', 1)->comment('Atributo que identifica el tipo de sexo del Usuario');
            $table->string('usu_direccion', 50)->comment('Atributo que identifica el la direccion de residencia del Usuario');
            $table->string('usu_telefono', 10)->comment('Atributo que identifica el el numero de contacto del Usuario');
            $table->string('usu_email', 50)->comment('Atributo que identifica el correo del Usuario');
            $table->date('usu_fecha_contratacion')->comment('Atributo que identifica el la fecha de contracion del Usuario');
            $table->integer('usu_estado')->index('fk_estados_idx')->comment('Atributo que identifica el estado del Usuario');
            $table->string('imag_perfil', 45);
            $table->string('operacion', 15)->nullable();
            $table->date('fecha_operacion')->nullable();
            $table->string('usuario_operacion', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_espejo');
    }
};

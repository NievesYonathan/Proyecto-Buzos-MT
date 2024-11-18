<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    // Especifica el nombre de la tabla si no sigue la convención
    protected $table = 'estados';

    // Indica los campos que se pueden rellenar de manera masiva
    protected $fillable = ['nombre_estado'];

    // Si no estás utilizando campos de marca de tiempo, desactívalos
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegProMateriPrima extends Model
{
    use HasFactory;

    protected $table = 'reg_pro_mat_prima';

    protected $primaryKey = 'id_registro';

    protected $fillable = [
        'reg_pmp_cantidad_usada',
        'reg_pmp_fecha_registro',
        'id_pro_materia_prima',
        'id_produccion'
    ];

    public $timestamps = false;
}

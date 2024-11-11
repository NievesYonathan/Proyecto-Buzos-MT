<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    use HasFactory;

    protected $table = 'produccion';

    protected $primaryKey = 'id_produccion';

    protected $fillable = [
        'pro_nombre',
        'pro_fecha_inicio',
        'pro_fecha_fin',
        'pro_cantidad',
        'pro_etapa'
    ];

    public $timestamps = false;
}

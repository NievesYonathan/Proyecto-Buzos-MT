<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapas extends Model
{
    use HasFactory;

    protected $table = 'etapas';

    protected $primaryKey = 'id_etapas';

    protected $fillable = [
        'eta_nombre',
        'eta_descripcion'
    ];

    public $timestamps = false;

    public function produccion()
    {
        return $this->hasMany(Produccion::class, 'pro_etapa', 'id_etapas');
    }
}

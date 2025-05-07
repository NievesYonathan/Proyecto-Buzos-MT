<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = "cargos";

    protected $primaryKey = 'id_cargos';

    protected $fillable = [
        'car_nombre'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'cargos_has_usuarios', 'cargos_id_cargos', 'usuarios_num_doc');
    }

    public $timestamps = false;
}

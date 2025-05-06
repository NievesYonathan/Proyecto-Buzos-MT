<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivos extends Model
{
    use HasFactory;

    protected $table = 'motivos';

    protected $primaryKey = 'id_motivos';

    protected $fillable = [
        'categoria_motivo'
    ];

    public $timestamsps = false;
}

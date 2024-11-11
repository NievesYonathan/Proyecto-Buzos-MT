<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tarea';

    protected $fillable = [
        'tar_nombre',
        'tar_descripcion',
        'tar_estado'
    ];

    public $timestamps = false;
}

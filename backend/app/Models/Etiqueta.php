<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;

    protected $fillable = [
        'etiqueta'
    ];

    public function tareas()
    {
        return $this->belongsToMany(Tarea::class, 'etiqueta_tarea');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'prioridad_id',
        'fecha_vencimiento'
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date'
    ];

    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class);
    }

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'etiqueta_tarea');
    }
}

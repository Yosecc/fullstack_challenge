<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tarea;

class TareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarea1 = Tarea::create([
            'titulo' => 'Completar documentación del proyecto',
            'descripcion' => 'Escribir documentación completa de la API y el frontend',
            'estado' => 'en_progreso',
            'prioridad_id' => 2,
            'fecha_vencimiento' => now()->addDays(7)
        ]);
        $tarea1->etiquetas()->attach([1]); // DEV

        $tarea2 = Tarea::create([
            'titulo' => 'Revisar pull requests',
            'descripcion' => 'Revisar y aprobar PRs pendientes en GitHub',
            'estado' => 'pendiente',
            'prioridad_id' => 3,
            'fecha_vencimiento' => now()->addDays(2)
        ]);
        $tarea2->etiquetas()->attach([1, 2]); // DEV, QA

        $tarea3 = Tarea::create([
            'titulo' => 'Llamar al dentista',
            'descripcion' => 'Agendar cita para revisión dental',
            'estado' => 'pendiente',
            'prioridad_id' => 1,
            'fecha_vencimiento' => now()->addDays(5)
        ]);
        $tarea3->etiquetas()->attach([3]); // RRHH

        $tarea4 = Tarea::create([
            'titulo' => 'Preparar presentación',
            'descripcion' => 'Crear slides para la reunión con el cliente',
            'estado' => 'completada',
            'prioridad_id' => 2,
            'fecha_vencimiento' => now()->subDays(1)
        ]);
        $tarea4->etiquetas()->attach([1]); // DEV

        $tarea5 = Tarea::create([
            'titulo' => 'Actualizar dependencias',
            'descripcion' => 'Actualizar packages de npm y composer',
            'estado' => 'pendiente',
            'prioridad_id' => 1,
            'fecha_vencimiento' => now()->addDays(10)
        ]);
        $tarea5->etiquetas()->attach([2]); // QA
    }
}

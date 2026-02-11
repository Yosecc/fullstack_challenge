<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prioridad;

class PrioridadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prioridad::create(['prioridad' => 'BAJA']);
        Prioridad::create(['prioridad' => 'MEDIA']);
        Prioridad::create(['prioridad' => 'ALTA']);
    }
}

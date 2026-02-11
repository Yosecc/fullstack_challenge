<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Etiqueta;

class EtiquetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Etiqueta::create(['etiqueta' => 'DEV']);
        Etiqueta::create(['etiqueta' => 'QA']);
        Etiqueta::create(['etiqueta' => 'RRHH']);
    }
}

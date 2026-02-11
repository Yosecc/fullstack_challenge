<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prioridad;
use Illuminate\Http\Request;

class PrioridadController extends Controller
{
    public function index()
    {
        $prioridades = Prioridad::all();
        return response()->json($prioridades);
    }
}

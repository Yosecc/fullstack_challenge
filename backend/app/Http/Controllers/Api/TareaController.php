<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tarea::with(['prioridad', 'etiquetas']);

        // Filtros
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('prioridad_id')) {
            $query->where('prioridad_id', $request->prioridad_id);
        }

        if ($request->has('etiqueta_id')) {
            $query->whereHas('etiquetas', function ($q) use ($request) {
                $q->where('etiquetas.id', $request->etiqueta_id);
            });
        }

        $tareas = $query->orderBy('created_at', 'desc')->get();

        return response()->json($tareas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:pendiente,en_progreso,completada',
            'prioridad_id' => 'required|exists:prioridades,id',
            'fecha_vencimiento' => 'nullable|date',
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id'
        ]);

        $tarea = Tarea::create($validated);

        if (isset($validated['etiquetas'])) {
            $tarea->etiquetas()->attach($validated['etiquetas']);
        }

        return response()->json($tarea->load(['prioridad', 'etiquetas']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tarea = Tarea::with(['prioridad', 'etiquetas'])->findOrFail($id);
        return response()->json($tarea);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tarea = Tarea::findOrFail($id);

        $validated = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'sometimes|required|in:pendiente,en_progreso,completada',
            'prioridad_id' => 'sometimes|required|exists:prioridades,id',
            'fecha_vencimiento' => 'nullable|date',
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id'
        ]);

        $tarea->update($validated);

        if (isset($validated['etiquetas'])) {
            $tarea->etiquetas()->sync($validated['etiquetas']);
        }

        return response()->json($tarea->load(['prioridad', 'etiquetas']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->delete();

        return response()->json(['message' => 'Tarea eliminada correctamente']);
    }
}

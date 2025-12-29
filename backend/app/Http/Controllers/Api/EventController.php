<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Listar eventos con filtros
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Filtros
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from')) {
            $query->where('start_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('start_at', '<=', $request->date_to);
        }

        // Filtro por fecha exacta (cuando se envía un solo campo de fecha)
        if ($request->has('date')) {
            $query->whereDate('start_at', $request->date);
        }

        if ($request->has('is_public')) {
            $query->where('is_public', $request->is_public);
        }

        // Búsqueda por todas las columnas visibles de la tabla
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('start_at', 'like', "%{$search}%");
            });
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'start_at');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 15);
        $events = $query->paginate($perPage);

        return response()->json($events);
    }

    /**
     * Listar eventos públicos para la landing page
     */
    public function publicIndex()
    {
        $events = Event::where('is_public', true)
            ->where('start_at', '>=', now()->toDateString())
            ->where('status', '!=', 'cancelado')
            ->orderBy('start_at', 'asc')
            ->limit(10)
            ->get();

        return response()->json($events);
    }

    /**
     * Crear nuevo evento
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after:start_at',
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'is_public' => 'boolean',
            'status' => 'nullable|string|max:20',
        ]);

        $event = Event::create($validated);

        return response()->json($event, 201);
    }

    /**
     * Mostrar evento específico
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    /**
     * Actualizar evento
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'start_at' => 'sometimes|required|date',
            'end_at' => 'nullable|date|after:start_at',
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'is_public' => 'boolean',
            'status' => 'nullable|string|max:20',
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    /**
     * Eliminar evento
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Evento eliminado exitosamente'], 200);
    }
}

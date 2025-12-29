<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ministry;
use Illuminate\Http\Request;

class MinistryController extends Controller
{
    /**
     * Listar ministerios
     */
    public function index(Request $request)
    {
        $query = Ministry::with('members');

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $query->orderBy('order')->orderBy('name');
        $ministries = $query->get();

        return response()->json($ministries);
    }

    /**
     * Crear nuevo ministerio
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $ministry = Ministry::create($validated);

        return response()->json($ministry, 201);
    }

    /**
     * Mostrar ministerio específico
     */
    public function show(string $id)
    {
        $ministry = Ministry::with('members')->findOrFail($id);
        return response()->json($ministry);
    }

    /**
     * Actualizar ministerio
     */
    public function update(Request $request, string $id)
    {
        $ministry = Ministry::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $ministry->update($validated);

        return response()->json($ministry);
    }

    /**
     * Eliminar ministerio
     */
    public function destroy(string $id)
    {
        $ministry = Ministry::findOrFail($id);
        $ministry->delete();

        return response()->json(['message' => 'Ministerio eliminado exitosamente'], 200);
    }

    /**
     * Sincronizar miembros asignados a un ministerio
     */
    public function syncMembers(Request $request, string $id)
    {
        $ministry = Ministry::findOrFail($id);
        $data = $request->validate([
            'members' => ['array'],
            'members.*.id' => ['required', 'integer', 'exists:members,id'],
            'members.*.role' => ['nullable', 'string', 'max:100'],
        ]);

        $syncData = [];
        foreach ($data['members'] ?? [] as $m) {
            $syncData[$m['id']] = ['role' => $m['role'] ?? null];
        }
        $ministry->members()->sync($syncData);

        return response()->json($ministry->load('members'));
    }

    /**
     * Adjuntar un miembro a un ministerio
     */
    public function attachMember(Request $request, string $id)
    {
        $ministry = Ministry::findOrFail($id);
        $data = $request->validate([
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'role' => ['nullable', 'string', 'max:100'],
        ]);

        $ministry->members()->syncWithoutDetaching([$data['member_id'] => ['role' => $data['role'] ?? null]]);
        return response()->json($ministry->load('members'));
    }

    /**
     * Desvincular un miembro de un ministerio
     */
    public function detachMember(string $id, string $memberId)
    {
        $ministry = Ministry::findOrFail($id);
        $ministry->members()->detach($memberId);
        return response()->json(['message' => 'Miembro desvinculado']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Exports\MembersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    /**
     * Listar miembros con filtros
     */
    public function index(Request $request)
    {
        $query = Member::query();

        // Filtros
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('gender', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->has('gender') && $request->gender) {
            $query->where('gender', $request->gender);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('marital') && $request->marital) {
            $query->where('marital_status', $request->marital);
        }
        
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('is_server')) {
            $query->where('is_server', $request->is_server);
        }

        if ($request->has('baptized')) {
            $query->whereNotNull('baptism_date');
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 15);
        $members = $query->paginate($perPage);

        return response()->json($members);
    }

    /**
     * Crear nuevo miembro
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:members,email',
            'phone' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:M,F,O',
            'marital_status' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'baptism_date' => 'nullable|date',
            'baptism_place' => 'nullable|string|max:255',
            'membership_date' => 'nullable|date',
            'status' => 'nullable|string|max:30',
            'ecclesiastical_role' => 'nullable|string|max:255',
            'is_server' => 'boolean',
            'category' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $member = Member::create($validated);

        return response()->json($member, 201);
    }

    /**
     * Mostrar miembro específico
     */
    public function show(string $id)
    {
        $member = Member::with(['ministries', 'transactions'])->findOrFail($id);
        return response()->json($member);
    }

    /**
     * Actualizar miembro
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|nullable|email|unique:members,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:M,F,O',
            'marital_status' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'baptism_date' => 'nullable|date',
            'baptism_place' => 'nullable|string|max:255',
            'membership_date' => 'nullable|date',
            'status' => 'nullable|string|max:30',
            'ecclesiastical_role' => 'nullable|string|max:255',
            'is_server' => 'boolean',
            'category' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $member->update($validated);

        return response()->json($member);
    }

    /**
     * Eliminar miembro
     */
    public function destroy(string $id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return response()->json(['message' => 'Miembro eliminado exitosamente'], 200);
    }

    /**
     * Exportar miembros a Excel (.xlsx)
     */
    public function export(Request $request)
    {
        try {
            $filters = $request->only(['search', 'gender', 'status', 'marital', 'category']);
            $filename = 'miembros_' . date('Y-m-d_His') . '.xlsx';
            
            return Excel::download(new MembersExport($filters), $filename, \Maatwebsite\Excel\Excel::XLSX, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    /**
     * Listar transacciones con filtros
     */
    public function index(Request $request)
    {
        $query = Transaction::with('member');

        // Filtros
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('date_from')) {
            $query->where('transaction_date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('transaction_date', '<=', $request->date_to);
        }

        if ($request->has('member_id')) {
            $query->where('member_id', $request->member_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('amount', 'like', "%{$search}%")
                  ->orWhere('transaction_date', 'like', "%{$search}%")
                  ->orWhereHas('member', function ($m) use ($search) {
                      $m->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'transaction_date');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 15);
        $transactions = $query->paginate($perPage);

        return response()->json($transactions);
    }

    /**
     * Crear nueva transacción
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'type' => 'required|in:ingreso,egreso',
            'category' => 'required|string|max:255',
            'sub_category' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $transaction = Transaction::create($validated);
        $transaction->load('member');

        return response()->json($transaction, 201);
    }

    /**
     * Mostrar transacción específica
     */
    public function show(string $id)
    {
        $transaction = Transaction::with('member')->findOrFail($id);
        return response()->json($transaction);
    }

    /**
     * Actualizar transacción
     */
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'type' => 'sometimes|required|in:ingreso,egreso',
            'category' => 'sometimes|required|string|max:255',
            'sub_category' => 'nullable|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0',
            'transaction_date' => 'sometimes|required|date',
            'payment_method' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $transaction->update($validated);
        $transaction->load('member');

        return response()->json($transaction);
    }

    /**
     * Eliminar transacción
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['message' => 'Transacción eliminada exitosamente'], 200);
    }

    /**
     * Exportar transacciones a Excel
     */
    public function export(Request $request)
    {
        try {
            $filters = $request->only(['type', 'category', 'date_from', 'date_to', 'search']);
            $filename = 'transacciones_' . date('Y-m-d_His') . '.xlsx';
            
            return Excel::download(new TransactionsExport($filters), $filename, \Maatwebsite\Excel\Excel::XLSX, [
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

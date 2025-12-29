<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Obtener la colección de transacciones con filtros
     */
    public function collection()
    {
        $query = Transaction::with('member');

        // Aplicar filtros
        if (isset($this->filters['type']) && $this->filters['type']) {
            $query->where('type', $this->filters['type']);
        }

        if (isset($this->filters['category']) && $this->filters['category']) {
            $query->where('category', $this->filters['category']);
        }

        if (isset($this->filters['date_from']) && $this->filters['date_from']) {
            $query->where('transaction_date', '>=', $this->filters['date_from']);
        }

        if (isset($this->filters['date_to']) && $this->filters['date_to']) {
            $query->where('transaction_date', '<=', $this->filters['date_to']);
        }

        if (isset($this->filters['search']) && $this->filters['search']) {
            $search = $this->filters['search'];
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

        return $query->orderBy('transaction_date', 'desc')->get();
    }

    /**
     * Encabezados del Excel
     */
    public function headings(): array
    {
        return [
            'Fecha',
            'Tipo',
            'Categoría',
            'Sub-Categoría',
            'Monto',
            'Miembro',
            'Método de Pago',
            'Referencia',
            'Descripción'
        ];
    }

    /**
     * Mapear los datos de cada fila
     */
    public function map($transaction): array
    {
        return [
            $transaction->transaction_date ?? '',
            $transaction->type === 'ingreso' ? 'Ingreso' : 'Egreso',
            $transaction->category ?? '',
            $transaction->sub_category ?? '',
            number_format($transaction->amount, 2, '.', ''),
            $transaction->member ? $transaction->member->first_name . ' ' . $transaction->member->last_name : '',
            $transaction->payment_method ?? '',
            $transaction->reference ?? '',
            $transaction->description ?? ''
        ];
    }

    /**
     * Estilos para el Excel
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para la fila de encabezados
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ]
            ],
        ];
    }

    /**
     * Ancho de columnas
     */
    public function columnWidths(): array
    {
        return [
            'A' => 12,  // Fecha
            'B' => 12,  // Tipo
            'C' => 20,  // Categoría
            'D' => 20,  // Sub-Categoría
            'E' => 15,  // Monto
            'F' => 25,  // Miembro
            'G' => 18,  // Método de Pago
            'H' => 20,  // Referencia
            'I' => 40,  // Descripción
        ];
    }
}

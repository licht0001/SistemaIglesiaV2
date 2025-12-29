<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MembersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Obtener la colección de miembros con filtros
     */
    public function collection()
    {
        $query = Member::query();

        // Aplicar los mismos filtros que en el controlador
        if (isset($this->filters['search']) && $this->filters['search']) {
            $search = $this->filters['search'];
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

        if (isset($this->filters['gender']) && $this->filters['gender']) {
            $query->where('gender', $this->filters['gender']);
        }

        if (isset($this->filters['status']) && $this->filters['status']) {
            $query->where('status', $this->filters['status']);
        }

        if (isset($this->filters['marital']) && $this->filters['marital']) {
            $query->where('marital_status', $this->filters['marital']);
        }

        if (isset($this->filters['category']) && $this->filters['category']) {
            $query->where('category', $this->filters['category']);
        }

        return $query->orderBy('first_name', 'asc')->get();
    }

    /**
     * Encabezados del Excel
     */
    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido',
            'Categoría',
            'Email',
            'Teléfono',
            'Fecha Nacimiento',
            'Género',
            'Estado Civil',
            'Ciudad',
            'Dirección',
            'Estado',
            'Fecha Bautismo',
            'Lugar Bautismo',
            'Fecha Membresía',
            'Rol Eclesiástico',
            'Es Servidor',
            'Notas'
        ];
    }

    /**
     * Mapear los datos de cada fila
     */
    public function map($member): array
    {
        return [
            $member->first_name ?? '',
            $member->last_name ?? '',
            ucfirst($member->category ?? 'adulto'),
            $member->email ?? '',
            $member->phone ?? '',
            $member->birth_date ?? '',
            $member->gender == 'M' ? 'Masculino' : ($member->gender == 'F' ? 'Femenino' : ''),
            match($member->marital_status) {
                'single' => 'Soltero(a)',
                'married' => 'Casado(a)',
                'widowed' => 'Viudo(a)',
                'divorced' => 'Divorciado(a)',
                default => $member->marital_status ?? ''
            },
            $member->city ?? '',
            $member->address ?? '',
            $member->status ?? '',
            $member->baptism_date ?? '',
            $member->baptism_place ?? '',
            $member->membership_date ?? '',
            $member->ecclesiastical_role ?? '',
            $member->is_server ? 'Sí' : 'No',
            $member->notes ?? ''
        ];
    }

    /**
     * Estilos para la hoja
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para la fila de encabezados
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
            ],
        ];
    }

    /**
     * Ancho de columnas
     */
    public function columnWidths(): array
    {
        return [
            'A' => 15,  // Nombre
            'B' => 15,  // Apellido
            'C' => 25,  // Email
            'D' => 15,  // Teléfono
            'E' => 15,  // Fecha Nacimiento
            'F' => 12,  // Género
            'G' => 15,  // Estado Civil
            'H' => 15,  // Ciudad
            'I' => 30,  // Dirección
            'J' => 12,  // Estado
            'K' => 15,  // Fecha Bautismo
            'L' => 20,  // Lugar Bautismo
            'M' => 15,  // Fecha Membresía
            'N' => 20,  // Rol Eclesiástico
            'O' => 12,  // Es Servidor
            'P' => 30,  // Notas
        ];
    }
}

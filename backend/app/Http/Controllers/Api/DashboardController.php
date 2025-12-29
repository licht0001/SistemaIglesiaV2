<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Event;
use App\Models\Ministry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Obtener estadísticas del dashboard
     */
    public function stats(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        // Miembros totales
        $totalMembers = Member::count();
        $newMembersThisMonth = Member::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        // Servidores activos
        $totalServers = Member::where('is_server', true)->count();
        $activeMinistries = Ministry::where('is_active', true)->count();

        // Bautizados
        $totalBaptized = Member::whereNotNull('baptism_date')->count();
        $baptizedThisYear = Member::whereYear('baptism_date', $year)
            ->whereNotNull('baptism_date')
            ->count();

        // Eventos del mes
        $eventsThisMonth = Event::whereYear('start_at', $year)
            ->whereMonth('start_at', $month)
            ->count();

        // Finanzas del mes (Corregido a ingreso/egreso)
        $ingresos = Transaction::where('type', 'ingreso')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $egresos = Transaction::where('type', 'egreso')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $saldo = $ingresos - $egresos;

        // Estructura de flujo de caja para el gráfico (Últimos 12 meses)
        $cashFlow = [
            'ingreso' => [],
            'egreso' => [],
            'saldo' => []
        ];

        // Obtener transacciones de los últimos 12 meses agrupadas
        $startDate = now()->subMonths(11)->startOfMonth();
        $monthlyData = Transaction::select(
                DB::raw("DATE_FORMAT(transaction_date, '%Y-%m') as month"),
                'type',
                DB::raw('SUM(amount) as total')
            )
            ->where('transaction_date', '>=', $startDate)
            ->groupBy('month', 'type')
            ->get();

        // Inicializar los 12 meses en 0
        for ($i = 11; $i >= 0; $i--) {
            $m = now()->subMonths($i)->format('Y-m');
            $cashFlow['ingreso'][$m] = 0;
            $cashFlow['egreso'][$m] = 0;
            $cashFlow['saldo'][$m] = 0;
        }

        // Llenar con datos reales
        foreach ($monthlyData as $data) {
            if (isset($cashFlow[$data->type][$data->month])) {
                $cashFlow[$data->type][$data->month] = (float) $data->total;
            }
        }

        // Calcular el saldo mensual
        foreach ($cashFlow['ingreso'] as $mKey => $incomeVal) {
            $cashFlow['saldo'][$mKey] = $incomeVal - $cashFlow['egreso'][$mKey];
        }

        // Cumpleaños del mes
        $birthdaysThisMonth = Member::whereMonth('birth_date', $month)
            ->whereNotNull('birth_date')
            ->get(['id', 'first_name', 'last_name', 'birth_date', 'phone']);

        // Próximos eventos
        $upcomingEvents = Event::where('start_at', '>=', now())
            ->where('status', 'programado')
            ->orderBy('start_at', 'asc')
            ->limit(5)
            ->get();

        // Breakdowns for the new cards
        $childrenMale = Member::where('category', 'niño')->where('gender', 'M')->count();
        $childrenFemale = Member::where('category', 'niño')->where('gender', 'F')->count();
        $adolescents = Member::where('category', 'adolescente')->count();
        $adultsSingle = Member::where('category', 'adulto')->where('marital_status', 'single')->count();
        $adultsMarried = Member::where('category', 'adulto')->where('marital_status', 'married')->count();

        // Áreas de servicio activas con conteo de miembros
        $serviceAreas = Ministry::where('is_active', true)
            ->withCount('members')
            ->orderBy('members_count', 'desc')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json([
            'members' => [
                'total' => $totalMembers,
                'new_this_month' => $newMembersThisMonth,
            ],
            'servers' => [
                'total' => $totalServers,
                'active_ministries' => $activeMinistries,
            ],
            'baptized' => [
                'total' => $totalBaptized,
                'this_year' => $baptizedThisYear,
            ],
            'events' => [
                'this_month' => $eventsThisMonth,
            ],
            'finances' => [
                'ingresos' => (float) $ingresos,
                'egresos' => (float) $egresos,
                'saldo' => (float) $saldo,
                'chart' => $cashFlow,
            ],
            'birthdays_this_month' => $birthdaysThisMonth,
            'upcoming_events' => $upcomingEvents,
            'service_areas' => $serviceAreas,
            'breakdown' => [
                'children_male' => $childrenMale,
                'children_female' => $childrenFemale,
                'adolescents' => $adolescents,
                'adults_single' => $adultsSingle,
                'adults_married' => $adultsMarried,
            ]
        ]);
    }
}

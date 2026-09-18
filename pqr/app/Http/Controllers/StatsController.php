<?php

namespace App\Http\Controllers;

use App\Constants\PqrsStatus;
use App\Constants\PqrsType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function pqrStatByStatus()
    {
        $currentYear = date('Y');

        // 1. Consultar conteo agrupado por estado y por mes del año actual
        $records = DB::table('pqrs')
            ->select(
                'estado',
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy('estado', DB::raw('MONTH(created_at)'))
            ->get();

        // 2. Mapeo de estados con sus etiquetas legibles
        $statuses = PqrsStatus::labels();

        // 3. Formatear datos para Chart.js (Crear un dataset por cada estado)
        $datasets = [];

        foreach ($statuses as $key => $label) {
            $monthlyData = [];

            // Recorrer los 12 meses (1 a 12)
            for ($month = 1; $month <= 12; $month++) {
                $record = $records->first(function ($item) use ($month, $key) {
                    return (int)$item->month === $month && $item->estado === $key;
                });

                $monthlyData[] = $record ? (int)$record->total : 0;
            }

            // Estructura compatible con Chart.js
            $datasets[] = [
                'label' => $label,
                'data'  => $monthlyData,
            ];
        }

        return response()->json([
            'labels'   => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            'datasets' => $datasets,
        ]);
    }

    public function pqrStatByType()
    {
        
        $records = DB::table('pqrs')
            ->select('tipo', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo')
            ->pluck('total', 'tipo'); // Retorna pares clave-valor (ej: ['peticion' => 12])

        
        $typeLabels = PqrsType::labels();

        $labels = [];
        $data = [];

        foreach ($typeLabels as $key => $label) {
            $labels[] = $label;
            $data[] = $records->get($key, 0); // Si no hay registros, asigna 0
        }

        return response()->json([
            'labels' => $labels,
            'data'   => $data,
        ]);
    }

    
}

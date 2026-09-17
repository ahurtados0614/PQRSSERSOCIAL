<?php

namespace App\Http\Controllers;

use App\Constants\PqrsChanel;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrackPqrRequest;
use App\Constants\PqrsType;
use App\Constants\PqrsStatus;
use App\Constants\PqrsPriority;
use App\Constants\TrackingActionType;
use App\Models\Pqrs;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class PqrTrackingController extends Controller
{
    public function track(TrackPqrRequest $request): JsonResponse
    {
        $radicado = $request->validated('radicado');

        // Buscar PQR con relaciones necesarias
        $pqr = Pqrs::query()
            ->with(['solicitante'])
            ->with(['seguimientos'])
            ->with(['seguimientos.usuario'])
            ->where('radicado', $radicado)
            ->first();

        if (!$pqr) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No se encontró ninguna PQR con el número de radicado ingresado.',
            ], 404);
        }

        // Mapear etiquetas legibles
        $pqr->tipo_label      = PqrsType::labels()[$pqr->tipo] ?? $pqr->tipo;
        $pqr->estado_label    = PqrsStatus::labels()[$pqr->estado] ?? $pqr->estado;
        $pqr->prioridad_label = PqrsPriority::labels()[$pqr->prioridad] ?? $pqr->prioridad;
        $pqr->canal_label     = PqrsChanel::labels()[$pqr->canal] ?? $pqr->canal;
        $pqr->seguimientos->transform(function ($seguimiento) {
            $seguimiento->tipo_accion_label = TrackingActionType::labels()[$seguimiento->tipo_accion]
                ?? $seguimiento->tipo_accion;

            return $seguimiento;
        });
        return response()->json([
            'status' => 'success',
            'data'   => $pqr,
        ], 200);
    }


    public function PqrTrackingView(Request $request): View
    {
        $radicado = $request->query('radicado') ?? '';
        // Pasamos el radicado a la vista
        return view('pqrs.tracking', compact('radicado'));
    }
}

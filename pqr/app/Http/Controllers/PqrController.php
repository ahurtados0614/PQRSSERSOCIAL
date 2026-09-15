<?php

namespace App\Http\Controllers;

use App\Constants\PqrsChanel;
use App\Constants\PqrsStatus;
use App\Http\Requests\StorePqrRequest;
use App\Models\Pqrs;
use App\Models\Solicitante;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PqrController extends Controller
{
    /**
     * Registrar una nueva PQR.
     */
    public function store(StorePqrRequest $request): JsonResponse
    {
        $pqr = DB::transaction(function () use ($request) {

            /*
             * Crear el solicitante.
             *
             * Los nombres recibidos por la API están en inglés,
             * mientras que los campos de la base de datos están
             * definidos en español.
             */
            $solicitante = Solicitante::create([
                'nombre' => $request->validated('name'),
                'apellido' => $request->validated('lastname'),
                'identificacion' => $request->validated('identification'),
                'email' => $request->validated('email'),
                'telefono' => $request->validated('phone'),
            ]);

            /*
             * Crear inicialmente la PQR con un radicado temporal.
             *
             * Se utiliza un valor corto y único porque el ID de la PQR
             * todavía no existe en este momento.
             */
            $pqr = Pqrs::create([
                'radicado' => 'T-' . uniqid(),

                /*
                 * Datos recibidos desde la API.
                 */
                'tipo' => $request->validated('type'),
                'titulo' => $request->validated('subject'),
                'descripcion' => $request->validated('description'),
                'categoria' => $request->validated('category'),
                'prioridad' => $request->validated('priority'),

                /*
                 * Valores controlados por el sistema.
                 */
                'estado' => PqrsStatus::RECIBIDA,
                'canal' => PqrsChanel::WEB,

                /*
                 * Relación con el solicitante.
                 */
                'solicitante_id' => $solicitante->id,

                /*
                 * Plazo inicial de respuesta:
                 * 15 días.
                 */
                'fecha_vencimiento' => now()->addDays(15),
            ]);

            /*
             * En este punto ya tenemos el ID generado por MySQL.
             *
             * Ejemplo:
             * PQ-2026-000001
             */
            $radicado = sprintf(
                'PQ-%s-%06d',
                $pqr->created_at->format('Y'),
                $pqr->id
            );

            /*
             * Reemplazar el radicado temporal
             * por el radicado definitivo.
             */
            $pqr->update([
                'radicado' => $radicado,
            ]);

            /*
             * Obtener nuevamente el registro actualizado.
             */
            return $pqr->fresh();
        });

        /*
         * Respuesta JSON para el frontend.
         */
        return response()->json([
            'message' => 'La PQR fue registrada correctamente.',
            'radicado' => $pqr->radicado,
            'estado' => $pqr->estado,
        ], 201);
    }

   
/**
 * Mostrar confirmación pública de la PQR registrada.
 */
public function confirmation(string $tracking_code)
{
    $pqr = Pqrs::where('radicado', $tracking_code)->firstOrFail();

    return view('pqrs.confirmation', [
        'pqr' => $pqr,
        'trackingCode' => $pqr->radicado,
    ]);
}

}
<?php

namespace App\Http\Controllers;

use App\Constants\PqrsChanel;
use App\Constants\PqrsStatus;
use App\Constants\PqrsType;
use App\Http\Requests\StorePqrRequest;
use App\Models\Pqrs;
use App\Models\Solicitante;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\IndexPqrRequest;
use App\Services\SendEmailService;

class PqrController extends Controller
{
    /**
     * Registrar una nueva PQR.
     */
    public function store(StorePqrRequest $request, SendEmailService $emailService): JsonResponse
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
             * PQR-2026-000001
             */
            $radicado = sprintf(
                'PQR-%s-%06d',
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

        $pqr->load('solicitante');
        $pqr->tipo = PqrsType::labels()[$pqr->tipo] ?? $pqr->tipo;
        $data = [
            'email'   => $pqr->solicitante->email,
            'subject' => 'Confirmación de radicado PQR # ' . $pqr->radicado . ' - ' . $pqr->titulo,
            'pqr'     => $pqr,
            'plantilla' => 'notification-new-pqr',
        ];
    
        // Llamamos al servicio reutilizable
        $emailService->execute($data);
        
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

    /**
     * Listar PQR con filtros y paginación.
     */
    public function index(IndexPqrRequest $request): JsonResponse
    {
        $query = Pqrs::query()
            ->with(['solicitante'])
            ->with(['seguimientos'])
            ->with(['seguimientos.usuario'])
            ->latest('created_at');

        $query->when(
            $request->filled('type'),
            fn($query) => $query->where(
                'tipo',
                $request->validated('type')
            )
        );

        $query->when(
            $request->filled('status'),
            fn($query) => $query->where(
                'estado',
                $request->validated('status')
            )
        );

        $query->when(
            $request->filled('priority'),
            fn($query) => $query->where(
                'prioridad',
                $request->validated('priority')
            )
        );

        $query->when(
            $request->filled('category'),
            fn($query) => $query->where(
                'categoria',
                'like',
                '%' . $request->validated('category') . '%'
            )
        );

        $pqrs = $query
            ->paginate(10)
            ->withQueryString();
        return response()->json($pqrs);
    }
}

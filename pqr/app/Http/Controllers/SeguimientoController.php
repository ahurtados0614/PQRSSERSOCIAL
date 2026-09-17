<?php

namespace App\Http\Controllers;

use App\Constants\PqrsChanel;
use App\Constants\PqrsPriority;
use App\Constants\PqrsStatus;
use App\Constants\PqrsType;
use App\Constants\TrackingActionType;
use App\Models\Pqrs;
use App\Models\Seguimiento;
use App\Http\Requests\UpdateSeguimientoRequest;
use App\Services\SendEmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SeguimientoController extends Controller
{
    /**
     * Actualizar estado y registrar gestión de una PQR.
     */
    public function update(UpdateSeguimientoRequest $request, Pqrs $pqr, SendEmailService $emailService): JsonResponse {
       
        $estadoAnterior = $request->validated('statusOldValue');
        $nuevoEstado = $request->validated('estado');

        $descripcion = trim(
            $request->validated('descripcion') ?? ''
        );

        /*
     * Mensajes predeterminados.
     */
        if ($descripcion === '') {
            $descripcion = match ($nuevoEstado) {
                PqrsStatus::RECIBIDA =>
                'La PQR ha sido recibida y se encuentra pendiente de gestión.',

                PqrsStatus::EN_GESTION =>
                'La PQR se encuentra actualmente en proceso de gestión.',

                default => null,
            };
        }

        /*
     * Resuelta y cerrada siempre necesitan comentario.
     */
        if (
            in_array($nuevoEstado, [
                PqrsStatus::RESUELTA,
                PqrsStatus::CERRADA,
            ], true)
            && empty($descripcion)
        ) {
            return response()->json([
                'message' =>
                'Debe ingresar un comentario para marcar la PQR como resuelta o cerrada.',
            ], 422);
        }

        DB::transaction(function () use (
            $pqr,
            $request,
            $nuevoEstado,
            $descripcion
        ) {

            $pqr->update([
                'prioridad' => $request->prioridad,
                'estado' => $nuevoEstado,
            ]);

            Seguimiento::create([
                'descripcion' => $descripcion,
                'tipo_accion' => $request->validated('tipo_accion'),
                'fecha_registro' => now(),
                'pqr_id' => $pqr->id,
                'usuario_id' => auth()->id(),
            ]);
        });
        $pqr->load('solicitante');
        $pqr->tipo = PqrsType::labels()[$pqr->tipo] ?? $pqr->tipo;
        $pqr->estado = PqrsStatus::labels()[$pqr->estado] ?? $pqr->estado;
        $pqr->prioridad = PqrsPriority::labels()[$pqr->prioridad] ?? $pqr->prioridad;
        $data = [
            'email'   => $pqr->solicitante->email,
            'subject' => 'Actualización de su PQR # ' . $pqr->radicado,
            'pqr'     => $pqr,
            'gestion'   => $pqr->estado,
            'plantilla' => 'notification-status-update',
        ];
    
        // Llamamos al servicio reutilizable
        $emailService->execute($data);
        
        return response()->json([
            'message' => 'La gestión de la PQR  con radicado No. '.$pqr->radicado.' fue registrada correctamente.',

            'data' => [
                'id' => $pqr->id,
                'estado_anterior' => $estadoAnterior,
                'estado' => $nuevoEstado,
            ],
        ]);
    }
    public function index(): View
    { //

        return view('pqrs.index', [
            'PqrsPriority' => PqrsPriority::labels(),
            'TrackingActionType' => TrackingActionType::labels(),
            'PqrsStatus' => PqrsStatus::labels(),
            'PqrsChanel' => PqrsChanel::labels(),
            'PqrsType' => PqrsType::labels(),
        ]);
    }
}

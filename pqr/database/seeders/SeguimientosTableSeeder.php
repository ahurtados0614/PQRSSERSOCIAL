<?php

namespace Database\Seeders;

use App\Constants\TrackingActionType;
use App\Models\Pqrs;
use App\Models\Seguimiento;
use App\Models\User;
use Illuminate\Database\Seeder;

class SeguimientosTableSeeder extends Seeder
{
    public function run(): void
    {
        $usuario = User::first();
        $pqr1 = Pqrs::where('radicado', 'PQR-2026-00001')->first();
        $pqr2 = Pqrs::where('radicado', 'PQR-2026-00002')->first();

        if ($pqr1) {
            Seguimiento::create([
                'descripcion'    => 'Solicitud recibida exitosamente desde el portal web.',
                'tipo_accion'    => TrackingActionType::COMENTARIO ?? 'comentario',
                'fecha_registro' => now()->subDays(2),
                'pqr_id'         => $pqr1->id,
                'usuario_id'     => null, // Acción automática del sistema
            ]);
        }

        if ($pqr2) {
            Seguimiento::create([
                'descripcion'    => 'Queja radicada en punto de atención presencial.',
                'tipo_accion'    => TrackingActionType::COMENTARIO ?? 'comentario',
                'fecha_registro' => now()->subDays(1),
                'pqr_id'         => $pqr2->id,
                'usuario_id'     => $usuario?->id,
            ]);

            Seguimiento::create([
                'descripcion'    => 'Se escala el caso con el coordinador de farmacia para verificación.',
                'tipo_accion'    => TrackingActionType::CAMBIO_ESTADO ?? 'cambio_estado',
                'fecha_registro' => now(),
                'pqr_id'         => $pqr2->id,
                'usuario_id'     => $usuario?->id,
            ]);
        }
    }
}
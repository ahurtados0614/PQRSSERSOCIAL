<?php

namespace Database\Seeders;

use App\Constants\TrackingActionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeguimientosTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('seguimientos')->insert([
            [
                'descripcion' => 'PQR recibida y registrada en el sistema.',
                'tipo_accion' => TrackingActionType::COMENTARIO,
                'fecha_registro' => now(),
                'pqr_id' => 1,
                'usuario_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Se inicia la gestión de la solicitud.',
                'tipo_accion' => TrackingActionType::CAMBIO_ESTADO,
                'fecha_registro' => now(),
                'pqr_id' => 2,
                'usuario_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Se realizó la gestión correspondiente y se da solución al caso.',
                'tipo_accion' => TrackingActionType::RESPUESTA,
                'fecha_registro' => now(),
                'pqr_id' => 3,
                'usuario_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
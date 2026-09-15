<?php

namespace Database\Seeders;

use App\Constants\PqrsChanel;
use App\Constants\PqrsPriority;
use App\Constants\PqrsStatus;
use App\Constants\PqrsType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PqrsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pqrs')->insert([
            [
                'radicado' => 'PQR-2026-000001',
                'tipo' => PqrsType::PETICION,
                'titulo' => 'Solicitud de información sobre servicios',
                'descripcion' => 'El ciudadano solicita información sobre los servicios disponibles.',
                'categoria' => 'Información',
                'prioridad' => PqrsPriority::MEDIA,
                'estado' => PqrsStatus::RECIBIDA,
                'canal' => PqrsChanel::WEB,
                'solicitante_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'radicado' => 'PQR-2026-000002',
                'tipo' => PqrsType::QUEJA,
                'titulo' => 'Inconformidad con la atención recibida',
                'descripcion' => 'El ciudadano manifiesta inconformidad con la atención recibida.',
                'categoria' => 'Atención al usuario',
                'prioridad' => PqrsPriority::ALTA,
                'estado' => PqrsStatus::EN_GESTION,
                'canal' => PqrsChanel::WEB,
                'solicitante_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'radicado' => 'PQR-2026-000003',
                'tipo' => PqrsType::RECLAMO,
                'titulo' => 'Reclamo relacionado con el servicio',
                'descripcion' => 'El ciudadano presenta un reclamo relacionado con el servicio recibido.',
                'categoria' => 'Servicio',
                'prioridad' => PqrsPriority::URGENTE,
                'estado' => PqrsStatus::RESUELTA,
                'canal' => PqrsChanel::PRESENCIAL,
                'solicitante_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
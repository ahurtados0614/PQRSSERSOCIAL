<?php
namespace Database\Seeders;

use App\Constants\PqrsChanel;
use App\Constants\PqrsPriority;
use App\Constants\PqrsStatus;
use App\Constants\PqrsType;
use App\Models\Pqrs;
use App\Models\Solicitante;
use Illuminate\Database\Seeder;

class PqrsTableSeeder extends Seeder
{
    public function run(): void
    {
        $solicitantes = Solicitante::all();

        if ($solicitantes->isEmpty()) {
            return;
        }

        $pqrs = [
            [
                'radicado'       => 'PQR-2026-00001',
                'tipo'           => PqrsType::PETICION ?? 'peticion',
                'titulo'         => 'Solicitud de historia clínica completa',
                'descripcion'    => 'Requiero una copia física de mi historia clínica del último semestre.',
                'categoria'      => 'Servicios Médicos',
                'prioridad'      => PqrsPriority::MEDIA ?? 'media',
                'estado'         => PqrsStatus::RECIBIDA ?? 'recibida',
                'canal'          => PqrsChanel::WEB ?? 'web',
                'solicitante_id' => $solicitantes->first()->id,
            ],
            [
                'radicado'       => 'PQR-2026-00002',
                'tipo'           => PqrsType::QUEJA ?? 'queja',
                'titulo'         => 'Inconformidad con tiempo de espera en farmacia',
                'descripcion'    => 'El tiempo de atención superó las 3 horas para la entrega de medicamentos.',
                'categoria'      => 'Atención al Cliente',
                'prioridad'      => PqrsPriority::ALTA ?? 'alta',
                'estado'         => PqrsStatus::EN_GESTION ?? 'en_gestion',
                'canal'          => PqrsChanel::PRESENCIAL ?? 'presencial',
                'solicitante_id' => $solicitantes->skip(1)->first()->id ?? $solicitantes->first()->id,
            ],
            [
                'radicado'       => 'PQR-2026-00003',
                'tipo'           => PqrsType::RECLAMO ?? 'reclamo',
                'titulo'         => 'Cobro duplicado de cuota moderadora',
                'descripcion'    => 'Se me realizó el cobro dos veces en la caja principal el día de ayer.',
                'categoria'      => 'Facturación',
                'prioridad'      => PqrsPriority::ALTA ?? 'alta',
                'estado'         => PqrsStatus::RESUELTA ?? 'resuelta',
                'canal'          => PqrsChanel::WEB ?? 'web',
                'solicitante_id' => $solicitantes->last()->id,
            ],
        ];

        foreach ($pqrs as $pqr) {
            Pqrs::updateOrCreate(
                ['radicado' => $pqr['radicado']],
                $pqr
            );
        }
    }
}
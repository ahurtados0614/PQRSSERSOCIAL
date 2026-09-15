<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolicitantesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('solicitantes')->insert([
            [
                'nombre' => 'Carlos',
                'apellido' => 'Pérez',
                'identificacion' => '100000001',
                'email' => 'carlos.perez@example.com',
                'telefono' => '3001234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María',
                'apellido' => 'Gómez',
                'identificacion' => '100000002',
                'email' => 'maria.gomez@example.com',
                'telefono' => '3012345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Andrés',
                'apellido' => 'Rodríguez',
                'identificacion' => '100000003',
                'email' => 'andres.rodriguez@example.com',
                'telefono' => '3023456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
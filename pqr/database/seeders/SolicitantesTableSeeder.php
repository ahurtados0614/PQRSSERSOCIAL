<?php
namespace Database\Seeders;

use App\Models\Solicitante;
use Illuminate\Database\Seeder;

class SolicitantesTableSeeder extends Seeder
{
    public function run(): void
    {
        $solicitantes = [
            [
                'nombre'         => 'Juan Carlos',
                'apellido'       => 'Pérez Gómez',
                'identificacion' => '1098765432',
                'email'          => 'developersgroup83@gmail.com',
                'telefono'       => '3001234567',
            ],
            [
                'nombre'         => 'María Fernanda',
                'apellido'       => 'López Martínez',
                'identificacion' => '1087654321',
                'email'          => 'developersgroup83@gmail.com',
                'telefono'       => '3109876543',
            ],
            [
                'nombre'         => 'Carlos Alberto',
                'apellido'       => 'Rodríguez Silva',
                'identificacion' => '1076543210',
                'email'          => 'developersgroup83@gmail.com',
                'telefono'       => '3201239876',
            ],
        ];

        foreach ($solicitantes as $solicitante) {
            Solicitante::updateOrCreate(
                ['identificacion' => $solicitante['identificacion']],
                $solicitante
            );
        }
    }
}
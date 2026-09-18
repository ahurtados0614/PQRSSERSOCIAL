<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class, // Crea los roles administradores/gestores
            UsersTableSeeder::class, // Crea los usuarios administradores/gestores
            SolicitantesTableSeeder::class, // Crea los solicitantes de las PQRs
            PqrsTableSeeder::class,         // Crea las PQRs asociadas a solicitantes
            SeguimientosTableSeeder::class, // Crea las trazas de seguimiento
        ]);

        
    }
}

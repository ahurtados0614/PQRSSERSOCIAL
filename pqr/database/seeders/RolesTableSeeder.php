<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->updateOrInsert(
            ['name' => 'Administrador'],
            [
                'status' => '1',
                'delete' => '0',
                'user_create' => 'Sistema',
                'date_create' => now()->toDateString(),
            ]
        );

        DB::table('roles')->updateOrInsert(
            ['name' => 'Agente'],
            [
                'status' => '1',
                'delete' => '0',
                'user_create' => 'Sistema',
                'date_create' => now()->toDateString(),
            ]
        );

        DB::table('roles')->updateOrInsert(
            ['name' => 'Supervisor'],
            [
                'status' => '1',
                'delete' => '0',
                'user_create' => 'Sistema',
                'date_create' => now()->toDateString(),
            ]
        );
    }
}
<?php
namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'id'          => 1,
                'name'        => 'ADMINISTRADOR',
                'status'      => '1',
                'delete'      => '0',
                'user_create' => 'SYSTEM',
                'date_create' => now()->toDateString(),
            ],
            [
                'id'          => 2,
                'name'        => 'Gestor PQRS',
                'status'      => '1',
                'delete'      => '0',
                'user_create' => 'SYSTEM',
                'date_create' => now()->toDateString(),
            ],
            [
                'id'          => 3,
                'name'        => 'Supervisor PQRS',
                'status'      => '1',
                'delete'      => '0',
                'user_create' => 'SYSTEM',
                'date_create' => now()->toDateString(),
            ],
        ];

        foreach ($roles as $role) {
            Roles::updateOrCreate(['id' => $role['id']], $role);
        }
    }
}
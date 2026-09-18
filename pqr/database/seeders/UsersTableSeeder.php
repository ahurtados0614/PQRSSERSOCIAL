<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Administrador',
                'email'    => 'admin@example.com',
                'password' => Hash::make('12345678'),
                'id_rol'   => 1, // ADMINISTRADOR
                'delete'   => '0',
            ],
            [
                'name'     => 'Gestor PQRS',
                'email'    => 'gestor@example.com',
                'password' => Hash::make('12345678'),
                'id_rol'   => 2, // Gestor PQRS
                'delete'   => '0',
            ],
            [
                'name'     => 'Supervisor PQRS',
                'email'    => 'supervisor@example.com',
                'password' => Hash::make('12345678'),
                'id_rol'   => 3, // Supervisor PQRS
                'delete'   => '0',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'id_rol' => 1,
            'password' => Hash::make('12345678'),
        ]);

        User::factory()->create([
            'name' => 'Gestor PQRS',
            'email' => 'gestor@example.com',
            'id_rol' => 2,
            'password' => Hash::make('12345678'),
        ]);
    }
}

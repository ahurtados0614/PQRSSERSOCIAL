<?php

namespace Tests\Feature;

use App\Constants\PqrsChanel;
use App\Constants\PqrsStatus;
use Tests\TestCase;

class PqrTest extends TestCase
{
    public function test_puede_registrar_una_pqr(): void
    {
        $data = [
            'type' => 'queja',
            'category' => 'category test',
            'subject' => 'Prueba automatizada',
            'description' => 'PQR registrada mediante PHPUnit',
            'priority' => 'alta',
            'identification' => '1245368',
            'name' => 'Pipe',
            'lastname' => 'Pelaez',
            'email' => 'email@test.com',
            'phone' => '987654345678',
        ];

        $response = $this->postJson('/api/pqrs', $data);

        $response->assertCreated();

        $response->assertJsonStructure([
            'message',
            'radicado',
            'estado',
        ]);

        $response->assertJson([
            'message' => 'La PQR fue registrada correctamente.',
            'estado' => PqrsStatus::RECIBIDA,
        ]);

        $response->assertJsonPath(
            'radicado',
            fn ($radicado) => preg_match('/^PQ-\d{4}-\d{6}$/', $radicado) === 1
        );

        $this->assertDatabaseHas('solicitantes', [
            'identificacion' => '1245368',
            'nombre' => 'Pipe',
            'apellido' => 'Pelaez',
            'email' => 'email@test.com',
            'telefono' => '987654345678',
        ]);

        $this->assertDatabaseHas('pqrs', [
            'tipo' => 'queja',
            'titulo' => 'Prueba automatizada',
            'descripcion' => 'PQR registrada mediante PHPUnit',
            'categoria' => 'category test',
            'prioridad' => 'alta',
            'estado' => PqrsStatus::RECIBIDA,
            'canal' => PqrsChanel::WEB,
        ]);
    }
}
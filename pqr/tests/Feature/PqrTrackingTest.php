<?php

namespace Tests\Feature;

use Tests\TestCase;

class PqrTrackingTest extends TestCase
{
    /**
     * Probar la búsqueda usando un radicado que ya existe.
     * Previamente debe correr las migraciones
     */

    //Radicado sí existe
    public function test_return_200(): void
    {
        $radicado = "PQR-2026-00001";
        $response = $this->getJson("/api/pqr/rastreo?radicado={$radicado}");

        // Afirmaciones sobre la respuesta
        $response->assertStatus(200);

        $response->assertJson([
            'status' => 'success',
            'data'   => [
                'radicado' => 'PQR-2026-00001',
            ],
        ]);

        // Validar que la estructura devuelva los campos mapeados por el controlador
        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'radicado',
                'tipo_label',
                'estado_label',
                'prioridad_label',
                'canal_label',
                'solicitante',
                'seguimientos',
            ],
        ]);
    }

    //Retorna 404 si el radicado no existe
    public function test_return_404(): void
    {
        $response = $this->getJson('/api/pqr/rastreo?radicado=PQR-9999-99999');

        $response->assertStatus(404);

        $response->assertJson([
            'status'  => 'error',
            'message' => 'No se encontró ninguna PQR con el número de radicado ingresado.',
        ]);
    }
}
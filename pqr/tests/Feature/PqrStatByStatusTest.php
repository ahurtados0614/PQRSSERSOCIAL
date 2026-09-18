<?php

namespace Tests\Feature;

use App\Models\Pqrs;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PqrStatByStatusTest extends TestCase
{

    /**
     * Probar la consulta de estadísticas de PQRs agrupadas por estado y mes del año actual.
     */
    public function test_obtener_estadisticas_de_pqrs_por_estado(): void
    {
        //Obtener el primer usuario
        $user = User::first();

        //Preparar datos de prueba en el año actual
        $currentYear = date('Y');


        // Petición GET autenticada al endpoint de estadísticas
        $response = $this->actingAs($user)
            ->getJson('/api/pqr/stat-by-status');

        //Aserciones de estado y estructura JSON
        $response->assertStatus(200)
            ->assertJsonStructure([
                'labels',
                'datasets' => [
                    '*' => [
                        'label',
                        'data',
                    ],
                ],
            ])
            ->assertJson([
                'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            ]);

        //Validar que la respuesta contenga 12 meses en los arreglos de data
        $datasets = $response->json('datasets');
        $this->assertNotEmpty($datasets);
        $this->assertCount(12, $datasets[0]['data']);
    }
}

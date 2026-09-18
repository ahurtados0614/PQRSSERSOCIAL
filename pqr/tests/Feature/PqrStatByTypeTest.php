<?php

namespace Tests\Feature;

use App\Models\Pqrs;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PqrStatByTypeTest extends TestCase
{

    /**
     * Probar la consulta de estadísticas de PQRs por tipo.
     */
    public function test_obtener_estadisticas_de_pqrs_por_tipo(): void
    {
        //Obtener el primer usuario
        $user = User::first();


        // Petición GET autenticada al endpoint de estadísticas
        $response = $this->actingAs($user)
            ->getJson('/api/pqr/stat-by-type');

        //Aserciones de estado y estructura JSON
        $response->assertStatus(200)
            ->assertJsonStructure([
                'labels',
                'data'
            ])
            ->assertJson([
                'labels' => ['Petición', 'Queja', 'Reclamo'],
            ]);

        //Validar que la respuesta contenga 12 meses en los arreglos de data
        $labels = $response->json('labels');
        $this->assertNotEmpty($labels);
        $this->assertCount(3, $labels);
    }
}

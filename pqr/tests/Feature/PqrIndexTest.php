<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Roles;
use App\Models\User;
use Tests\TestCase;

class PqrIndexTest extends TestCase
{
    /**
     * Probar el listado filtrado de PQRs.
     * 
     */
    public function test_usuario_con_rol_autorizado_puede_listar_pqrs_con_filtros(): void
    {
        $user = User::first();
        $type = "peticion";
        $status = "recibida";
        $priority = "urgente";
        //Ejecutar la petición con la sesión iniciada
        $response = $this->actingAs($user)
    ->getJson("/api/pqr?type={$type}&status={$status}&priority={$priority}");

        //Verificaciones de la respuesta HTTP y estructura JSON
        $response->assertStatus(200);
        

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'radicado',
                    'tipo',
                    'estado',
                    'prioridad',
                    'solicitante',
                    'seguimientos',
                ],
            ],
            'total',
        ]);
    }
}
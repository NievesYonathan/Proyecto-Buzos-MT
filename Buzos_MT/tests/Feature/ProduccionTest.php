<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Produccion;

class ProduccionTest extends TestCase
{
    //use RefreshDatabase;

    public function test_consulta_de_todos_los_productos()
    {
        // Creamos algunas producciones de prueba
        \App\Models\Produccion::factory()->count(3)->create();

        $response = $this->getJson('/api/producciones');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'producto' => [
                    '*' => [
                        'id_produccion',
                        'pro_nombre',
                        'pro_cantidad',
                        'pro_etapa',
                        'pro_fecha_inicio',
                        'pro_fecha_fin'
                    ]
                ]
            ]);
    }

    public function test_crear_una_produccion()
    {
        $payload = [
            'pro_nombre' => 'Buzo Deportivo3',
            'pro_fecha_inicio' => '2025-05-20',
            'pro_fecha_fin' => '2025-05-25',
            'pro_cantidad' => 300,
            'pro_etapa' => 1
        ];

        $response = $this->postJson('/api/nueva-produccion', $payload);

        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 201,
                     'producto' => [
                         'pro_nombre' => 'Buzo Deportivo3'
                     ]
                 ]);

        $this->assertDatabaseHas('produccion', [
            'pro_nombre' => 'Buzo Deportivo3'
        ]);
    }

    public function test_mostrar_un_producto()
    {
        $produccion = \App\Models\Produccion::factory()->create([
            'pro_nombre' => 'Producto único1'
        ]);

        $response = $this->getJson("/api/produccion/{$produccion->id_produccion}");

        $response->assertStatus(200)
                    ->assertJson([
                        'producto' => [
                            'id_produccion' => $produccion->id_produccion,
                            'pro_nombre' => 'Producto único1',
                        ],
                        'status' => 200
                    ]);    
    }

    public function test_actualizar_un_producto()
    {
        $produccion = \App\Models\Produccion::factory()->create([
            'pro_nombre' => 'Chaqueta Invierno'
        ]);

        $nuevoNombre = 'Nombre Actualizado';

        $response = $this->putJson("/api/produccion-editar/{$produccion->id_produccion}", [
            'produccion_nombre' => $nuevoNombre,
            'produccion_fecha_fin' => $produccion->pro_fecha_fin->format('Y-m-d'), // o como corresponda
            'produccion_cantidad' => $produccion->pro_cantidad,
            'produccion_etapa' => $produccion->pro_etapa,
        ]);

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'pro_nombre' => $nuevoNombre
                ]);

        $this->assertDatabaseHas('produccion', [
            'id_produccion' => $produccion->id_produccion,
            'pro_nombre' => $nuevoNombre
        ]);
    }

    public function test_eliminar_un_producto()
    {
        $produccion = \App\Models\Produccion::factory()->create();

        $response = $this->deleteJson("/api/produccion-eliminar/{$produccion->id_produccion}");

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Producción eliminada correctamente'
                ]);

        $this->assertDatabaseMissing('produccion', [
            'id_produccion' => $produccion->id_produccion
        ]);
    }

}

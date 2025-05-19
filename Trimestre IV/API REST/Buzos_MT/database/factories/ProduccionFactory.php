<?php

namespace Database\Factories;

use App\Models\Produccion;
use App\Models\Etapas;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProduccionFactory extends Factory
{
    protected $model = Produccion::class;

    public function definition()
    {
        return [
            'pro_nombre' => $this->faker->words(2, true),
            'pro_fecha_inicio' => $this->faker->date(),
            'pro_fecha_fin' => $this->faker->date(),
            'pro_cantidad' => $this->faker->numberBetween(50, 500),
            'pro_etapa' => Etapas::factory(), // o un ID fijo existente
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Etapas;
use Illuminate\Database\Eloquent\Factories\Factory;

class EtapasFactory extends Factory
{
    protected $model = Etapas::class;

    public function definition()
    {
        return [
            'eta_nombre' => $this->faker->word(),
            'eta_descripcion' => $this->faker->sentence(),
        ];
    }
}

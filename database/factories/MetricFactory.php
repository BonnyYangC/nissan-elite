<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MetricFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //nothing happen here but still keep this factory
        return [
            //'identifier' => Str::random(5),
            //'position' => $this->faker->randomElement(['F' ,'M', 'R']),
            //'type' => $this->faker->randomElement(['custom', 'shared']),
            //'label' => Str::random(5),
            //'color' => null,
            //'order' => $this->faker->numberBetween(1, 10),
            //'title' => $this->faker->text(50),
            //'period' => $this->faker->randomElement(['quarterly', '']),
            //'metrics' => $this->faker->json(100),
            //'guides' => $this->faker->json(100),
            //'ref' => $this->faker->text(50),
            'year' => config('view.theme'),
            //'updated_at' => Carbon::now(),
            //'created_at' => Carbon::now()
        ];
    }
}

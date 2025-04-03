<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year' => config('view.theme'),
            //'updated_at' => Carbon::now(),
            //'created_at' => Carbon::now()
        ];
    }
}

<?php

namespace Database\Factories\Guild;

use Illuminate\Database\Eloquent\Factories\Factory;

class MembersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year' => config('elite.YEAR'),
        ];
    }
}

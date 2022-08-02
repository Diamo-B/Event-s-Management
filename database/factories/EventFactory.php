<?php

namespace Database\Factories;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence($nbWords = 5, $variableNbWords = true),
            'object' => fake()->sentence($nbWords = 30, $variableNbWords = true),
            'startingAt' => Carbon::tomorrow(),
            'endingAt' => new Carbon('first day of January 2023'),
            'location' => fake()->city(),
            'room' => fake()->word(),
        ];
    }
}

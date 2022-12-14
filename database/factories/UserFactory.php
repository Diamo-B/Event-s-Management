<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'roleId' => null,
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'email_verified_at' => null,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function Coordinator()
    {
        return $this->state(function (array $attributes) {
            return [
                'roleId' => 1,
            ];
        });
    }

    public function TopManager()
    {
        return $this->state(function (array $attributes) {
            return [
                'roleId' => 2,
            ];
        });
    }

    public function Participant()
    {
        return $this->state(function (array $attributes) {
            return [
                'roleId' => 3,
            ];
        });
    }
}

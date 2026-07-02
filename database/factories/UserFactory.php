<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'national_id' => fake()->unique()->numerify('##########'),
            'password' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
        ];
    }
}

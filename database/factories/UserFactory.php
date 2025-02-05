<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Office;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female']);
        $roles = ['admin', 'user', 'mod'];
        $num = rand(1, 15);
        if ($gender[0] == 'm' && $num % 2 == 0) {
            $num++;
        } elseif ($gender[0] == 'f' && $num % 2 == 1) {
            $num--;
        }
        $avatarPath = ['avatars/avatar-' . $num . '.png'];

        return [
            'last_name' => fake()->lastName($gender),
            'first_name' => fake()->firstName($gender),
            'middle_name' => fake()->lastName($gender),
            'prefix' => fake()->optional()->title($gender),
            'suffix' => fake()->optional()->suffix(),
            'gender' => $gender,
            'avatar' => fake()->optional(0.75)->randomElement($avatarPath),
            'role' => fake()->randomElement($roles),

            'office_id' => Office::inRandomOrder()->first()->id, // Assigning a random office
            'designation' => $this->faker->jobTitle,
            'phone' => "09" . $this->faker->randomNumber(9, true),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'zip' => $this->faker->postcode,

            'email' => fake()->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

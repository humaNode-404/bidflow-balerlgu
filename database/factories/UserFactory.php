<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Office;
use App\Models\Designation;

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
        $num = rand(1, 15);
        if ($gender[0] == 'm' && $num % 2 == 0) {
            $num++;
        } elseif ($gender[0] == 'f' && $num % 2 == 1) {
            $num--;
        }
        $avatarPath = ['/storage/avatars/avatar-' . $num . '.png'];

        return [
            'last_name' => fake()->lastName($gender),
            'first_name' => fake()->firstName($gender),
            'middle_name' => fake()->lastName($gender),
            'suffix' => fake()->optional()->suffix(),
            'gender' => $gender,
            'avatar' => fake()->optional(0.75)->randomElement($avatarPath),
            'role' => 'end-user',

            'office_id' => Office::inRandomOrder()->first()->id,
            'designation_id' => Designation::inRandomOrder()->first()->id,
            'phone' => "09" . $this->faker->randomNumber(9, true),
            'address' => $this->faker->address,

            'email' => fake()->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('user'),
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

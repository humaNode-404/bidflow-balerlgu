<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\PrMode;
use App\Models\Prdoc;
use App\Models\Office;
use App\Models\User;

class PrdocSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Loop to create a set number of Prdoc entries
        foreach (range(1, 10) as $index) {
            // Get random end_office and end_user from the database
            $end_office = Office::inRandomOrder()->first();
            $end_user = User::inRandomOrder()->first();

            Prdoc::create([
                'number' => $faker->unique()->numerify('###-##-###-####'), // A random number like 000-00-000-0000
                'mode' => PrMode::cases()[array_rand(PrMode::cases())]->value, // Random mode
                'desc' => $faker->sentence(2), // Random description
                'purpose' => $faker->sentence(10), // Same as desc, for simplicity
                'event_need' => $faker->dateTimeBetween('+1 month', '+5 months')->format('Y-m-d'), // Random date for event need
                'event_start' => $faker->dateTimeThisYear()->format('Y-m-d'), // Random start date
                'event_end' => $faker->dateTimeThisYear()->format('Y-m-d'), // Random end date
                'event_loc' => "Baler, Aurora",
                'office' => $end_office->id, // Random office ID from existing offices
                'user' => $end_user->id, // Random user ID from existing users
                'status' => $faker->randomElement(['pending', 'in progress', 'on hold', 'completed']), // Random status
                'value' => $faker->randomFloat(2, 1000, 100000), // Random monetary value up to a billion
                'archived' => $faker->boolean(10), // Random archived status
                'starred' => $faker->numberBetween(1, 7), // Random starred value (only up to 7)
            ]);
        }
    }
}

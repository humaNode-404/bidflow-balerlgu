<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(49)->create();

        User::factory()->create([
            'last_name' => 'Marzan',
            'first_name' => 'Reymark',
            'middle_name' => 'Libed',
            'prefix' => 'Mr.',
            'suffix' => 'Jr.',
            'role' => 'admin',
            'email' => 'marzan@gmail.com',
            'password' => Hash::make('mypassword'),
        ]);
    }
}

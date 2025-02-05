<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Prdoc;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OfficeSeeder::class,
        ]);

        // Create an admin user
        User::factory()->create([
            'last_name' => 'Marzan',
            'first_name' => 'Reymark',
            'middle_name' => 'Libed',
            'role' => 'admin',
            'prefix' => 'Mr.',
            'suffix' => 'Jr.',
            'gender' => 'male',
            'avatar' => 'avatars/avatar-9.png',
            'office_id' => '1',
            'designation' => 'BAC Chairman',
            'phone' => '09669401992',
            'address' => 'Recto St. Brgy. Suklayin',
            'city' => 'Baler',
            'province' => 'Aurora',
            'zip' => '3201',
            'email' => 'rymemarzan.stud.ofclacc1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('mypassword'),
        ]);

        User::factory()->create([
            'last_name' => 'Portera',
            'first_name' => 'Angel',
            'middle_name' => 'Velasco',
            'role' => 'mod',
            'prefix' => '',
            'suffix' => '',
            'gender' => 'female',
            'avatar' => 'avatars/avatar-10.png',
            'office_id' => '2',
            'designation' => 'TWG Chairman',
            'phone' => '09232652345',
            'address' => 'Brgy. Buhangin',
            'city' => 'Baler',
            'province' => 'Aurora',
            'zip' => '3201',
            'email' => 'angel@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('angel-password'),
        ]);

        User::factory()->create([
            'last_name' => 'Lumasac',
            'first_name' => 'Azenith',
            'middle_name' => 'Marzan',
            'role' => 'user',
            'prefix' => '',
            'suffix' => '',
            'gender' => 'female',
            'avatar' => 'avatars/avatar-14.png',
            'office_id' => '7',
            'designation' => 'PDO Staff',
            'phone' => '09871234567',
            'address' => 'Baler',
            'city' => 'Baler',
            'province' => 'Aurora',
            'zip' => '3201',
            'email' => 'aze@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('aze-password'),
        ]);

        User::factory(49)->create();

        $this->call([
            PrdocSeeder::class,
        ]);

        $this->call([
            StageSeeder::class,
        ]);
    }
}

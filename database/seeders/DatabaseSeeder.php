<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OfficeSeeder::class,
            DesignationSeeder::class,
            RolePermissionSeeder::class,
        ]);

        // Create an admin user
        User::factory()->create([
            'last_name' => 'Marzan',
            'first_name' => 'Reymark',
            'middle_name' => 'Libed',
            'role' => 'admin',
            'suffix' => 'Jr.',
            'gender' => 'male',
            'avatar' => '/storage/avatars/avatar-9.png',
            'office_id' => '1',
            'designation_id' => '33',
            'phone' => '09669401992',
            'address' => 'Recto St. Brgy. Suklayin',
            'email' => 'rymemarzan.stud.ofclacc1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('my-password'),
        ])->assignRole('admin');

        User::factory()->create([
            'last_name' => 'Portera',
            'first_name' => 'Angel',
            'middle_name' => 'Velasco',
            'role' => 'bac',
            'suffix' => '',
            'gender' => 'female',
            'avatar' => '/storage/avatars/avatar-10.png',
            'office_id' => '13',
            'designation_id' => '34',
            'phone' => '09232652345',
            'address' => 'Brgy. Buhangin',
            'email' => 'angel@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('angel-password'),
        ])->assignRole('bac');

        User::factory()->create([
            'last_name' => 'Lumasac',
            'first_name' => 'Azenith',
            'middle_name' => 'Marzan',
            'role' => 'end-user',
            'suffix' => '',
            'gender' => 'female',
            'avatar' => '/storage/avatars/avatar-14.png',
            'office_id' => '7',
            'designation_id' => '53',
            'phone' => '09871234567',
            'address' => 'Baler',
            'email' => 'aze@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('aze-password'),
        ])->assignRole('end-user');

        User::factory(49)->create()->each(function ($user) {
            $user->assignRole('end-user');
        });

        $this->call([
            PrdocSeeder::class,
            StageSeeder::class,
        ]);
    }
}

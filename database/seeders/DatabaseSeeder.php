<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Prdoc;
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
        ]);

        User::factory()->create([
            'last_name' => 'Marzan',
            'first_name' => 'Reymark',
            'middle_name' => 'Libed',
            'prefix' => 'Mr.',
            'suffix' => 'Jr.',
            'gender' => 'male',
            'avatar' => 'http://[::1]:5173/resources/images/profiles/profile-1.png',
            'role' => 'admin',
            'office_id' => '1',
            'designation' => 'BAC Chairman',
            'phone' => '09669401992',
            'address' => 'Recto St. Brgy. Suklayin',
            'city' => 'Baler',
            'province' => 'Aurora',
            'zip' => '3201',
            'status' => 'active',
            'email' => 'rymemarzan.stud.ofclacc1@gmail.com',
            'password' => Hash::make('mypassword'),
        ]);

        User::factory(49)->create();

        $this->call([
            PrdocSeeder::class,
        ]);

        $this->call([
            StageSeeder::class,
        ]);

        // Limit starred Pdocs to 7 per user
        $users = User::all();
        foreach ($users as $user) {
            $starredPdocs = Prdoc::where('user_id', $user->id)->take(7)->update(['starred' => 1]);
        }

    }
}

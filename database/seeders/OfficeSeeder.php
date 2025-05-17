<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;
use Illuminate\Support\Facades\Storage;

class OfficeSeeder extends Seeder
{
    public function run()
    {
        // Load office data from JSON file
        $offices = json_decode(Storage::get('static-data/offices.json'), true);

        // Insert data into the 'offices' table
        foreach ($offices as $data) {
            Office::create([
                'name' => $data['name'],
                'abbr' => $data['abbr'],
                'user_group' => $data['user_group'],
                'avatar' => $data['avatar'],
            ]);
        }
    }
}
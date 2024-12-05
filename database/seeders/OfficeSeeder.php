<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;
use Illuminate\Support\Facades\File;

class OfficeSeeder extends Seeder
{
    public function run()
    {
        // Load office data from JSON file
        $officeData = json_decode(File::get(storage_path('app/office_data.json')), true);

        // Insert data into the 'offices' table
        foreach ($officeData as $data) {
            Office::create([
                'name' => $data['name'],
                'abbr' => $data['abbr'],
                'avatar' => $data['avatar'], // Leave empty string as specified
            ]);
        }
    }
}

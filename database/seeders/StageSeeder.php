<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prdoc;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Support\Facades\File;

class StageSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $prProcess = json_decode(File::get(storage_path('app/pr_process.json')), true);

        $prdocs = Prdoc::all();
        foreach ($prdocs as $prdoc) {
            $rangeEnd = rand(1, 31);
            $dayInterval = rand(1, 5);
            $last_date = $prdoc->event_start;
            $endDate = sprintf('+%d days', $dayInterval);
            $cat = $faker->dateTimeBetween($last_date, $endDate)->format('Y-m-d');

            foreach (range(0, $rangeEnd) as $index) {
                $status = $index != $rangeEnd ? 'completed' : $faker->randomElement(['pending', 'in progress', 'on hold']);
                $prProcessItem = $prProcess[$index];

                Stage::create([
                    'prdoc_id' => $prdoc->id,
                    'status' => $status,
                    'user_id' => $prdoc->user_id,
                    'main_proc' => $prProcessItem['main_proc'],
                    'proc' => $prProcessItem['proc'],
                    'desc' => $faker->sentence(7),
                    'received_at' => $last_date,
                    'completed_at' => $status != 'completed' ? null : $cat,
                ]);

                $dayInterval = rand(0, 2);
                $endDate = sprintf('+%d days', $dayInterval);
                $last_date = $faker->dateTimeBetween($cat, $cat)->format('Y-m-d');
                $last_date = $faker->dateTimeBetween($cat, $endDate)->format('Y-m-d');

                $dayInterval = rand(1, 5);
                $endDate = sprintf('+%d days', $dayInterval);
                $cat = $faker->dateTimeBetween($last_date, $endDate)->format('Y-m-d');
            }
        }
    }
}

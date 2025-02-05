<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prdoc;
use App\Models\Stage;
use App\Models\StageAction;
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
            $rangeEnd = rand(1, 30);
            $last_date = $prdoc->event_start;
            $endDate = (new \DateTime($last_date))->modify(sprintf('+%d days', rand(1, 5)))->format('Y-m-d');
            $cat = $faker->dateTimeBetween($last_date, $endDate)->format('Y-m-d');

            foreach (range(0, $rangeEnd) as $index) {
                $status = $index != $rangeEnd ? 'completed' : $faker->randomElement(['pending', 'in progress', 'on hold']);
                $prProcessItem = $prProcess[$index];

                StageAction::create([
                    'prdoc_id' => $prdoc->id,
                    'status' => $status,
                    'incharge' => $prProcessItem['incharge'],
                    'user_group' => $prProcessItem['user_group'],
                    'proc_no' => $prProcessItem['proc_no'],
                    'main_proc' => $prProcessItem['main_proc'],
                    'proc' => $prProcessItem['proc'],
                    'desc' => $prProcessItem['desc'],
                    'received_at' => $last_date,
                    'completed_at' => $status != 'completed' ? null : $cat,
                    'created_at' => $last_date,
                ]);

                $last_date = (new \DateTime($cat))->modify(sprintf('+%d days', rand(1, 5)))->format('Y-m-d');

                $endDate = (new \DateTime($last_date))->modify(sprintf('+%d days', rand(1, 5)))->format('Y-m-d');
                $cat = $faker->dateTimeBetween($last_date, $endDate)->format('Y-m-d');
            }
        }
    }
}

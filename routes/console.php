<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->everyMinute();

Schedule::command('backup:clean')->daily()->at('07:00');
Schedule::command('backup:run -vvv')->daily()->at('07:30');

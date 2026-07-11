<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:check-mantenciones-proximas')->dailyAt('08:00');
Schedule::command('app:check-stock-repuestos')->dailyAt('08:00');

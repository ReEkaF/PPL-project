<?php

use App\Jobs\NotifikasiTenggatTugas;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:calculate-denda')->everyMinute();
Schedule::command('app:notifikasi-tenggat-peminjaman')->everyMinute();
Schedule::job(new NotifikasiTenggatTugas)->everyMinute();

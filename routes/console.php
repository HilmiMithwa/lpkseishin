<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Meeting;
use App\Notifications\MeetingReminder;
use Illuminate\Support\Facades\Notification;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    // Current time in WIB
    $now = now()->addHours(7);
    
    // Target time is exactly 5 minutes from now
    $targetStart = $now->copy()->addMinutes(5)->startOfMinute();
    $targetEnd = $now->copy()->addMinutes(5)->endOfMinute();
    
    $meetings = Meeting::with(['mapel.batch.students', 'mapel.guru'])
        ->whereBetween('waktu_mulai', [$targetStart, $targetEnd])
        ->where('status', 'scheduled') // only notify for scheduled meetings
        ->get();

    foreach ($meetings as $meeting) {
        // Notify Teacher
        if ($meeting->mapel && $meeting->mapel->guru) {
            $meeting->mapel->guru->notify(new MeetingReminder($meeting));
        }

        // Notify Students
        if ($meeting->mapel && $meeting->mapel->batch) {
            $students = $meeting->mapel->batch->students;
            Notification::send($students, new MeetingReminder($meeting));
        }
    }
})->everyMinute();

<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\DailyRecord;

class UpdateDailyRecordOnUserDelete
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserDeleted  $event
     * @return void
     */
    public function handle(UserDeleted $event)
    {
        $user = $event->user;

        $dailyRecord = DailyRecord::whereDate('date', now()->toDateString())->firstOrCreate([
            'date' => now()->toDateString(),
        ]);

        if ($user->gender === 'male') {
            $dailyRecord->male_count -= 1;
            $dailyRecord->male_avg_count = $dailyRecord->male_count > 0
                ? $user->where('gender', 'male')->avg('age')
                : null;
        } elseif ($user->gender === 'female') {
            $dailyRecord->female_count -= 1;
            $dailyRecord->female_avg_count = $dailyRecord->female_count > 0
                ? $user->where('gender', 'female')->avg('age')
                : null;
        }

        $dailyRecord->save();
    }
}

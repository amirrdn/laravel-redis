<?php

namespace App\Jobs;

use App\Models\DailyRecord;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EndOfDayProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date = now()->toDateString();
        $maleCount = Redis::get('users:count:male');
        $femaleCount = Redis::get('users:count:female');

        $dailyRecord = DailyRecord::updateOrCreate(
            ['date' => $date],
            ['male_count' => $maleCount, 'female_count' => $femaleCount]
        );

        // Reset Redis counts for the next day
        Redis::set('users:count:male', 0);
        Redis::set('users:count:female', 0);
    }
}

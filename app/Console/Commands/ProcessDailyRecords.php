<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DailyRecord;
use Illuminate\Support\Facades\Redis;
use App\Models\User;

class ProcessDailyRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:daily:records';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process daily records, calculate male/female counts and averages';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $maleCount = (int) Redis::get('users:count:male') ?? 0;
        $femaleCount = (int) Redis::get('users:count:female') ?? 0;
        
        $dailyRecord = DailyRecord::updateOrCreate(
            ['date' => now()->toDateString()],
            ['male_count' => $maleCount, 'female_count' => $femaleCount]
        );

        $dailyRecord->save();
    }
}

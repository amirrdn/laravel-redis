<?php
namespace App\Observers;

use App\Models\User;
use App\Models\DailyRecord;

class UserObserver
{
    public function deleted(User $user)
    {
        $dailyRecord = DailyRecord::firstOrCreate(['date' => now()->toDateString()]);

        if ($user->gender === 'male') {
            $dailyRecord->male_count--;
        } else {
            $dailyRecord->female_count--;
        }

        $dailyRecord->save();
        $this->updateAverageAges($dailyRecord);
    }

    protected function updateAverageAges(DailyRecord $dailyRecord)
    {
        $maleAvgAge = User::where('gender', 'male')->avg('age');
        $femaleAvgAge = User::where('gender', 'female')->avg('age');

        $dailyRecord->update([
            'male_avg_age' => $maleAvgAge ?: 0,
            'female_avg_age' => $femaleAvgAge ?: 0,
        ]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\DailyRecord;

class UserDeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::factory()->create(['gender' => 'male', 'age' => 30]);
        
        $dailyRecord = DailyRecord::create([
            'date' => now()->toDateString(),
            'male_count' => 1,
            'female_count' => 0,
            'male_avg_count' => 30,
            'female_avg_count' => 0,
            'male_avg_age' => 30,
            'female_avg_age' => 0,
        ]);

        $user->delete();

        $dailyRecord->refresh();

        $this->assertEquals(0, $dailyRecord->male_count);
        $this->assertEquals(0, $dailyRecord->male_avg_count);
        $this->assertNull($dailyRecord->male_avg_age);

        $this->assertEquals(0, $dailyRecord->female_count);
        $this->assertEquals(0, $dailyRecord->female_avg_count);
        $this->assertEquals(0, $dailyRecord->female_avg_age);
    }
}

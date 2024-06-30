<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use App\Models\User;
use App\Models\DailyRecord;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Jobs\FetchUsersJob;
use App\Services\ApiService;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    /** @test */
    public function it_fetches_and_stores_20_new_users()
    {
        $initialCount = User::count();

        FetchUsersJob::dispatchNow();

        $this->assertEquals($initialCount + 20, User::count());
    }
}

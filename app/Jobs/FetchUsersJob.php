<?php
namespace App\Jobs;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $response = Http::get('https://randomuser.me/api/?results=20');
        $users = $response->json()['results'];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['uuid' => $userData['login']['uuid']],
                [
                    'first_name' => $userData['name']['first'],
                    'last_name' => $userData['name']['last'],
                    'email' => $userData['email'],
                    'phone' => $userData['phone'] ?? null,
                    'gender' => $userData['gender'],
                    'password' => $userData['login']['md5'],
                    'age' => $userData['dob']['age']
                ]
            );

            $this->updateRedisCount($userData['gender']);
        }
    }

    protected function updateRedisCount($gender)
    {
        if ($gender === 'male') {
            Redis::incr('users:count:male');
        } else {
            Redis::incr('users:count:female');
        }
    }
}
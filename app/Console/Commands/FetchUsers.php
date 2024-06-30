<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use App\Models\User;

class FetchUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch users from randomuser.me and store them in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('https://randomuser.me/api/?results=20');

        if ($response->successful()) {
            $users = $response->json()['results'];
            $maleCount = 0;
            $femaleCount = 0;
            foreach ($users as $userData) {
                // print(json_encode($userData['gender']));
                $user = User::updateOrCreate(
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

                if ($userData['gender'] === 'male') {
                    $maleCount++;
                } elseif ($userData['gender'] === 'female') {
                    $femaleCount++;
                }
            }
            Redis::set('users:count:male', $maleCount);
            Redis::set('users:count:female', $femaleCount);

            $this->info('Hourly user fetch and store completed');
        } else {
            $this->error('Failed to fetch users.');
        }
    }
}

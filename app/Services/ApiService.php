<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    protected $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function fetchUsers($results = 10)
    {
        $response = Http::get($this->baseUrl . '/api/?results=20', [
            'results' => $results,
        ]);

        return $response->json();
    }
}
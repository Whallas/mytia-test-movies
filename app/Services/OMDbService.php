<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OMDbService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.omdb.api_key');
    }

    /**
     * @throws \Exception
     */
    public function searchMovies($query, $page = 1): array
    {
        return Http::asJson()->get('http://www.omdbapi.com/', [
            'apikey' => $this->apiKey,
            's' => $query,
            'page' => $page,
        ])->throw()->json();
    }
}

<?php
namespace App\Jobs;

use App\Models\Movie;
use App\Services\OMDbService;
use Faker\Factory as Faker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SyncOMDbData implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $timeout = 0;

    protected $maxRequests = 1000;

    public function handle()
    {
        $omdbService = app(OMDbService::class);
        $requestsMade = Cache::get('omdb:requests_made', 0);

        Log::info('SyncOMDbData job started.');

        $searchTerms = $this->generateSearchTerms();
        Log::info('Generated search terms.', ['terms' => $searchTerms]);

        foreach ($searchTerms as $term) {
            for ($page = 1; $page <= 100; $page++) {
                if ($requestsMade >= $this->maxRequests) {
                    Log::info('Max requests reached. Stopping job.', ['requestsMade' => $requestsMade]);
                    return;
                }

                try {
                    $response = $omdbService->searchMovies($term, $page);
                } catch (\Exception $e) {
                    Log::error('Error fetching data from OMDb API.', [
                        'term' => $term,
                        'page' => $page,
                        'error' => $e->getMessage(),
                    ]);
                    break;
                }

                if (!($response['Response'] ?? false) || empty($response['Search'])) {
                    Log::warning('No results or invalid response.', ['term' => $term, 'page' => $page]);
                    break;
                }

                foreach ($response['Search'] as $movie) {
                    if (empty($movie['imdbID'])) {
                        Log::warning('Movie skipped due to missing imdbID.', ['movie' => $movie]);
                        continue;
                    }

                    Movie::updateOrCreate(
                        ['omdb_id' => $movie['imdbID']],
                        [
                            'title' => $movie['Title'] ?? '',
                            'year' => $movie['Year'] ?? '',
                            'type' => $movie['Type'] ?? '',
                            'poster' => $movie['Poster'] ?? null,
                        ]
                    );

                    Log::info('Movie synced.', ['imdbID' => $movie['imdbID'], 'title' => $movie['Title']]);
                }

                $requestsMade++;
                Cache::increment('omdb:requests_made');
                Log::info('Request completed.', ['term' => $term, 'page' => $page, 'requestsMade' => $requestsMade]);
            }
        }

        Log::info('SyncOMDbData job completed.');
    }

    private function generateSearchTerms(): array
    {
        $faker = Faker::create();
        $terms = [];

        while (count($terms) < 100) {
            $word = $faker->word();
            if (strlen($word) >= 3 && !in_array($word, $terms)) {
                $terms[] = $word;
            }
        }

        return $terms;
    }
}

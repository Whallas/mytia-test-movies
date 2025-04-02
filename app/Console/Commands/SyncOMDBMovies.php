<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SyncOMDbData;
use Illuminate\Support\Facades\Cache;

class SyncOMDBMovies extends Command
{
    protected $signature = 'movies:sync-omdb';
    protected $description = 'Synchronize popular movies from the OMDb API';

    public function handle()
    {
        Cache::forget('omdb:requests_made');
        dispatch(new SyncOMDbData());
        $this->info('OMDb movies synchronization job dispatched.');
    }
}

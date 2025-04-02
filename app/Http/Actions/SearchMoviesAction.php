<?php

namespace App\Http\Actions;

use App\Models\Movie;

class SearchMoviesAction
{
    public function execute(string $query, int $page = 1)
    {
        return Movie::where('title', 'like', '%' . $query . '%')
            ->paginate(10, ['*'], 'page', $page);
    }
}

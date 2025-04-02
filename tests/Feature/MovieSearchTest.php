<?php
namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_movie_search_requires_query_parameter()
    {
        $this->authenticate();

        $response = $this->getJson('/api/movies');
        $response->assertStatus(422)->assertJsonValidationErrors(['query']);
    }

    public function test_movie_search_returns_results()
    {
        $this->authenticate();
        $model = Movie::factory()->create(['title' => 'Batman Begins']);

        $response = $this->getJson('/api/movies?query=batman');
        $response->assertStatus(200)->assertJson([
            'data' => [
                [
                    "id" => $model->id,
                    'title' => $model->title,
                    'year' => $model->year,
                    'omdb_id' => $model->omdb_id,
                    'type' => $model->type,
                    'poster' => $model->poster,
                    "created_at" => $model->created_at->toISOString(),
                    "updated_at" => $model->updated_at->toISOString(),
                ],
            ],
        ]);
    }

    public function test_movie_search_returns_no_results_for_invalid_query()
    {
        $this->authenticate();
        Movie::factory()->create(['title' => 'Batman Begins']);

        $response = $this->getJson('/api/movies?query=invalidquery');
        $response->assertStatus(200)->assertJson([
            'data' => [],
        ]);
    }
}

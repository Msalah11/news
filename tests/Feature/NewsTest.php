<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class NewsTest extends TestCase
{
    public function testNewsListedSuccessfully()
    {
        $user = User::factory()->has(News::factory()->count(10))->create();

        $this->actingAs($user)->get('api/news')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure($this->newsListJsonStructure());
    }

    public function testFilterNewsByUserIdSuccessfully()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('api/news?user_id=1')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure($this->newsListJsonStructure());
    }

    private function newsListJsonStructure(): array
    {
        return [
            'response' => [
                [
                    'id',
                    'user_id',
                    'title',
                    'short_content',
                    'content',
                    'created_at',
                    'user' => [
                        'id',
                        'email',
                        'verified',
                        'created_at'
                    ]
                ]
            ]
        ];
    }
}

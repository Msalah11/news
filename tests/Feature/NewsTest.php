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

    public function testNewsCreatedSuccessfully()
    {
        $newsData = [
            'title' => 'Solana (SOL) Phantom Wallet Hits One Million Active Users, SOL Also Reaches New All-Time High',
            'content' => 'Phantom announced earlier this week that the wallet had finally broken over one million active users. An impressive feat for a wallet that has only been around for a couple of months.'
        ];

        $user = User::factory()->create();

        $this->actingAs($user)->post('api/news', $newsData)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure($this->newsCreateJsonStructure());
    }

    public function testNewsCreatedFailed()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('api/news', [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => ['title', 'content']
            ]);
    }

    private function newsCreateJsonStructure(): array
    {
        return [
            'response' => [
                'id',
                'user_id',
                'title',
                'short_content',
                'content',
                'created_at',
            ]
        ];
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

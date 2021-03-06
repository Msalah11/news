<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)
            ->has(News::factory()->count(10))
            ->create()->each(function ($user) {
                $user->createToken('SduiToken')->plainTextToken;
            });
    }
}

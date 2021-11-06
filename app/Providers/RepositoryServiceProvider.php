<?php

namespace App\Providers;

use App\Models\News;
use App\Repositories\Eloquent\EloquentNewsRepository;
use App\Repositories\Interfaces\NewsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(NewsRepository::class, function () {
            return new EloquentNewsRepository( new News() );
        });
    }
}

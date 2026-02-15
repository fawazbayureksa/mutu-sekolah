<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\SchoolRepositoryInterface::class,
            \App\Repositories\Eloquent\SchoolRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\AssessmentRepositoryInterface::class,
            \App\Repositories\Eloquent\AssessmentRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\AssessmentAnswerRepositoryInterface::class,
            \App\Repositories\Eloquent\AssessmentAnswerRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ProvinceRepository::class,
            fn () => new \App\Repositories\ProvinceRepository
        );

        $this->app->singleton(
            \App\Repositories\RegencyRepository::class,
            fn () => new \App\Repositories\RegencyRepository
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

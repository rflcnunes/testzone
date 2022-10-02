<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\LogRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\OfferRepository;
use App\Http\Repositories\AuctionRepository;
use App\Http\Repositories\Interfaces\LogRepositoryInterface;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Repositories\Interfaces\OfferRepositoryInterface;
use App\Http\Repositories\Interfaces\AuctionRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AuctionRepositoryInterface::class,
            AuctionRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            OfferRepositoryInterface::class,
            OfferRepository::class
        );

        $this->app->bind(
            LogRepositoryInterface::class,
            LogRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

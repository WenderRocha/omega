<?php

namespace App\Providers;


use App\Repositories\App\Wallet\WalletRepository;
use App\Repositories\App\Wallet\WalletRepositoryInterface;
use App\Services\App\Wallet\WalletService;
use App\Services\App\Wallet\WalletServiceInterface;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WalletRepositoryInterface::class, WalletRepository::class);
        $this->app->bind(WalletServiceInterface::class, WalletService::class);
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

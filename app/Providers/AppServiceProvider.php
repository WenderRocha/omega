<?php

namespace App\Providers;


use App\Models\Management;
use App\Repositories\App\Management\ManagementRepository;
use App\Repositories\App\Management\ManagementRepositoryInterface;
use App\Repositories\App\Trade\TradeRepository;
use App\Repositories\App\Trade\TradeRepositoryInterface;
use App\Repositories\App\Wallet\WalletRepository;
use App\Repositories\App\Wallet\WalletRepositoryInterface;
use App\Services\App\Trade\TradeService;
use App\Services\App\Trade\TradeServiceInterface;
use App\Services\App\Wallet\WalletService;
use App\Services\App\Wallet\WalletServiceInterface;
use App\Services\App\Management\ManagementService;
use App\Services\App\Management\ManagementServiceInterface;
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

        $this->app->bind(ManagementRepositoryInterface::class, ManagementRepository::class);
        $this->app->bind(ManagementServiceInterface::class, ManagementService::class);

       $this->app->bind(TradeRepositoryInterface::class, TradeRepository::class);
       $this->app->bind(TradeServiceInterface::class, TradeService::class);
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

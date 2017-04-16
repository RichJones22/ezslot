<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Repositories\BaseRepositoryContract;
use App\Contracts\Repositories\SymbolsRContract;
use App\Contracts\Services\SymbolsSContract;
use App\Repositories\BaseRepository;
use App\Repositories\SymbolsR;
use App\Services\SymbolsS;
use Illuminate\Support\ServiceProvider;

class ezSlotServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(SymbolsSContract::class, SymbolsS::class);
        $this->app->bind(BaseRepositoryContract::class, BaseRepository::class);
        $this->app->bind(SymbolsRContract::class, SymbolsR::class);
    }
}

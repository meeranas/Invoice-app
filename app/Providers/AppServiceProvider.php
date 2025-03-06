<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Interface\InvoiceServiceInterface;
use App\Services\InvoiceService;
use App\Repositories\Interface\InvoiceRepositoryInterface;
use App\Repositories\InvoiceRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the interface to its repository implementation
        $this->app->bind(InvoiceServiceInterface::class, InvoiceService::class);

        // Bind the interface to its service implementation
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

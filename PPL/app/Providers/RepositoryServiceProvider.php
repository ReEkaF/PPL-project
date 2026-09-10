<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     */
    public array $bindings = [
        \App\Repositories\Contracts\Portal\BerandaRepositoryInterface::class => \App\Repositories\Eloquent\Portal\BerandaRepository::class,
        \App\Repositories\Contracts\Perpustakaan\BukuRepositoryInterface::class => \App\Repositories\Eloquent\Perpustakaan\BukuRepository::class,
        \App\Repositories\Contracts\Perpustakaan\KategoriBukuRepositoryInterface::class => \App\Repositories\Eloquent\Perpustakaan\KategoriBukuRepository::class,
        \App\Repositories\Contracts\Perpustakaan\TransaksiPeminjamanRepositoryInterface::class => \App\Repositories\Eloquent\Perpustakaan\TransaksiPeminjamanRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

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
        \App\Repositories\Contracts\Lms\MateriRepositoryInterface::class => \App\Repositories\Eloquent\Lms\MateriRepository::class,
        \App\Repositories\Contracts\Lms\TugasRepositoryInterface::class => \App\Repositories\Eloquent\Lms\TugasRepository::class,
        \App\Repositories\Contracts\Lms\PengumpulanTugasRepositoryInterface::class => \App\Repositories\Eloquent\Lms\PengumpulanTugasRepository::class,
        \App\Repositories\Contracts\Lms\TopikRepositoryInterface::class => \App\Repositories\Eloquent\Lms\TopikRepository::class,
        \App\Repositories\Contracts\Akademik\KelasRepositoryInterface::class => \App\Repositories\Eloquent\Akademik\KelasRepository::class,
        \App\Repositories\Contracts\Akademik\MataPelajaranRepositoryInterface::class => \App\Repositories\Eloquent\Akademik\MataPelajaranRepository::class,
        \App\Repositories\Contracts\Akademik\JadwalRepositoryInterface::class => \App\Repositories\Eloquent\Akademik\JadwalRepository::class,
        \App\Repositories\Contracts\Akademik\RaporRepositoryInterface::class => \App\Repositories\Eloquent\Akademik\RaporRepository::class,
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

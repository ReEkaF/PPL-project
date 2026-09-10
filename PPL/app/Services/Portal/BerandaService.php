<?php

namespace App\Services\Portal;

use App\Repositories\Contracts\Portal\BerandaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class BerandaService
{
    protected BerandaRepositoryInterface $berandaRepository;

    public function __construct(BerandaRepositoryInterface $berandaRepository)
    {
        $this->berandaRepository = $berandaRepository;
    }

    public function getHomePageData(): array
    {
        $statistics = Cache::remember('portal.statistics', 1800, function () {
            return $this->berandaRepository->getSchoolStatistics();
        });

        $latestBooks = Cache::remember('portal.home_latest_books', 1800, function () {
            return $this->berandaRepository->getLatestBooks(4);
        });

        return [
            'statistics' => $statistics,
            'latestBooks' => $latestBooks,
        ];
    }

    public function getPublicLibraryBooks(): Collection
    {
        return Cache::remember('portal.public_library_books', 1800, function () {
            return $this->berandaRepository->getLatestBooks(12);
        });
    }

    public function getPublicTeachers(): Collection
    {
        return Cache::remember('portal.public_teachers', 3600, function () {
            return $this->berandaRepository->getAllTeachersWithSubjects();
        });
    }

    public function getPublicAchievements(): Collection
    {
        return Cache::remember('portal.public_achievements', 1800, function () {
            return $this->berandaRepository->getAllExtracurricularAchievements();
        });
    }
}

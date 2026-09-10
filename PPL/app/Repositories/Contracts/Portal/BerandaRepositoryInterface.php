<?php

namespace App\Repositories\Contracts\Portal;

use Illuminate\Database\Eloquent\Collection;

interface BerandaRepositoryInterface
{
    public function getLatestBooks(int $limit = 4): Collection;

    public function getAllTeachersWithSubjects(): Collection;

    public function getAllExtracurricularAchievements(): Collection;

    public function getSchoolStatistics(): array;
}

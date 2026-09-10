<?php

namespace App\Repositories\Contracts\Ujian;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UjianRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get paginated exam list.
     */
    public function getPaginatedUjian(int $perPage = 10): LengthAwarePaginator;

    /**
     * Find exam with attached questions.
     */
    public function findWithQuestions(string $id): ?Model;

    /**
     * Get questions for an exam.
     */
    public function getQuestions(string $ujianId): Collection;

    /**
     * Create exam question.
     */
    public function createQuestion(array $data): Model;

    /**
     * Update exam question.
     */
    public function updateQuestion(string $id, array $data): bool;

    /**
     * Delete exam question.
     */
    public function deleteQuestion(string $id): bool;

    /**
     * Get exam submissions with student and exam info.
     */
    public function getSubmissions(): Collection;

    /**
     * Delete an exam submission along with student answers.
     */
    public function deleteSubmission(string $id): bool;
}

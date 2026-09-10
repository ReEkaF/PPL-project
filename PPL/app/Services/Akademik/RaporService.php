<?php

namespace App\Services\Akademik;

use App\Models\kelas;
use App\Repositories\Contracts\Akademik\RaporRepositoryInterface;

class RaporService
{
    public function __construct(
        protected RaporRepositoryInterface $raporRepo
    ) {}

    public function getRaporIndexData(
        ?string $search = null,
        ?string $kelasId = null,
        string $sort = 'nama_siswa',
        string $order = 'asc',
        ?string $selectedSiswaId = null
    ): array {
        $kelasList = kelas::all();
        $siswaList = $this->raporRepo->getPaginatedSiswaRapor($search, $kelasId, $sort, $order, 16);

        $detailSiswa = null;
        if ($selectedSiswaId) {
            $detailSiswa = $this->raporRepo->getSiswaRaporDetail($selectedSiswaId);
        }

        return [
            'siswaList' => $siswaList,
            'kelasList' => $kelasList,
            'detailSiswa' => $detailSiswa,
        ];
    }

    public function getSiswaDetail(string $siswaId): array
    {
        return $this->raporRepo->getSiswaRaporDetail($siswaId);
    }
}

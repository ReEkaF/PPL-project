<?php

namespace App\Http\Controllers\pembinaekstra;

use App\Http\Controllers\Controller;
use App\Services\Ekstrakurikuler\EkstrakurikulerService;
use Illuminate\View\View;

class PembinaAnggotaController extends Controller
{
    public function __construct(
        protected EkstrakurikulerService $ekstraService
    ) {}

    public function index(): View
    {
        $guruId = auth()->guard('web-guru')->user()->id_guru;
        $data = $this->ekstraService->getPembinaAnggotaData($guruId);

        return view('pembina_ekstra.anggota.index', $data);
    }
}

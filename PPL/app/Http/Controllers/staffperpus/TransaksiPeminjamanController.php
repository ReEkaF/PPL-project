<?php

namespace App\Http\Controllers\staffperpus;

use App\Http\Controllers\Controller;
use App\Http\Requests\Perpustakaan\StoreTransaksiRequest;
use App\Models\Guru;
use App\Models\Siswa;
use App\Repositories\Contracts\Perpustakaan\BukuRepositoryInterface;
use App\Repositories\Contracts\Perpustakaan\TransaksiPeminjamanRepositoryInterface;
use App\Services\Perpustakaan\TransaksiPeminjamanService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransaksiPeminjamanController extends Controller
{
    protected TransaksiPeminjamanService $transaksiService;

    protected TransaksiPeminjamanRepositoryInterface $transaksiRepo;

    protected BukuRepositoryInterface $bukuRepo;

    public function __construct(
        TransaksiPeminjamanService $transaksiService,
        TransaksiPeminjamanRepositoryInterface $transaksiRepo,
        BukuRepositoryInterface $bukuRepo
    ) {
        $this->transaksiService = $transaksiService;
        $this->transaksiRepo = $transaksiRepo;
        $this->bukuRepo = $bukuRepo;
    }

    public function index(Request $request): View
    {
        $transactions = $this->transaksiRepo->paginateTransactions($request->input('query'), 10);
        $transactions->withQueryString();

        return view('staff_perpus.transaksi.daftartransaksi', compact('transactions'));
    }

    public function create(): View
    {
        $siswa = Siswa::orderBy('nama_siswa', 'asc')->get();
        $guru = Guru::orderBy('nama_guru', 'asc')->get();
        $buku = $this->bukuRepo->getRecentBooks(50);

        return view('staff_perpus.transaksi.create', compact('siswa', 'guru', 'buku'));
    }

    public function store(StoreTransaksiRequest $request): RedirectResponse
    {
        $result = $this->transaksiService->createLoan($request->validated());

        if (! $result['success']) {
            return redirect()->back()->withErrors(['message' => $result['message']])->withInput();
        }

        return redirect()->route('staff_perpus.transaksi.daftartransaksi')->with('success', $result['message']);
    }

    public function edit(string $id): View
    {
        $transaksi = $this->transaksiRepo->findOrFail($id);
        $transaksi->tgl_awal_peminjaman = Carbon::parse($transaksi->tgl_awal_peminjaman);
        $transaksi->tgl_pengembalian = Carbon::parse($transaksi->tgl_pengembalian);

        return view('staff_perpus.transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'tgl_pengembalian' => 'required|date',
        ]);

        $this->transaksiRepo->update($id, [
            'tgl_pengembalian' => $request->input('tgl_pengembalian'),
        ]);

        return redirect()->route('staff_perpus.transaksi.daftartransaksi')->with('success', 'Tenggat pengembalian berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->transaksiRepo->delete($id);

        return redirect()->route('staff_perpus.transaksi.daftartransaksi')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function updateStatus(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'status_pengembalian' => 'required|in:0,1,2',
        ]);

        $statusDenda = $request->has('status_denda') ? (int) $request->input('status_denda') : null;

        $result = $this->transaksiService->processReturnStatus(
            $id,
            (int) $request->input('status_pengembalian'),
            $statusDenda
        );

        if (! $result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->back()->with('success', $result['message']);
    }

    public function update_status_denda(Request $request): RedirectResponse
    {
        $this->transaksiService->payFine($request->input('status_denda_id_transaksi'));

        return redirect()->back()->with('success', 'Status Denda Telah Dibayar!');
    }
}

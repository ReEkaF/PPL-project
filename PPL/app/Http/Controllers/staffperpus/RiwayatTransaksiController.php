<?php


namespace App\Http\Controllers\staffperpus;

use Carbon\Carbon;
use App\Models\Buku;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\transaksi_peminjaman;
class RiwayatTransaksiController extends Controller
{
    protected $staff_account;

    public function __construct()
    {
        $this->staff_account = DB::table('staffperpus')
            ->where('username', '=', session('username'))
            ->first();

        view()->composer('*', function ($view) {
            $view->with('staff_account',  $this->staff_account);
        });
    }
    public function index(Request $request)
{
    $query = $request->input('query');
    
    // Mengambil transaksi dengan status_pengembalian != 0 dan status denda != 0
    $transactions = transaksi_peminjaman::where('stok', '=', '0')
        // ->where('status_denda', '!=', '0') // Filter untuk status denda != 0
        ->when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('kode_peminjam', 'like', '%' . $query . '%');
        })
        ->orderBy('tgl_awal_peminjaman', 'desc') // Urutkan dari yang terbaru
        ->paginate(10) // Tambahkan pagination
        ->withQueryString(); // Pertahankan query string pada pagination

    // Mengembalikan data ke view
    return view('staff_perpus.riwayat_transaksi.riwayattransaksi', compact('transactions'));
}

}

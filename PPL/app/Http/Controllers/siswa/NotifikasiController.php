<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\notifikasi_sistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $siswaId = Auth::guard('web-siswa')->id();

        // Calculate counts for tab badges and synchronization
        $baseQuery = notifikasi_sistem::where('siswa_id', $siswaId)->whereHas('materi');

        $totalCount = (clone $baseQuery)->count();
        $unreadCount = (clone $baseQuery)->where('status', 0)->count();
        $readCount = $totalCount - $unreadCount;

        // Synchronize sidebar session badge count
        session()->put('notifikasi_count', $unreadCount);

        // Build filtered notification query
        $query = notifikasi_sistem::with([
            'materi.kelasMataPelajaran.mataPelajaran',
            'materi.kelasMataPelajaran.guru',
            'materi.kelasMataPelajaran.kelas',
            'materi.topik',
        ])
            ->where('siswa_id', $siswaId)
            ->whereHas('materi');

        $filter = $request->query('filter', 'all');
        if ($filter === 'unread') {
            $query->where('status', 0);
        } elseif ($filter === 'read') {
            $query->where('status', 1);
        }

        if ($search = trim($request->query('search', ''))) {
            $query->whereHas('materi', function ($q) use ($search) {
                $q->where('judul_materi', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('kelasMataPelajaran.mataPelajaran', function ($mq) use ($search) {
                        $mq->where('nama_matpel', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kelasMataPelajaran.guru', function ($gq) use ($search) {
                        $gq->where('nama_guru', 'like', "%{$search}%");
                    });
            });
        }

        // Unread items first, then newest
        $notifikasi = $query->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('siswa.notifikasi', compact(
            'notifikasi',
            'totalCount',
            'unreadCount',
            'readCount',
            'filter'
        ));
    }

    public function markAllAsRead()
    {
        $siswaId = Auth::guard('web-siswa')->id();

        notifikasi_sistem::where('siswa_id', $siswaId)
            ->where('status', 0)
            ->update([
                'status' => 1,
                'tanggal_dilihat' => now(),
            ]);

        session()->put('notifikasi_count', 0);

        return redirect()->route('siswa.notifikasi');
    }

    public function markAsRead(string $id)
    {
        $siswaId = Auth::guard('web-siswa')->id();

        $notif = notifikasi_sistem::where('id_notifikasi_sistem', $id)
            ->where('siswa_id', $siswaId)
            ->firstOrFail();

        $notif->update([
            'status' => 1,
            'tanggal_dilihat' => now(),
        ]);

        $unreadCount = notifikasi_sistem::where('siswa_id', $siswaId)->where('status', 0)->count();
        session()->put('notifikasi_count', $unreadCount);

        return redirect()->back();
    }


    public function readAndRedirect(string $id)
    {
        $siswaId = Auth::guard('web-siswa')->id();

        $notif = notifikasi_sistem::where('id_notifikasi_sistem', $id)
            ->where('siswa_id', $siswaId)
            ->first();

        if ($notif) {
            if ($notif->status == 0) {
                $notif->update([
                    'status' => 1,
                    'tanggal_dilihat' => now(),
                ]);

                $unreadCount = notifikasi_sistem::where('siswa_id', $siswaId)->where('status', 0)->count();
                session()->put('notifikasi_count', $unreadCount);
            }

            return redirect()->route('siswa.dashboard.lms.detail.materi', ['id' => $notif->materi_id]);
        }

        return redirect()->route('siswa.notifikasi')
            ->with('error', 'Notifikasi materi tidak ditemukan.');
    }
}

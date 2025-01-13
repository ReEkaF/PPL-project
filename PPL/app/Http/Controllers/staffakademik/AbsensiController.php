<?php
// app/Http/Controllers/staffakademik/AbsensiController.php

namespace App\Http\Controllers\staffakademik;

use App\Models\hari;
use App\Models\kelas;
use App\Models\Siswa;
use App\Models\pertemuan;
use App\Models\kelas_mata_pelajaran;
use App\Models\absensi_siswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $allKelas = kelas::orderByRaw('LENGTH(nama_kelas)')
            ->orderBy('nama_kelas')
            ->get();

        $query = kelas_mata_pelajaran::with('kelas', 'mataPelajaran', 'guru', 'hari')
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->orderByRaw('LENGTH(kelas.nama_kelas)')
            ->orderBy('kelas.nama_kelas')
            ->orderBy('hari_id')
            ->orderBy('waktu_mulai');

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        $data = $query->get();

        return view("staff_akademik.absensi.index", compact('data', 'allKelas'));
    }

    public function details($id)
    {
        $detail = kelas_mata_pelajaran::with('kelas', 'mataPelajaran', 'guru', 'hari', 'pertemuan')
            ->where('id_kelas_mata_pelajaran', $id)
            ->firstOrFail();

        return view('staff_akademik.absensi.pertemuan', compact('detail'));
    }

    public function pertemuanDetails($id, $pertemuan)
    {
        $detail = kelas_mata_pelajaran::with('kelas', 'mataPelajaran', 'guru', 'hari')
            ->where('id_kelas_mata_pelajaran', $id)
            ->firstOrFail();

        // $students = absensi_siswa::where('pertemuan_id', $pertemuan)
        //     ->with(['siswa' => function ($query) {
        //         $query->orderBy('nisn');
        //     }])
        //     ->get();

        $students = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.siswa_id', '=', 'siswa.id_siswa')
            ->where('absensi_siswa.pertemuan_id', $pertemuan)
            ->orderBy('siswa.nisn')
            ->select('absensi_siswa.*', 'siswa.nisn', 'siswa.nama_siswa')
            ->get();

        $pertemuan = pertemuan::find($pertemuan);

        return view('staff_akademik.absensi.pertemuan_details', compact('detail', 'students', 'pertemuan'));
    }

    public function generatePresenceData(Request $request, $id)
    {
        $request->validate([
            'first_week_date' => 'required|date|after_or_equal:' . date('Y-01-01') . '|before_or_equal:' . date('Y-12-31'),
            'total_meetings' => 'required|integer|min:1|max:20',
        ], [
            'first_week_date.required' => 'Tanggal pertemuan harus diisi.',
            'first_week_date.after_or_equal' => 'Tanggal pertemuan harus di tahun sekarang.',
            'first_week_date.before_or_equal' => 'Tanggal pertemuan harus di tahun sekarang.',
            'total_meetings.required' => 'Total pertemuan harus diisi.',
            'total_meetings.min' => 'Total pertemuan tidak boleh kurang dari 1.',
            'total_meetings.max' => 'Total pertemuan tidak boleh lebih dari 20.',
        ]);

        $firstWeekDate = $request->input('first_week_date');
        $totalMeetings = $request->input('total_meetings');

        $kelasMataPelajaran = kelas_mata_pelajaran::find($id);
        $id_kelas = $kelasMataPelajaran->kelas_id;

        $siswaList = Siswa::whereHas('kelassiswa', function ($query) use ($id_kelas) {
            $query->where('id_kelas', $id_kelas);
        })->get();

        for ($i = 0; $i < $totalMeetings; $i++) {
            $meetingDate = date('Y-m-d', strtotime($firstWeekDate . " + $i week"));

            $pertemuan = pertemuan::create([
                'kelas_mata_pelajaran_id' => $id,
                'tanggal_pertemuan' => $meetingDate,
                'qr_code' => '',
            ]);

            $qrCodeUrl = route('siswa.absensi.scan', ['pertemuan_id' => $pertemuan->id_pertemuan]);

            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qrCodeSvg = $writer->writeString($qrCodeUrl);

            if (!Storage::disk('public')->exists('qr_codes')) {
                Storage::disk('public')->makeDirectory('qr_codes');
            }

            $filePath = 'qr_codes/' . $pertemuan->id_pertemuan . '.svg';
            Storage::disk('public')->put($filePath, $qrCodeSvg);

            $pertemuan->qr_code = $filePath;
            $pertemuan->save();

            foreach ($siswaList as $siswa) {
                absensi_siswa::create([
                    'siswa_id' => $siswa->id_siswa,
                    'pertemuan_id' => $pertemuan->id_pertemuan,
                    'status_absensi' => 'Alpa',
                ]);
            }
        }

        return redirect()->route('akademik.absensi.details', $id)->with('success', 'Sukses membuat data absensi');
    }

    public function resetPertemuan($id)
    {
        $pertemuans = Pertemuan::where('kelas_mata_pelajaran_id', $id)->get();

        foreach ($pertemuans as $pertemuan) {
            if ($pertemuan->qr_code && Storage::disk('public')->exists($pertemuan->qr_code)) {
                Storage::disk('public')->delete($pertemuan->qr_code);
            }
        }

        $pertemuanIds = $pertemuans->pluck('id_pertemuan');

        absensi_siswa::whereIn('pertemuan_id', $pertemuanIds)->delete();

        Pertemuan::where('kelas_mata_pelajaran_id', $id)->delete();

        return redirect()->route('akademik.absensi.details', $id)
            ->with('success', 'Sukses mereset absensi pertemuan');
    }

    public function updateStatus(Request $request)
    {
        $statusAbsensi = $request->input('status_absensi');

        foreach ($statusAbsensi as $id => $status) {
            absensi_siswa::where('id_absensi_siswa', $id)->update(['status_absensi' => $status]);
        }

        return back()->with('success', 'Status absensi berhasil diubah');
    }
}

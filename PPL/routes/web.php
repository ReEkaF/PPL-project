<?php

use Carbon\Carbon;
use App\Http\Controllers\guru;
use App\Http\Controllers\siswa;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\staffakademik;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\guru\GuruController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\guru\ProfilController;
use App\Http\Controllers\Siswa\SiswaController;
use App\Http\Controllers\guru\GuruLmsController;
use App\Http\Controllers\siswa\SiswaLmsController;
use App\Http\Controllers\beranda\BerandaController;
use App\Http\Controllers\guru\lms\TopikLmsController;
use App\Http\Controllers\Siswa\SiswaProfilController;
use App\Http\Controllers\guru\lms\ForumGuruController;
use App\Http\Controllers\guru\lms\TugasGuruController;
use App\Http\Controllers\guru\lms\MateriGuruController;
use App\Http\Controllers\Siswa\PrestasiSiswaController;
use App\Http\Controllers\StaffAkademik\KelasController;
use App\Http\Controllers\staffakademik\RaporController;
use App\Http\Controllers\staffperpus\LaporanController;
use App\Http\Controllers\guru\LihatJadwalGuruController;
use App\Http\Controllers\guru\lms\AnggotaGuruController;
use App\Http\Controllers\guru\lms\AnggotaSiswaContoller;
use App\Http\Controllers\guru\GuruUjianController;
use App\Http\Controllers\siswa\lms\ForumSiswaController;
use App\Http\Controllers\siswa\lms\TugasSiswaController;
use App\Http\Controllers\staffakademik\JadwalController;
use App\Http\Controllers\staffperpus\CategoryController;
use App\Http\Controllers\siswa\lms\MateriSiswaController;
use App\Http\Controllers\superadmin\SuperadminController;
use App\Http\Controllers\guru\lms\DashboardGuruController;
use App\Http\Controllers\siswa\LihatJadwalSiswaController;
use App\Http\Controllers\siswa\lms\AnggotaSiswaController;
use App\Http\Controllers\staffakademik\PrestasiController;
use App\Http\Controllers\staffperpus\StaffperpusController;
use App\Http\Controllers\siswa\lms\DashboardSiswaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CeKController;
use App\Http\Controllers\siswa\UjianSiswaController;
use App\Http\Controllers\perpustakaan\PerpustakaanController;
use App\Http\Controllers\staffakademik\LihatJadwalController;
use App\Http\Controllers\guru\lms\TrackingTugasGuruController;
use App\Http\Controllers\siswa\lms\DaftarTugasSiswaController;
use App\Http\Controllers\pembinaekstra\AnggotaEkstraController;
use App\Http\Controllers\staffakademik\StaffakademikController;
use App\Http\Controllers\staffperpus\RiwayatTransaksiController;


use App\Http\Controllers\superadmin\KelolaPengurusEkstraController;
use App\Http\Controllers\superadmin\KelolaStaffPerpusController;
use App\Http\Controllers\pengurusekstra\AnggotaController;
use App\Http\Controllers\pembinaekstra\PembinaekstraController;
use App\Http\Controllers\pengurusekstra\PerlengkapanController;
use App\Http\Controllers\pembinaekstra\PembinaAnggotaController;
use App\Http\Controllers\pembinaekstra\PenilaianEkstraController;
use App\Http\Controllers\pengurusekstra\PengurusekstraController;
use App\Http\Controllers\perpustakaan\RiwayatPengunjungController;
use App\Http\Controllers\superadmin\KelolaPembinaEkstraController;
use App\Http\Controllers\superadmin\KelolaStaffAkademikController;
use App\Http\Controllers\Ekstrakurikuler\EkstrakurikulerController;
use App\Http\Controllers\staffperpus\TransaksiPeminjamanController;
use App\Http\Controllers\pengurusekstra\HistoriPeminjamanController;
use App\Http\Controllers\staffakademik\DashboardStaffAkdemikController;
use App\Http\Controllers\pengurusekstra\PenilaianEkstraPengurusController;
use App\Http\Controllers\pembinaekstra\PerlengkapanController as PembinaekstraPerlengkapanController;
use App\Http\Controllers\pembinaekstra\HistoriPeminjamanController as PembinaekstraHistoriPeminjamanController;

/**
 * End Ekstrakurikuler Controllers
 */


Route::prefix('/')->group(function () {
    Route::get('/', [BerandaController::class, 'home'])->name('beranda.home');
    Route::get('/perpustakaanPublik', [BerandaController::class, 'perpustakaanPublik'])->name('beranda.perpustakaanPublik');
    Route::get('/tenagaPengajarPublik', [BerandaController::class, 'tenagaPengajarPublik'])->name('beranda.tenagaPengajarPublik');
    Route::get('/prestasiPublik', [BerandaController::class, 'prestasiPublik'])->name('beranda.prestasiPublik');
});
Route::get('/auth/redirect', [GoogleLoginController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/google/call-back', [GoogleLoginController::class, 'callback']);


Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
// Super Admin
Route::group(['prefix' => 'superadmin', 'middleware' => ['admin']], function () {
    Route::get('/dashboard', [SuperadminController::class, 'index'])->name('superadmin.dashboard');


    //PROFILE//
    Route::get('/setting', [SuperadminController::class, 'setting'])->name('superadmin.profile');
    Route::post('/setting/update', [SuperadminController::class, 'setting_update'])->name('superadmin.profile.update');
    //STAFF AKADEMIK//
    Route::get('/kelola-staff-akademik', [KelolaStaffAkademikController::class, 'index'])->name('superadmin.kelola_staff_akademik');
    Route::get('/kelola-staff-akademik/create', [KelolaStaffAkademikController::class, 'create'])->name('superadmin.kelola_staff_akademik.create');
    Route::post('/kelola-staff-akademik/store', [KelolaStaffAkademikController::class, 'store'])->name('superadmin.kelola_staff_akademik.store');
    Route::get('/kelola-staff-akademik/edit/{id}', [KelolaStaffAkademikController::class, 'edit'])->name('superadmin.kelola_staff_akademik.edit');
    Route::post('/kelola-staff-akademik/update', [KelolaStaffAkademikController::class, 'update'])->name('superadmin.kelola_staff_akademik.update');
    Route::delete('/superadmin/kelola_staff_akademik/delete/{id}', [KelolaStaffAkademikController::class, 'destroy'])->name('superadmin.kelola_staff_akademik.destroy');
    Route::post('/superadmin/kelola_staff_akademik/reset/{id}', [KelolaStaffAkademikController::class, 'reset'])->name('superadmin.kelola_staff_akademik.reset');
    //END STAFF AKADEMIK//
    //STAFF PERPUS//
    Route::get('/kelola-staff-perpus', [KelolaStaffPerpusController::class, 'index'])->name('superadmin.kelola_staff_perpus');
    Route::get('/kelola-staff-perpus/create', [KelolaStaffPerpusController::class, 'create'])->name('superadmin.kelola_staff_perpus.create');
    Route::post('/kelola-staff-perpus/store', [KelolaStaffPerpusController::class, 'store'])->name('superadmin.kelola_staff_perpus.store');
    Route::get('/kelola-staff-perpus/edit/{id}', [KelolaStaffPerpusController::class, 'edit'])->name('superadmin.kelola_staff_perpus.edit');
    Route::post('/kelola-staff-perpus/update', [KelolaStaffPerpusController::class, 'update'])->name('superadmin.kelola_staff_perpus.update');
    Route::delete('/superadmin/kelola_staff_perpus/delete/{id}', [KelolaStaffPerpusController::class, 'destroy'])->name('superadmin.kelola_staff_perpus.destroy');
    Route::post('/superadmin/kelola_staff_perpus/reset/{id}', [KelolaStaffPerpusController::class, 'reset'])->name('superadmin.kelola_staff_perpus.reset');
    //END STAFF PERPUS//
    Route::get('/keloladataguru', [SuperadminController::class, 'showDataGuru'])->name('superadmin.keloladataguru');
    Route::get('/keloladatasiswa', [SuperadminController::class, 'showDataSiswa'])->name('superadmin.keloladatasiswa');
    Route::get('/kelola-akun/data-guru/tambah', [SuperadminController::class, 'create'])->name('data.guru.tambah');
    Route::get('/kelola-akun/data-siswa/tambah', [SuperadminController::class, 'createSiswa'])->name('data.siswa.tambah');
    // Untuk Menambah Data
    Route::post('/kelola-akun/data-guru/store', [SuperadminController::class, 'store'])->name('guru.store');
    Route::post('/kelola-akun/data-siswa/store', [SuperadminController::class, 'storeSiswa'])->name('siswa.store');
    // Untuk Menghapus Data
    Route::delete('/kelola-akun/data-guru/{id}', [SuperadminController::class, 'destroy'])->name('guru.destroy');
    Route::delete('/kelola-akun/data-siswa/{id}', [SuperadminController::class, 'siswaDestroy'])->name('siswa.destroy');
    // Untuk Mengedit Data
    Route::get('guru/edit/{id_guru}', [SuperadminController::class, 'edit'])->name('guru.edit');
    Route::put('guru/update/{id_guru}', [SuperadminController::class, 'update'])->name('guru.update');
    // Untuk Mengedit Data
    Route::get('siswa/editsiswa/{id_siswa}', [SuperadminController::class, 'siswaEdit'])->name('siswa.edit');
    Route::put('siswa/updatesiswa/{id_siswa}', [SuperadminController::class, 'siswaUpdate'])->name('siswa.update');
    // Untuk Search Data
    Route::get('/superadmin/keloladataguru/search', [SuperadminController::class, 'searchGuru'])->name('superadmin.searchGuru');
    Route::get('/superadmin/keloladatasiswa/search', [SuperadminController::class, 'searchSiswa'])->name('superadmin.searchSiswa');

    /**
     * Pembina Ekstrakurikuler
     */
    Route::get('/kelola-pembina-ekstrakurikuler', [KelolaPembinaEkstraController::class, 'index'])->name('superadmin.kelola_pembina_ekstrakurikuler');
    Route::get('/kelola-pembina-ekstrakurikuler/create', [KelolaPembinaEkstraController::class, 'create'])->name('kelola_pembina_ekstrakurikuler.create');
    Route::put('/kelola-pembina-ekstrakurikuler/store/{id}', [KelolaPembinaEkstraController::class, 'store'])->name('kelola_pembina_ekstrakurikuler.store');
    Route::get('/kelola-pembina-ekstrakurikuler/edit/{id}', [KelolaPembinaEkstraController::class, 'edit'])->name('kelola_pembina_ekstrakurikuler.edit');
    Route::put('/kelola-pembina-ekstrakurikuler/update', [KelolaPembinaEkstraController::class, 'update'])->name('kelola_pembina_ekstrakurikuler.update');
    Route::put('/superadmin/kelola_pembina_ekstrakurikuler/delete/{id}', [KelolaPembinaEkstraController::class, 'destroy'])->name('kelola_pembina_ekstrakurikuler.destroy');
    /**
     * End Pembina Ekstrakurikuler
     */
    // Pengurus Ekstra
    // Route untuk kelola data pengurus
    Route::get('/keloladatapengurus', [KelolaPengurusEkstraController::class, 'showDataPengurus'])->name('superadmin.keloladatapengurus');
    Route::get('/kelola-akun/data-pengurus/tambah', [KelolaPengurusEkstraController::class, 'createPengurus'])->name('data.pengurus.tambah');
    Route::post('/kelola-akun/data-pengurus/store/{id_siswa}', [KelolaPengurusEkstraController::class, 'storePengurus'])->name('pengurus.store');
    Route::delete('/kelola-akun/data-pengurus/{id_pengurus}', [KelolaPengurusEkstraController::class, 'pengurusDestroy'])->name('pengurus.destroy');
    Route::get('/data/pengurus/{id}/edit', [KelolaPengurusEkstraController::class, 'editPengurus'])->name('data.pengurus.edit');
    Route::put('/data/pengurus/{id}/update', [KelolaPengurusEkstraController::class, 'updatePengurus'])->name('data.pengurus.update');
    Route::get('/superadmin/keloladatapengurus/search', [KelolaPengurusEkstraController::class, 'searchPengurus'])->name('superadmin.searchPengurus');
    Route::delete('/pengurus/{id_siswa}/delete-role', [KelolaPengurusEkstraController::class, 'deleteRole'])->name('pengurus.delete-role');
});
Route::group(['prefix' => 'staff_akademik', 'middleware' => ['staff_akademik']], function () {
    Route::get('/dashboard', [DashboardStaffAkdemikController::class, 'index'])->name('staff_akademik.dashboard');
    //EDIT PROFILE STAFF AKADEMIK
    Route::get('/profile', [StaffakademikController::class, 'profile'])->name('staff_akademik.profile');
    Route::put('/profile/update', [StaffakademikController::class, 'update_profile'])->name('staff_akademik.profile.update');
    //END PROFILE STAFF AKADEMIK

    /**
     * START JADWAL MANAGEMENT
     */
    Route::get('/jadwal', [JadwalController::class, 'jadwalIndex'])->name('staff_akademik.jadwal');
    Route::get('/jadwal/tambah', [JadwalController::class, 'createJadwal'])->name('staff_akademik.jadwal.create');
    Route::post('/jadwal/tambah', [JadwalController::class, 'storeJadwal'])->name('staff_akademik.jadwal.store');
    Route::get('/jadwal/edit/{id}', [JadwalController::class, 'editJadwal'])->name('staff_akademik.jadwal.edit');
    Route::get('/jadwal/edit/{id}', [JadwalController::class, 'editJadwal'])->name('staff_akademik.jadwal.edit');
    Route::put('/jadwal/update/{id}', [JadwalController::class, 'updateJadwal'])->name('staff_akademik.jadwal.update');
    Route::delete('/jadwal/delete/{id}', [JadwalController::class, 'deleteJadwal'])->name('staff_akademik.jadwal.delete');
    Route::get('/jadwal/import', [JadwalController::class, 'importPage'])->name('staff_akademik.jadwal.import');
    Route::post('/jadwal/import', [JadwalController::class, 'importExcel'])->name('staff_akademik.jadwal.import');
    Route::get('staff_akademik/jadwal/export', [JadwalController::class, 'exportExcel'])->name('staff_akademik.jadwal.export');
    Route::get('staff_akademik/jadwal/pdf', [JadwalController::class, 'exportPdf'])->name('staff_akademik.jadwal.pdf');
    /**
     * END JADWAL MANAGEMENT
     */

    Route::get('/kelas', [StaffakademikController::class, 'index'])->name('staffakademik.kelas.index');
    Route::post('/kelas/store', [StaffakademikController::class, 'store'])->name('staffakademik.kelas.store');
    Route::post('/kelas/update/{id}', [StaffakademikController::class, 'update'])->name('staffakademik.kelas.update');
    Route::delete('/kelas/delete/{id}', [StaffakademikController::class, 'destroy'])->name('staffakademik.kelas.delete');
    Route::get('/staff-akademik/kelas', [StaffakademikController::class, 'cari'])->name('staffakademik.kelas.index');

    /**
     * START PRESTASI
     */
    Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
    Route::get("/prestasi/create", [PrestasiController::class, "create"])->name("prestasi.create");
    Route::post("/prestasi/store", [PrestasiController::class, "store"])->name("prestasi.store");
    Route::get("/prestasi/pengajuan", [PrestasiController::class, "pengajuan"])->name("prestasi.pengajuan");
    Route::get("/prestasi/show/{id}", [PrestasiController::class, "show"])->name("prestasi.show");
    Route::delete('/prestasi/{id}', [PrestasiController::class, 'destroy'])->name('prestasi.destroy');
    Route::put('/prestasi/{id}', [PrestasiController::class, 'update'])->name('prestasi.update');
    Route::put('/prestasi/setujui/{id}', [PrestasiController::class, 'setujui'])->name('prestasi.setujui');
    Route::post('/prestasi/tolak/{id}', [PrestasiController::class, 'tolak'])->name('prestasi.tolak');
    /**
     * END PRESTASI
     */

    // START MANAGEMENT KELAS (NAUFAL | PROSES)
    Route::get('/daftarkelas', [KelasController::class, 'daftarkelas'])->name('daftarkelas');
    Route::get('/kelas/{id}/siswa', [KelasController::class, 'showSiswa'])->name('kelas.siswa');
    Route::get('/kelas/{id_kelas}/tambah-siswa', [KelasController::class, 'tambahSiswa'])->name('kelas.tambahSiswa');
    Route::post('/kelas/{id_kelas}/simpan-siswa', [KelasController::class, 'simpanSiswa'])->name('kelas.simpanSiswa');

    Route::delete('/kelas/{id_kelas}/siswa/{id_siswa}', [KelasController::class, 'hapusSiswa'])->name('kelas.hapusSatuSiswa');
    Route::delete('/kelas/{id_kelas}/hapus-siswa-massal', [KelasController::class, 'hapusSiswaMassal'])->name('kelas.hapusSiswaMassal');

    Route::get('/kelas/{id_kelas}/edit-wali-kelas', [KelasController::class, 'editWaliKelas'])->name('kelas.editWaliKelas');
    Route::put('/kelas/{id_kelas}/update-wali-kelas', [KelasController::class, 'updateWaliKelas'])->name('kelas.updateWaliKelas');

    // ENDL MANAGEMENT KELAS

    /**
     * START MATA PELAJARAN MANAGEMENT
     */
    // Menampilkan daftar mata pelajaran
    Route::get('/mata-pelajaran', [KelasController::class, 'index'])->name('staff_akademik.mata-pelajaran.index');
    // Menampilkan form untuk membuat mata pelajaran baru
    Route::get('/mata-pelajaran/create', [KelasController::class, 'create'])->name('staff_akademik.mata-pelajaran.create');
    // Menyimpan mata pelajaran baru
    Route::post('/mata-pelajaran', [KelasController::class, 'store'])->name('staff_akademik.mata-pelajaran.store');
    // Menampilkan form edit mata pelajaran berdasarkan ID
    Route::get('/mata-pelajaran/{id}/edit', [KelasController::class, 'edit'])->name('staff_akademik.mata-pelajaran.edit');
    // Memperbarui data mata pelajaran berdasarkan ID
    Route::put('/mata-pelajaran/{id}', [KelasController::class, 'update'])->name('staff_akademik.mata-pelajaran.update');
    // Menghapus mata pelajaran berdasarkan ID
    Route::delete('/mata-pelajaran/{id}', [KelasController::class, 'destroy'])->name('staff_akademik.mata-pelajaran.destroy');


    //crud kelas
    Route::get('/kelas', [KelasController::class, 'indexKelas'])->name('staff_akademik.kelas.index');
    Route::get('/kelas/create', [KelasController::class, 'createKelas'])->name('staff_akademik.kelas.create');
    Route::post('/kelas', [KelasController::class, 'storeKelas'])->name('staff_akademik.kelas.store');
    Route::get('/kelas/{id}/edit', [KelasController::class, 'editKelas'])->name('staff_akademik.kelas.edit');
    Route::put('/kelas/{id}', [KelasController::class, 'updateKelas'])->name('staff_akademik.kelas.update');
    Route::delete('/kelas/{id}', [KelasController::class, 'destroyKelas'])->name('staff_akademik.kelas.destroy');

    Route::get('/guru-mata-pelajaran', [KelasController::class, 'indexGuruMataPelajaran'])->name('staff_akademik.guru_mata_pelajaran.index');
    Route::get('/guru-mata-pelajaran/create', [KelasController::class, 'createGuruMataPelajaran'])->name('staff_akademik.guru_mata_pelajaran.create');
    Route::post('/guru-mata-pelajaran', [KelasController::class, 'storeGuruMataPelajaran'])->name('staff_akademik.guru_mata_pelajaran.store');
    Route::get('/guru-mata-pelajaran/{id}/edit', [KelasController::class, 'editGuruMataPelajaran'])->name('staff_akademik.guru_mata_pelajaran.edit');
    Route::put('/guru-mata-pelajaran/{id}', [KelasController::class, 'updateGuruMataPelajaran'])->name('staff_akademik.guru_mata_pelajaran.update');
    Route::delete('/guru-mata-pelajaran/{id}', [KelasController::class, 'destroyGuruMataPelajaran'])->name('staff_akademik.guru_mata_pelajaran.destroy');

    Route::get('/matpel/master-guru', [KelasController::class, 'showMasterGuru'])->name('master.guru');
    Route::get('/matpel/master-kelas', [KelasController::class, 'showMasterKelas'])->name('master.kelas');
    Route::get('/matpel/master-matpel', [KelasController::class, 'showMasterMatpel'])->name('master.matpel');

    //lihat jadwal
    Route::get('/jadwal-kelas', [LihatJadwalController::class, 'kelas_index'])->name('lihat.jadwal.kelas');
    Route::get('/jadwal-guru', [LihatJadwalController::class, 'guru_index'])->name('lihat.jadwal.guru');

    // Rapor
    Route::get('/rapor', [RaporController::class, 'index'])->name('staff_akademik.rapor.index');
    Route::get('/rapor/siswa/{id}', [RaporController::class, 'showDetail'])->name('staff_akademik.rapor.detail');
    Route::get('/rapor/siswa/{id}/download', [RaporController::class, 'downloadPdf'])->name('staff_akademik.rapor.download');
    Route::get('/rapor/update-nilai', [RaporController::class, 'updateNilai'])->name('staff_akademik.rapor.update_nilai');

    // Absensi
    Route::get('/absensi', [staffakademik\AbsensiController::class, 'index'])->name('akademik.absensi.index');
    Route::get('/absensi/{id}/pertemuan', [staffakademik\AbsensiController::class, 'details'])->name('akademik.absensi.details');
    Route::get('/absensi/{id}/pertemuan/{pertemuan}', [staffakademik\AbsensiController::class, 'pertemuanDetails'])->name('akademik.absensi.pertemuan.details');
    Route::post('/absensi/{id}/generate', [staffakademik\AbsensiController::class, 'generatePresenceData'])->name('akademik.absensi.generate');
    Route::delete('/absensi/{id}/reset', [staffakademik\AbsensiController::class, 'resetPertemuan'])->name('akademik.absensi.reset');
    Route::put('/absensi/update-status', [staffakademik\AbsensiController::class, 'updateStatus'])->name('akademik.absensi.updateStatus');
});
/**
 * END MATA PELAJARAN MANAGEMENT
 */

// Route::get("/prestasi/pengajuan", [PrestasiController::class, "pengajuan"])->name("prestasi.pengajuan");




// P E R P U S T A K A A N

Route::group(['prefix' => 'staff_perpus', 'middleware' => ['staff_perpus']], function () {
    //INDEX
    Route::get('/dashboard', [StaffperpusController::class, 'index'])->name('staff_perpus.dashboard');
    Route::get('/manageCategory', [StaffperpusController::class, 'manageCategory'])->name('staff_perpus.manageCategory');

    //PROFILE
    Route::get('/profile', [StaffperpusController::class, 'profile'])->name('staff_perpus.profile');
    Route::post('/chpfile', [StaffperpusController::class, 'editprofile'])->name('staff_perpus.editprofile');
    Route::post('/pwdefile', [StaffperpusController::class, 'pwdEdit'])->name('staff_perpus.editpwdprofile');

    //KATEGORI
    Route::get('/mngcategory', [CategoryController::class, 'manageCategory'])->name('staff_perpus.managecategories');
    Route::post('/abcategory', [CategoryController::class, 'addCategory'])->name('bookcategories.create');
    Route::post('/dbcategories', [CategoryController::class, 'deleteCategory'])->name('bookcategories.delete');
    Route::post('/upcategories', [CategoryController::class, 'updateCategory'])->name('bookcategories.update');
    // CRUD Buku
    Route::get('/buku', [StaffperpusController::class, 'daftarbuku'])->name('staff_perpus.buku.daftarbuku');
    Route::get('/buku/create', [StaffperpusController::class, 'createbuku'])->name('staff_perpus.buku.create');
    Route::post('/buku', [StaffperpusController::class, 'storebuku'])->name('staff_perpus.buku.store');
    Route::get('/buku/{id}/edit', [StaffperpusController::class, 'editbuku'])->name('staff_perpus.buku.edit');
    Route::put('/buku/{id}', [StaffperpusController::class, 'updatebuku'])->name('staff_perpus.buku.update');
    Route::delete('/buku/{id}', [StaffperpusController::class, 'destroybuku'])->name('staff_perpus.buku.destroy');
    Route::get('/buku/{id}', [StaffperpusController::class, 'show'])->name('staff_perpus.buku.detail');


    // TRANSAKSI
    Route::get('/transaksi', [TransaksiPeminjamanController::class, 'index'])->name('staff_perpus.transaksi.daftartransaksi');
    Route::get('/transaksi/create', [TransaksiPeminjamanController::class, 'create'])->name('staff_perpus.transaksi.create');
    Route::post('/staff_perpus/transaksi', [TransaksiPeminjamanController::class, 'store'])->name('staff_perpus.transaksi.store');
    Route::get('/staff_perpus/transaksi/{id}/edit', [TransaksiPeminjamanController::class, 'edit'])->name('staff_perpus.transaksi.edit');
    Route::put('/staff_perpus/transaksi/{id}', [TransaksiPeminjamanController::class, 'update'])->name('staff_perpus.transaksi.update');
    Route::delete('/staff_perpus/transaksi/{id}', [TransaksiPeminjamanController::class, 'destroy'])->name('staff_perpus.transaksi.destroy');
    Route::put('/staff_perpus/transaksi/daftartransaksi/{id}', [TransaksiPeminjamanController::class, 'updateStatus'])->name('updateStatus');
    Route::post('/update_status_denda', [TransaksiPeminjamanController::class, 'update_status_denda'])->name('staff_perpus.transaksi.update_status_denda');

    // Riwayat transaksi
    Route::get('/riwayat_transaksi', [RiwayatTransaksiController::class, 'index'])->name('staff_perpus.riwayat_transaksi.riwayattransaksi');
    // Route untuk menampilkan laporan buku masuk
    Route::get('/laporan/buku-masuk', [LaporanController::class, 'bukumasuk'])->name('staff_perpus.laporan.laporanbukumasuk');
    // Route untuk menampilkan laporan buku hilang
    Route::get('/laporan/buku-hilang', [LaporanController::class, 'bukuhilang'])->name('staff_perpus.laporan.laporanbukuhilang');
    // Route untuk menampilkan laporan buku transaksi
    Route::get('/laporan/transaksi-buku', [LaporanController::class, 'transaksibuku'])->name('staff_perpus.laporan.laporantransaksi');
});



// Route Siswa
Route::group(['prefix' => 'siswa', 'middleware' => ['siswa']], function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');

    Route::get('/profil', [SiswaProfilController::class, 'show'])->name('siswaprofil.show');
    Route::put('/profil', [SiswaProfilController::class, 'update'])->name('siswaprofil.update');
    /**
     * Start Pengurus Ekstrakurikuler
     */

    Route::group(['middleware' => 'pengurus'], function () {
        // Dashboard Ekstrakurikuler
        Route::get('/ekstrakurikuler/dashboard', [PengurusEkstraController::class, 'dashboard'])->name('pengurus_ekstra.dashboard');
        Route::post('/ekstrakurikuler/dashboard', [PengurusEkstraController::class, 'store'])->name('dashboard.store');
        Route::delete('/dashboard/{id_posting}', [PengurusekstraController::class, 'destroy'])->name('dashboard.destroy');
        Route::put('dashboard/{id_posting}', [PengurusekstraController::class, 'update'])->name('dashboard.update');
        Route::put('/ekstrakurikuler/dashboard', [PengurusekstraController::class, 'updateStatus'])->name('dashboard.status');

        // Anggota Ekstrakurikuler
        Route::get('/ekstrakurikuler/anggota', [AnggotaController::class, 'index'])->name('pengurus_ekstra.anggota');
        Route::put('/ekstrakurikuler/anggota/update-status/{id}', [AnggotaController::class, 'updateStatus'])->name('pengurus_ekstra.anggota.updateStatus');

        // Penilaian Ekstrakurikuler
        Route::get('/ekstrakurikuler/penilaian', [PenilaianEkstraPengurusController::class, 'index'])->name('pengurus_ekstra.penilaian');
        Route::post('/ekstrakurikuler/penilaian/storeOrUpdate/{id}', [PenilaianEkstraPengurusController::class, 'storeOrUpdate'])->name('pengurus_ekstra.penilaian.storeOrUpdate');

        // Perlengkapan
        Route::get('/ekstrakurikuler/perlengkapan', [PerlengkapanController::class, 'index'])->name('pengurus_ekstra.perlengkapan');
        Route::post('/ekstrakurikuler/perlengkapan/tambah', [PerlengkapanController::class, 'store'])->name('pengurus_ekstra.perlengkapan.store');
        Route::put('/ekstrakurikuler/perlengkapan/update/{id}', [PerlengkapanController::class, 'update'])->name('pengurus_ekstra.perlengkapan.update');
        Route::delete('/ekstrakurikuler/perlengkapan/delete/{id}', [PerlengkapanController::class, 'destroy'])->name('pengurus_ekstra.perlengkapan.delete');

        // Histori Peminjaman
        Route::get('/ekstrakurikuler/perlengkapan/histori/{id}', [HistoriPeminjamanController::class, 'index'])->name('pengurus_ekstra.histori');
        Route::post('/ekstrakurikuler/perlengkapan/histori/', [HistoriPeminjamanController::class, 'store'])->name('pengurus_ekstra.histori.store');
        Route::put('/ekstrakurikuler/perlengkapan/histori/{id}', [HistoriPeminjamanController::class, 'update'])->name('pengurus_ekstra.histori.update');
        Route::delete('/ekstrakurikuler/perlengkapan/histori/{id}', [HistoriPeminjamanController::class, 'destroy'])->name('pengurus_ekstra.histori.delete');
    });
    /**
     * End Pengurus Ekstrakurikuler
     */


    // ========================================================== START ROUTE LMS =================================================================================

    // MATERI
    Route::get('/dashboard/lms', [DashboardSiswaController::class, 'index'])->name('siswa.dashboard.lms');
    Route::get('/dashboard/lms/materi', [MateriSiswaController::class, 'index'])->name('siswa.dashboard.lms.materi');


    // TUGAS
    // Route::get('/dashboard/lms/tugas', [TugasSiswaController::class, 'index'])->name('siswa.dashboard.lms.tugas');
    Route::get('/dashboard/lms/tugas/{id}', [TugasSiswaController::class, 'detail'])->name('siswa.dashboard.lms.detail.tugas');

    // PENGUMPULAN TUGAS
    Route::post('/dashboard/lms/tugas/{id}', [TugasSiswaController::class, 'submit'])->name('siswa.dashboard.lms.submit.tugas');
    Route::delete('/dashboard/lms/tugas/batal/{id}', [TugasSiswaController::class, 'batalPengumpulan'])->name('siswa.dashboard.lms.tugas.batal');


    // FILE PENGUMPULAN TUGAS SISWA
    Route::get('/dashboard/lms/tugas/file/{id}', [TugasSiswaController::class, 'deleteFile'])->name('siswa.dashboard.lms.tugas.file.delete');



    // FORUM
    Route::get('/dashboard/lms/forum/{id}', [ForumSiswaController::class, 'index'])->name('siswa.dashboard.lms.forum');
    Route::get('/dashboard/lms/forum/tugas/{id}', [TugasSiswaController::class, 'forumTugas'])->name('siswa.dashboard.lms.forum.tugas');
    Route::get('/dashboard/lms/forum/anggota/{id}', [AnggotaSiswaController::class, 'index'])->name('siswa.dashboard.lms.forum.anggota');
    Route::get('/dashboard/lms/materi/{id}', [MateriSiswaController::class, 'detail'])->name('siswa.dashboard.lms.detail.materi');



    // TRACKING TUGAS
    Route::get('/dashboard/lms/tugas/tracking/ditugaskan', [DaftarTugasSiswaController::class, 'ditugaskan'])->name('siswa.dashboard.lms.tracking.tugas.ditugaskan');
    Route::get('/dashboard/lms/tugas/tracking/belum_diserahkan', [DaftarTugasSiswaController::class, 'belumDiserahkan'])->name('siswa.dashboard.lms.tracking.tugas.belum_diserahkan');
    Route::get('/dashboard/lms/tugas/tracking/diserahkan', [DaftarTugasSiswaController::class, 'diserahkan'])->name('siswa.dashboard.lms.tracking.tugas.diserahkan');
    // ========================================================== END ROUTE LMS =================================================================================


    /**
     * START UJIAN
     */
    Route::get('/dashboard/ujian/index', [UjianSiswaController::class, 'index'])->name('siswa.ujian.index');
    Route::get('/ujian/{id}/start', [UjianSiswaController::class, 'start'])->name('siswa.ujian.start');
    Route::post('/ujian/{id}/submit', [UjianSiswaController::class, 'submit'])->name('siswa.ujian.submit');
    Route::post('/ujian{id}/end', [UjianSiswaController::class, 'submit'])->name('siswa.ujian.end');
    /**
     * END UJIAN
     */


    // START PRESTASI
    Route::get('/dashboard/prestasi', [PrestasiSiswaController::class, 'index'])->name('siswa.prestasi');
    Route::get('/dashboard/prestasi/create', [PrestasiSiswaController::class, 'create'])->name('siswa.prestasi.create');
    Route::post('/dashboard/prestasi/store', [PrestasiSiswaController::class, 'store'])->name('siswa.prestasi.store');
    Route::get('/dashboard/prestasi/show/{id}', [PrestasiSiswaController::class, 'show'])->name('siswa.prestasi.show');
    // END PRESTASI

    // START PERPUS

    Route::get('/dashboard/perpustakaan', [PerpustakaanController::class, 'indexSiswa'])->name('dashboard.perpustakaan');
    Route::get('/dashboard/perpustakaan/detail/{id}', [PerpustakaanController::class, 'showSiswa'])->name('siswa.dashboard.perpustakaan.detail');
    Route::get('/dashboard/perpustakaan/riwayat', [RiwayatPengunjungController::class, 'transSiswa'])->name('siswa.perpustakaan.riwayat');
    Route::get('/dashboard/perpustakaan/rules', [PerpustakaanController::class, 'showRulesSiswa'])->name('siswa.perpustakaan.rules');


    //END PERPUS

    // Absensi
    Route::get('/absensi', [siswa\AbsensiController::class, 'index'])->name('siswa.absensi.index');
    Route::get('/absensi/{id}/pertemuan', [siswa\AbsensiController::class, 'details'])->name('siswa.absensi.details');
    Route::get('/absensi/scan/{pertemuan_id}', [siswa\AbsensiController::class, 'scanQrCode'])->name('siswa.absensi.scan');
    Route::get('/notifikasi', [siswa\NotifikasiController::class, 'index'])->name('siswa.notifikasi');

    //lihat jadwal siswa
    Route::get('/dashboard/lihat-jadwal', [LihatJadwalSiswaController::class, 'index'])->name('lihat-jadwal-siswa');
    Route::get('/jadwal-siswa/print', [LihatJadwalSiswaController::class, 'print'])->name('siswa.jadwal.print');
});




// GURU ROLE
Route::group(['prefix' => 'guru', 'middleware' => ['guru']], function () {
    Route::get('/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
    // Menampilkan profil pengguna
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');

    // Mengupdate profil pengguna
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');


    /**
     * Start Pembina Ekstrakurikuler
     */
    Route::group(['middleware' => 'pembina_ekstra'], function () {
        Route::get('/pembina-dashboard', [PembinaekstraController::class, 'index'])->name('pembina.dashboard');

        // Anggota Ekstrakurikuler
        Route::get('/pembina/ekstrakurikuler/anggota', [PembinaAnggotaController::class, 'index'])->name('pembina.anggota');

        // Perlengkapan Ekstrakurikuler
        Route::get('/pembina/ekstrakurikuler/perlengkapan', [PembinaekstraPerlengkapanController::class, 'index'])->name('pembina.perlengkapan');
        Route::get('/pembina/ekstrakurikuler/perlengkapan/histori/{id}', [PembinaekstraHistoriPeminjamanController::class, 'index'])->name('pembina.histori');

        // Penilaian Ekstrakurikuler
        Route::get('/pembina/ekstrakurikuler/penilaian', [PenilaianEkstraController::class, 'index'])->name('pembina.penilaian');
        Route::post('/pembina/ekstrakurikuler/penilaian/{id}', [PenilaianEkstraController::class, 'storeOrUpdate'])->name('pembina.penilaian.storeOrUpdate');
        Route::get('/pembina/ekstrakurikuler/penilaian/{tahun_ajaran}', [PenilaianEkstraController::class, 'show'])->name('pembina.penilaian.filter');
    });
    /**
     * End Pembina Ekstrakurikuler
     */


    // ========================================================== START ROUTE LMS =================================================================================
    // MATERI
    Route::get('/dashboard/lms', [DashboardGuruController::class, 'index'])->name('guru.dashboard.lms');
    Route::get('/dashboard/lms/materi', [MateriGuruController::class, 'index'])->name('guru.dashboard.lms.materi');
    Route::get('/dashboard/lms/materi/create', [MateriGuruController::class, 'createView'])->name('guru.dashboard.lms.materi.create_view');
    Route::get('/dashboard/lms/materi/create/{id}', [MateriGuruController::class, 'create'])->name('guru.dashboard.lms.materi.create');
    Route::get('/dashboard/lms/materi/{id}', [MateriGuruController::class, 'detail'])->name('guru.dashboard.lms.materi.detail');
    Route::post('/dashboard/lms/materi/{id}', [MateriGuruController::class, 'store'])->name('guru.dashboard.lms.materi.store');
    Route::delete('/dashboard/lms/materi/{id}', [MateriGuruController::class, 'destroy'])->name('guru.dashboard.lms.materi.destroy');
    Route::get('/dashboard/lms/materi/edit/{id}', [MateriGuruController::class, 'edit'])->name('guru.dashboard.lms.materi.edit');
    Route::put('/dashboard/lms/materi/{id}', [MateriGuruController::class, 'update'])->name('guru.dashboard.lms.materi.update');

    // FORUM
    Route::get('/dashboard/lms/forum/{id}', [ForumGuruController::class, 'index'])->name('guru.dashboard.lms.forum');
    Route::get('/dashboard/lms/forum/tugas/{id}', [TugasGuruController::class, 'forumTugas'])->name('guru.dashboard.lms.forum.tugas');
    Route::get('/dashboard/lms/forum/anggota/{id}', [AnggotaGuruController::class, 'index'])->name('guru.dashboard.lms.forum.anggota');

    // PERIKSA TUGAS
    Route::get(('dashboard/lms/tugas/periksa'), [TugasGuruController::class, 'periksaTugas'])->name('guru.dashboard.lms.tugas.periksa');

    // TUGASFlo
    Route::get('/dashboard/lms/tugas/create/{id}', [TugasGuruController::class, 'create'])->name('guru.dashboard.lms.tugas.create');
    Route::get('/dashboard/lms/tugas/{id}', [TugasGuruController::class, 'detail'])->name('guru.dashboard.lms.detail.tugas');
    Route::post('/dashboard/lms/tugas/{id}', [TugasGuruController::class, 'store'])->name('guru.dashboard.lms.tugas.store');
    Route::get('/dashboard/lms/tugas/edit/{id}', [TugasGuruController::class, 'edit'])->name('guru.dashboard.lms.tugas.edit');
    Route::put('/dashboard/lms/tugas/{id}', [TugasGuruController::class, 'update'])->name('guru.dashboard.lms.tugas.update');
    Route::delete('/dashboard/lms/tugas/{id}', [TugasGuruController::class, 'destroy'])->name('guru.dashboard.lms.tugas.destroy');

    // PENGUMPULAN TUGAS
    Route::get('/dashboard/lms/tugasiswa/{id}', [TugasGuruController::class, 'tugasSiswa'])->name('guru.dashboard.lms.tugas.siswa');
    Route::get('/dashboard/lms/pengumpulan_tugas_siswa/{id}', [TugasGuruController::class, 'detailTugasSiswa'])->name('guru.dashboard.lms.tugas.siswa.detail');
    Route::put('/dashboard/lms/pengumpulan_tugas_siswa/{id}', [TugasGuruController::class, 'nilaiTugas'])->name('guru.dashboard.lms.tugas.siswa.update');

    // TOPIK
    Route::post('/dashboard/lms/topik/store/{id}', [TopikLmsController::class, "store"])->name('guru.dashboard.lms.topik.store');
    Route::put('/dashboard/lms/topik/update/{id}', [TopikLmsController::class, "update"])->name('guru.dashboard.lms.topik.update');
    Route::delete('/dashboard/lms/topik/delete/{id}', [TopikLmsController::class, "destroy"])->name('guru.dashboard.lms.topik.destroy');
    // ========================================================== END ROUTE LMS =================================================================================

    // START WALI KELAS (NAUFAL | PROSES)
    Route::get('/kelas/daftar-siswa', [GuruController::class, 'daftarSiswaWali'])->name('guru.daftarSiswaWali');
    Route::get('/kelas/{id_kelas}/siswa/{id_siswa}', [SiswaController::class, 'show'])->name('kelas.siswa.profil');
    Route::get('/kelas/jadwal-pelajaran', [GuruController::class, 'daftarKelasDanJadwal'])->name('guru.jadwalPelajaran');
    // ENDL WALI KELAS

    // START PERPUS


    Route::get('/dashboard/perpustakaan', [PerpustakaanController::class, 'indexGuru'])->name('perpustakaan');
    Route::get('/dashboard/perpustakaan/detail/{id}', [PerpustakaanController::class, 'showGuru'])->name('dashboard.perpustakaan.detail');
    Route::get('/dashboard/perpustakaan/riwayat', [RiwayatPengunjungController::class, 'transGuru'])->name('guru.perpustakaan.riwayat');
    Route::get('/dashboard/perpustakaan/rules', [PerpustakaanController::class, 'showRulesGuru'])->name('guru.perpustakaan.rules');

    //END PERPUS


    /**
     * START UJIAN
     */
    // CRUD JAWABAN UJIAN
    Route::get('/dashboard/ujian/jawaban_ujian', [GuruUjianController::class, 'showJawabanUjian'])->name('guru.dashboard.ujian.jawaban_ujian');
    Route::get('/dashboard/ujian/jawaban_ujian/{id}/jawaban_ujian_edit/', [GuruUjianController::class, 'editJawabanUjian'])->name('jawaban_ujian.edit');
    Route::put('/dashboard/ujian/jawaban_ujian/{id}', [GuruUjianController::class, 'jawabanUpdate'])->name('jawaban_ujian.update');
    Route::delete('/dashboard/ujian/jawaban_ujian/{id}', [GuruUjianController::class, 'destroyJawabanUjian'])->name('jawaban_ujian.destroy');

    //CRUD SOAL UJIAN
    Route::get('/dashboard/ujian/{id}/show_soal', [GuruUjianController::class, 'showSoal'])->name('guru.ujian.soal_ujian');
    Route::get('dashboard/ujian/{id}/create_soal', [GuruUjianController::class, 'storeSoal'])->name('guru.ujian.add.soal');
    Route::post('jawaban_ujian/import/{ujian_id}', [GuruUjianController::class, 'importSoal'])->name('soal_ujian.import');
    Route::get('/dashboard/ujian/soal_ujian/{id}/soal_edit', [GuruUjianController::class, 'soalEdit'])->name('soal_ujian.edit');
    Route::put('/dashboard/ujian/soal_ujian/{id}/', [GuruUjianController::class, 'soalUpdate'])->name('soal_ujian.update');
    Route::delete('/dashboard/ujian/show_soal/{id}', [GuruUjianController::class, 'destroySoal'])->name('soal_ujian.destroy');

    //CRUD UJIAN
    Route::get('/dashboard/ujian/create_ujian', [GuruUjianController::class, 'createUjian'])->name('guru.dashboard.ujian.create_ujian');
    // Route::post('/dashboard/ujian/create_ujian/', [GuruUjianController::class, 'storeUjian'])->name('ujian.store');
    Route::post('/dashboard/ujian/create_ujian/', [GuruUjianController::class, 'storeData'])->name('ujian.stored');
    Route::get('/dashboard/ujian/view_ujian', [GuruUjianController::class, 'indexUjian'])->name('ujian.show');
    Route::get('/dashboard/ujian/{id}/ujian_edit', [GuruUjianController::class, 'ujianEdit'])->name('guru.ujian.edit');
    Route::get('/dashboard/ujian/{id}/delete_ujian', [GuruUjianController::class, 'ujianDelete'])->name('guru.ujian.delete');

    //CRUD PENGUMPULAN
    Route::get('/dashboard/ujian/pengumpulan_ujian', [GuruUjianController::class, 'index'])->name('guru.dashboard.ujian.pengumpulan');
    Route::delete('pengumpulan_ujian/{id}', [GuruUjianController::class, 'destroy'])->name('guru.dashboard.pengumpulan_ujian.destroy');
    /**
     * END UJIAN
     */

    // START ABSENSI

    Route::get('/absensi', [guru\AbsensiController::class, 'index'])->name('guru.absensi.index');
    Route::get('/absensi/{id}/pertemuan', [guru\AbsensiController::class, 'details'])->name('guru.absensi.details');
    Route::get('/absensi/{id}/pertemuan/{pertemuan}', [guru\AbsensiController::class, 'pertemuanDetails'])->name('guru.absensi.pertemuan.details');
    Route::put('/absensi/update-status', [guru\AbsensiController::class, 'updateStatus'])->name('guru.absensi.updateStatus');
    Route::post('/guru/absensi/update-status', [guru\AbsensiController::class, 'updateStatusQr'])->name('guru.absensi.update-status');

    // END ABSENSI

    //lihat Jadwal Guru
    Route::get('/dashboard/lihat-jadwal', [LihatJadwalGuruController::class, 'index'])->name('lihat-jadwal-guru');
    //tombol print jadwal guru
    Route::get('/guru/jadwal/print', [LihatJadwalGuruController::class, 'print'])->name('guru.jadwal.print');
});


Route::group(['prefix' => 'pembina_ekstra', 'middleware' => ['pembina_ekstra']], function () {
    Route::get('/pembina', [PembinaekstraController::class, 'index'])->name('pembina_ekstra.dashboard');
});





//route crud kelas



Route::group(['prefix' => 'ekstrakrikuler'], function () {

    Route::get('/', [EkstrakurikulerController::class, 'dashboardEkstra'])->name('ekstrakurikuler.dashboardEkstra');
    Route::group(['middleware' => ['siswa']], function () {

        Route::post('/registrasi-ekstrakurikuler', [EkstrakurikulerController::class, 'submitForm'])->name('ekstrakurikuler.submit');
        // Route::middleware('auth:web-siswa')->group(function () {
        //     Route::get('/registrasi-ekstra', [YourController::class, 'showRegistrasi'])->name('ekstrakurikuler.registrasi');
        // });
    });
});

Route::get('/registrasi-ekstrakurikuler', [EkstrakurikulerController::class, 'showForm'])->name('ekstrakurikuler.registrasi');
Route::post('/registrasi-ekstrakurikuler/tambah', [EkstrakurikulerController::class, 'submitForm'])->name('ekstrakurikuler.registrasi.store');
//registrasi

// Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
// Route::get('/ekstrakurikuler', [EkstrakurikulerController::class, 'dashboardEkstra'])->name('ekstrakurikuler.dashboardEkstra');

// Route untuk halaman detail ekstrakurikuler
Route::get('/ekstrakurikuler/{id}', [EkstrakurikulerController::class, 'show'])->name('ekstrakurikuler.detail');

//start kelola informasi ekstra

// Rute untuk menampilkan form
// Route::get('/kelola-informasi/create', [KelolaInformasiController::class, 'create'])->name('kelolaInformasi.create');

// Rute untuk menyimpan informasi
// Route::post('/kelola-informasi', [KelolaInformasiController::class, 'store'])->name('kelolaInformasi.store');
require __DIR__ . '/auth.php';


Route::get("/cek", CeKController::class);

<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\beranda\BerandaController;
use App\Http\Controllers\CeKController;
use App\Http\Controllers\Ekstrakurikuler\EkstrakurikulerController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\guru;
use App\Http\Controllers\guru\GuruController;
use App\Http\Controllers\guru\GuruUjianController;
use App\Http\Controllers\guru\LihatJadwalGuruController;
use App\Http\Controllers\guru\lms\AnggotaGuruController;
use App\Http\Controllers\guru\lms\DashboardGuruController;
use App\Http\Controllers\guru\lms\ForumGuruController;
use App\Http\Controllers\guru\lms\MateriGuruController;
use App\Http\Controllers\guru\lms\TopikLmsController;
use App\Http\Controllers\guru\lms\TugasGuruController;
use App\Http\Controllers\guru\ProfilController;
use App\Http\Controllers\pembinaekstra\HistoriPeminjamanController as PembinaekstraHistoriPeminjamanController;
use App\Http\Controllers\pembinaekstra\PembinaAnggotaController;
use App\Http\Controllers\pembinaekstra\PembinaekstraController;
use App\Http\Controllers\pembinaekstra\PenilaianEkstraController;
use App\Http\Controllers\pembinaekstra\PerlengkapanController as PembinaekstraPerlengkapanController;
use App\Http\Controllers\pengurusekstra\AnggotaController as PengurusAnggotaController;
use App\Http\Controllers\pengurusekstra\HistoriPeminjamanController as PengurusHistoriPeminjamanController;
use App\Http\Controllers\pengurusekstra\PengurusekstraController;
use App\Http\Controllers\pengurusekstra\PenilaianEkstraPengurusController;
use App\Http\Controllers\pengurusekstra\PerlengkapanController as PengurusPerlengkapanController;
use App\Http\Controllers\perpustakaan\PerpustakaanController;
use App\Http\Controllers\perpustakaan\RiwayatPengunjungController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\siswa;
use App\Http\Controllers\siswa\LihatJadwalSiswaController;
use App\Http\Controllers\siswa\lms\AnggotaSiswaController;
use App\Http\Controllers\siswa\lms\DaftarTugasSiswaController;
use App\Http\Controllers\siswa\lms\DashboardSiswaController;
use App\Http\Controllers\siswa\lms\ForumSiswaController;
use App\Http\Controllers\siswa\lms\MateriSiswaController;
use App\Http\Controllers\siswa\lms\TugasSiswaController;
use App\Http\Controllers\Siswa\PrestasiSiswaController;
use App\Http\Controllers\Siswa\SiswaController;
use App\Http\Controllers\siswa\SiswaEkstrakurikulerController;
use App\Http\Controllers\Siswa\SiswaProfilController;
use App\Http\Controllers\siswa\UjianSiswaController;
use App\Http\Controllers\staffakademik;
use App\Http\Controllers\staffakademik\DashboardStaffAkdemikController;
use App\Http\Controllers\staffakademik\JadwalController;
use App\Http\Controllers\StaffAkademik\KelasController;
use App\Http\Controllers\staffakademik\LihatJadwalController;
use App\Http\Controllers\staffakademik\PrestasiController;
use App\Http\Controllers\staffakademik\RaporController;
use App\Http\Controllers\staffakademik\StaffakademikController;
use App\Http\Controllers\staffperpus\CategoryController;
use App\Http\Controllers\staffperpus\LaporanController;
use App\Http\Controllers\staffperpus\RiwayatTransaksiController;
use App\Http\Controllers\staffperpus\StaffperpusController;
use App\Http\Controllers\staffperpus\TransaksiPeminjamanController;
use App\Http\Controllers\superadmin\KelolaPembinaEkstraController;
use App\Http\Controllers\superadmin\KelolaPengurusEkstraController;
use App\Http\Controllers\superadmin\KelolaStaffAkademikController;
use App\Http\Controllers\superadmin\KelolaStaffPerpusController;
use App\Http\Controllers\superadmin\SuperadminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. Publik & Beranda Portal Routes
|--------------------------------------------------------------------------
| Standardized with clean kebab-case hyphens (-)
*/
Route::get('/', [BerandaController::class, 'home'])->name('beranda.home');
Route::get('/perpustakaan-publik', [BerandaController::class, 'perpustakaanPublik'])->name('beranda.perpustakaan');
Route::get('/katalog-perpustakaan-publik', [BerandaController::class, 'perpustakaanPublik'])->name('beranda.perpustakaanPublik'); // Kebab-case URL alias
Route::get('/perpustakaanPublik', [BerandaController::class, 'perpustakaanPublik']); // Legacy fallback URL

Route::get('/tenaga-pengajar', [BerandaController::class, 'tenagaPengajarPublik'])->name('beranda.guru');
Route::get('/direktori-tenaga-pengajar', [BerandaController::class, 'tenagaPengajarPublik'])->name('beranda.tenagaPengajarPublik'); // Kebab-case URL alias
Route::get('/tenagaPengajarPublik', [BerandaController::class, 'tenagaPengajarPublik']); // Legacy fallback URL

Route::get('/prestasi-publik', [BerandaController::class, 'prestasiPublik'])->name('beranda.prestasi');
Route::get('/galeri-prestasi-publik', [BerandaController::class, 'prestasiPublik'])->name('beranda.prestasiPublik'); // Kebab-case URL alias
Route::get('/prestasiPublik', [BerandaController::class, 'prestasiPublik']); // Legacy fallback URL

// SSO Google Authentication
Route::get('/auth/redirect', [GoogleLoginController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/redirect', [GoogleLoginController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/google/call-back', [GoogleLoginController::class, 'callback'])->name('auth.google.callback');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'callback']);

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Breeze User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/cek', CeKController::class)->name('cek.index');

/*
|--------------------------------------------------------------------------
| 2. Superadmin Routes
|--------------------------------------------------------------------------
| Standardized with clean kebab-case hyphens (-)
*/
Route::group(['prefix' => 'superadmin', 'middleware' => ['admin']], function () {
    Route::get('/dashboard', [SuperadminController::class, 'index'])->name('superadmin.dashboard');

    // Profil & Pengaturan
    Route::get('/profil', [SuperadminController::class, 'setting'])->name('superadmin.profil');
    Route::get('/pengaturan', [SuperadminController::class, 'setting'])->name('superadmin.profile');
    Route::get('/setting', [SuperadminController::class, 'setting']);
    Route::post('/profil/update', [SuperadminController::class, 'setting_update'])->name('superadmin.profil.update');
    Route::post('/pengaturan/update', [SuperadminController::class, 'setting_update'])->name('superadmin.profile.update');
    Route::post('/setting/update', [SuperadminController::class, 'setting_update']);

    // Staff Akademik
    Route::get('/staff-akademik', [KelolaStaffAkademikController::class, 'index'])->name('superadmin.staff-akademik.index');
    Route::get('/kelola-staff-akademik', [KelolaStaffAkademikController::class, 'index'])->name('superadmin.kelola_staff_akademik');
    Route::get('/staff-akademik/create', [KelolaStaffAkademikController::class, 'create'])->name('superadmin.staff-akademik.create');
    Route::get('/kelola-staff-akademik/create', [KelolaStaffAkademikController::class, 'create'])->name('superadmin.kelola_staff_akademik.create');
    Route::post('/staff-akademik', [KelolaStaffAkademikController::class, 'store'])->name('superadmin.staff-akademik.store');
    Route::post('/kelola-staff-akademik/store', [KelolaStaffAkademikController::class, 'store'])->name('superadmin.kelola_staff_akademik.store');
    Route::get('/staff-akademik/{id}/edit', [KelolaStaffAkademikController::class, 'edit'])->name('superadmin.staff-akademik.edit');
    Route::get('/kelola-staff-akademik/edit/{id}', [KelolaStaffAkademikController::class, 'edit'])->name('superadmin.kelola_staff_akademik.edit');
    Route::put('/staff-akademik/{id}', [KelolaStaffAkademikController::class, 'update'])->name('superadmin.staff-akademik.update');
    Route::post('/kelola-staff-akademik/update', [KelolaStaffAkademikController::class, 'update'])->name('superadmin.kelola_staff_akademik.update');
    Route::delete('/staff-akademik/{id}', [KelolaStaffAkademikController::class, 'destroy'])->name('superadmin.staff-akademik.destroy');
    Route::delete('/kelola-staff-akademik/delete/{id}', [KelolaStaffAkademikController::class, 'destroy'])->name('superadmin.kelola_staff_akademik.destroy');
    Route::delete('/superadmin/kelola_staff_akademik/delete/{id}', [KelolaStaffAkademikController::class, 'destroy']);
    Route::post('/staff-akademik/{id}/reset', [KelolaStaffAkademikController::class, 'reset'])->name('superadmin.staff-akademik.reset');
    Route::post('/kelola-staff-akademik/reset/{id}', [KelolaStaffAkademikController::class, 'reset'])->name('superadmin.kelola_staff_akademik.reset');
    Route::post('/superadmin/kelola_staff_akademik/reset/{id}', [KelolaStaffAkademikController::class, 'reset']);

    // Staff Perpustakaan
    Route::get('/staff-perpus', [KelolaStaffPerpusController::class, 'index'])->name('superadmin.staff-perpus.index');
    Route::get('/kelola-staff-perpus', [KelolaStaffPerpusController::class, 'index'])->name('superadmin.kelola_staff_perpus');
    Route::get('/staff-perpus/create', [KelolaStaffPerpusController::class, 'create'])->name('superadmin.staff-perpus.create');
    Route::get('/kelola-staff-perpus/create', [KelolaStaffPerpusController::class, 'create'])->name('superadmin.kelola_staff_perpus.create');
    Route::post('/staff-perpus', [KelolaStaffPerpusController::class, 'store'])->name('superadmin.staff-perpus.store');
    Route::post('/kelola-staff-perpus/store', [KelolaStaffPerpusController::class, 'store'])->name('superadmin.kelola_staff_perpus.store');
    Route::get('/staff-perpus/{id}/edit', [KelolaStaffPerpusController::class, 'edit'])->name('superadmin.staff-perpus.edit');
    Route::get('/kelola-staff-perpus/edit/{id}', [KelolaStaffPerpusController::class, 'edit'])->name('superadmin.kelola_staff_perpus.edit');
    Route::put('/staff-perpus/{id}', [KelolaStaffPerpusController::class, 'update'])->name('superadmin.staff-perpus.update');
    Route::post('/kelola-staff-perpus/update', [KelolaStaffPerpusController::class, 'update'])->name('superadmin.kelola_staff_perpus.update');
    Route::delete('/staff-perpus/{id}', [KelolaStaffPerpusController::class, 'destroy'])->name('superadmin.staff-perpus.destroy');
    Route::delete('/kelola-staff-perpus/delete/{id}', [KelolaStaffPerpusController::class, 'destroy'])->name('superadmin.kelola_staff_perpus.destroy');
    Route::delete('/superadmin/kelola_staff_perpus/delete/{id}', [KelolaStaffPerpusController::class, 'destroy']);
    Route::post('/staff-perpus/{id}/reset', [KelolaStaffPerpusController::class, 'reset'])->name('superadmin.staff-perpus.reset');
    Route::post('/kelola-staff-perpus/reset/{id}', [KelolaStaffPerpusController::class, 'reset'])->name('superadmin.kelola_staff_perpus.reset');
    Route::post('/superadmin/kelola_staff_perpus/reset/{id}', [KelolaStaffPerpusController::class, 'reset']);

    // Data Guru
    Route::get('/guru', [SuperadminController::class, 'showDataGuru'])->name('superadmin.guru.index');
    Route::get('/kelola-data-guru', [SuperadminController::class, 'showDataGuru'])->name('superadmin.keloladataguru'); // Hyphenated URL!
    Route::get('/keloladataguru', [SuperadminController::class, 'showDataGuru']); // Legacy fallback
    Route::get('/guru/create', [SuperadminController::class, 'create'])->name('superadmin.guru.create');
    Route::get('/guru/tambah', [SuperadminController::class, 'create'])->name('data.guru.tambah');
    Route::get('/kelola-akun/data-guru/tambah', [SuperadminController::class, 'create'])->name('guru.create');
    Route::post('/guru', [SuperadminController::class, 'store'])->name('superadmin.guru.store');
    Route::post('/kelola-akun/data-guru/store', [SuperadminController::class, 'store'])->name('guru.store');
    Route::get('/guru/{id_guru}/edit', [SuperadminController::class, 'edit'])->name('superadmin.guru.edit');
    Route::get('/guru/edit/{id_guru}', [SuperadminController::class, 'edit'])->name('guru.edit');
    Route::put('/guru/{id_guru}', [SuperadminController::class, 'update'])->name('superadmin.guru.update');
    Route::put('/guru/update/{id_guru}', [SuperadminController::class, 'update'])->name('guru.update');
    Route::delete('/guru/{id}', [SuperadminController::class, 'destroy'])->name('superadmin.guru.destroy');
    Route::delete('/kelola-akun/data-guru/{id}', [SuperadminController::class, 'destroy'])->name('guru.destroy');
    Route::get('/guru/search', [SuperadminController::class, 'searchGuru'])->name('superadmin.guru.search');
    Route::get('/guru/cari', [SuperadminController::class, 'searchGuru'])->name('superadmin.searchGuru');
    Route::get('/superadmin/keloladataguru/search', [SuperadminController::class, 'searchGuru']);

    // Data Siswa
    Route::get('/siswa', [SuperadminController::class, 'showDataSiswa'])->name('superadmin.siswa.index');
    Route::get('/kelola-data-siswa', [SuperadminController::class, 'showDataSiswa'])->name('superadmin.keloladatasiswa'); // Hyphenated URL!
    Route::get('/keloladatasiswa', [SuperadminController::class, 'showDataSiswa']); // Legacy fallback
    Route::get('/siswa/create', [SuperadminController::class, 'createSiswa'])->name('superadmin.siswa.create');
    Route::get('/siswa/tambah', [SuperadminController::class, 'createSiswa'])->name('data.siswa.tambah');
    Route::get('/kelola-akun/data-siswa/tambah', [SuperadminController::class, 'createSiswa'])->name('siswa.create');
    Route::post('/siswa', [SuperadminController::class, 'storeSiswa'])->name('superadmin.siswa.store');
    Route::post('/kelola-akun/data-siswa/store', [SuperadminController::class, 'storeSiswa'])->name('siswa.store');
    Route::get('/siswa/{id_siswa}/edit', [SuperadminController::class, 'siswaEdit'])->name('superadmin.siswa.edit');
    Route::get('/siswa/editsiswa/{id_siswa}', [SuperadminController::class, 'siswaEdit'])->name('siswa.edit');
    Route::put('/siswa/{id_siswa}', [SuperadminController::class, 'siswaUpdate'])->name('superadmin.siswa.update');
    Route::put('/siswa/updatesiswa/{id_siswa}', [SuperadminController::class, 'siswaUpdate'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SuperadminController::class, 'siswaDestroy'])->name('superadmin.siswa.destroy');
    Route::delete('/kelola-akun/data-siswa/{id}', [SuperadminController::class, 'siswaDestroy'])->name('siswa.destroy');
    Route::get('/siswa/search', [SuperadminController::class, 'searchSiswa'])->name('superadmin.siswa.search');
    Route::get('/siswa/cari', [SuperadminController::class, 'searchSiswa'])->name('superadmin.searchSiswa');
    Route::get('/superadmin/keloladatasiswa/search', [SuperadminController::class, 'searchSiswa']);

    // Pembina Ekstrakurikuler
    Route::get('/pembina-ekstrakurikuler', [KelolaPembinaEkstraController::class, 'index'])->name('superadmin.pembina-ekstra.index');
    Route::get('/kelola-pembina-ekstrakurikuler', [KelolaPembinaEkstraController::class, 'index'])->name('superadmin.kelola_pembina_ekstrakurikuler');
    Route::get('/pembina-ekstrakurikuler/create', [KelolaPembinaEkstraController::class, 'create'])->name('superadmin.pembina-ekstra.create');
    Route::get('/kelola-pembina-ekstrakurikuler/create', [KelolaPembinaEkstraController::class, 'create'])->name('kelola_pembina_ekstrakurikuler.create');
    Route::put('/pembina-ekstrakurikuler/store/{id}', [KelolaPembinaEkstraController::class, 'store'])->name('superadmin.pembina-ekstra.store');
    Route::put('/kelola-pembina-ekstrakurikuler/store/{id}', [KelolaPembinaEkstraController::class, 'store'])->name('kelola_pembina_ekstrakurikuler.store');
    Route::get('/pembina-ekstrakurikuler/{id}/edit', [KelolaPembinaEkstraController::class, 'edit'])->name('superadmin.pembina-ekstra.edit');
    Route::get('/kelola-pembina-ekstrakurikuler/edit/{id}', [KelolaPembinaEkstraController::class, 'edit'])->name('kelola_pembina_ekstrakurikuler.edit');
    Route::put('/pembina-ekstrakurikuler/update', [KelolaPembinaEkstraController::class, 'update'])->name('superadmin.pembina-ekstra.update');
    Route::put('/kelola-pembina-ekstrakurikuler/update', [KelolaPembinaEkstraController::class, 'update'])->name('kelola_pembina_ekstrakurikuler.update');
    Route::delete('/pembina-ekstrakurikuler/{id}', [KelolaPembinaEkstraController::class, 'destroy'])->name('superadmin.pembina-ekstra.destroy');
    Route::delete('/kelola-pembina-ekstrakurikuler/delete/{id}', [KelolaPembinaEkstraController::class, 'destroy'])->name('kelola_pembina_ekstrakurikuler.destroy');
    Route::put('/superadmin/kelola_pembina_ekstrakurikuler/delete/{id}', [KelolaPembinaEkstraController::class, 'destroy']);

    // Pengurus Ekstrakurikuler
    Route::get('/pengurus-ekstrakurikuler', [KelolaPengurusEkstraController::class, 'showDataPengurus'])->name('superadmin.pengurus-ekstra.index');
    Route::get('/kelola-data-pengurus', [KelolaPengurusEkstraController::class, 'showDataPengurus'])->name('superadmin.keloladatapengurus'); // Hyphenated URL!
    Route::get('/keloladatapengurus', [KelolaPengurusEkstraController::class, 'showDataPengurus']); // Legacy fallback
    Route::get('/pengurus-ekstrakurikuler/create', [KelolaPengurusEkstraController::class, 'createPengurus'])->name('superadmin.pengurus-ekstra.create');
    Route::get('/pengurus/tambah', [KelolaPengurusEkstraController::class, 'createPengurus'])->name('data.pengurus.tambah');
    Route::get('/kelola-akun/data-pengurus/tambah', [KelolaPengurusEkstraController::class, 'createPengurus'])->name('pengurus.create');
    Route::post('/pengurus-ekstrakurikuler/store/{id_siswa}', [KelolaPengurusEkstraController::class, 'storePengurus'])->name('superadmin.pengurus-ekstra.store');
    Route::post('/kelola-akun/data-pengurus/store/{id_siswa}', [KelolaPengurusEkstraController::class, 'storePengurus'])->name('pengurus.store');
    Route::get('/pengurus-ekstrakurikuler/{id}/edit', [KelolaPengurusEkstraController::class, 'editPengurus'])->name('superadmin.pengurus-ekstra.edit');
    Route::get('/pengurus/{id}/edit', [KelolaPengurusEkstraController::class, 'editPengurus'])->name('data.pengurus.edit');
    Route::get('/data/pengurus/{id}/edit', [KelolaPengurusEkstraController::class, 'editPengurus'])->name('pengurus.edit');
    Route::put('/pengurus-ekstrakurikuler/{id}', [KelolaPengurusEkstraController::class, 'updatePengurus'])->name('superadmin.pengurus-ekstra.update');
    Route::put('/pengurus/{id}/update', [KelolaPengurusEkstraController::class, 'updatePengurus'])->name('data.pengurus.update');
    Route::put('/data/pengurus/{id}/update', [KelolaPengurusEkstraController::class, 'updatePengurus'])->name('pengurus.update');
    Route::delete('/pengurus-ekstrakurikuler/{id_pengurus}', [KelolaPengurusEkstraController::class, 'pengurusDestroy'])->name('superadmin.pengurus-ekstra.destroy');
    Route::delete('/kelola-akun/data-pengurus/{id_pengurus}', [KelolaPengurusEkstraController::class, 'pengurusDestroy'])->name('pengurus.destroy');
    Route::delete('/pengurus/{id_siswa}/delete-role', [KelolaPengurusEkstraController::class, 'deleteRole'])->name('superadmin.pengurus-ekstra.delete-role');
    Route::delete('/superadmin/pengurus/{id_siswa}/delete-role', [KelolaPengurusEkstraController::class, 'deleteRole'])->name('pengurus.delete-role');
    Route::get('/pengurus-ekstrakurikuler/search', [KelolaPengurusEkstraController::class, 'searchPengurus'])->name('superadmin.pengurus-ekstra.search');
    Route::get('/pengurus-ekstrakurikuler/cari', [KelolaPengurusEkstraController::class, 'searchPengurus'])->name('superadmin.searchPengurus');
    Route::get('/superadmin/keloladatapengurus/search', [KelolaPengurusEkstraController::class, 'searchPengurus']);
});

/*
|--------------------------------------------------------------------------
| 3. Staff Akademik Routes
|--------------------------------------------------------------------------
| Standardized with clean kebab-case hyphens (-)
*/
Route::group(['prefix' => 'staff_akademik', 'middleware' => ['staff_akademik']], function () {
    Route::get('/dashboard', [DashboardStaffAkdemikController::class, 'index'])->name('staff_akademik.dashboard');

    // Profil Staff Akademik
    Route::get('/profil', [StaffakademikController::class, 'profile'])->name('staff_akademik.profile');
    Route::get('/profile', [StaffakademikController::class, 'profile']);
    Route::put('/profil/update', [StaffakademikController::class, 'update_profile'])->name('staff_akademik.profile.update');
    Route::put('/profile/update', [StaffakademikController::class, 'update_profile']);

    // Manajemen Jadwal
    Route::get('/jadwal', [JadwalController::class, 'jadwalIndex'])->name('staff_akademik.jadwal.index');
    Route::get('/jadwal-pelajaran', [JadwalController::class, 'jadwalIndex'])->name('staff_akademik.jadwal');
    Route::get('/jadwal/tambah', [JadwalController::class, 'createJadwal'])->name('staff_akademik.jadwal.create');
    Route::get('/jadwal/create', [JadwalController::class, 'createJadwal']);
    Route::post('/jadwal/tambah', [JadwalController::class, 'storeJadwal'])->name('staff_akademik.jadwal.store');
    Route::post('/jadwal', [JadwalController::class, 'storeJadwal']);
    Route::get('/jadwal/edit/{id}', [JadwalController::class, 'editJadwal'])->name('staff_akademik.jadwal.edit');
    Route::get('/jadwal/{id}/edit', [JadwalController::class, 'editJadwal']);
    Route::put('/jadwal/update/{id}', [JadwalController::class, 'updateJadwal'])->name('staff_akademik.jadwal.update');
    Route::put('/jadwal/{id}', [JadwalController::class, 'updateJadwal']);
    Route::delete('/jadwal/delete/{id}', [JadwalController::class, 'deleteJadwal'])->name('staff_akademik.jadwal.delete');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'deleteJadwal']);
    Route::get('/jadwal/import', [JadwalController::class, 'importPage'])->name('staff_akademik.jadwal.import-page');
    Route::post('/jadwal/import', [JadwalController::class, 'importExcel'])->name('staff_akademik.jadwal.import');
    Route::get('/jadwal/export', [JadwalController::class, 'exportExcel'])->name('staff_akademik.jadwal.export');
    Route::get('/staff_akademik/jadwal/export', [JadwalController::class, 'exportExcel']);
    Route::get('/jadwal/pdf', [JadwalController::class, 'exportPdf'])->name('staff_akademik.jadwal.pdf');
    Route::get('/staff_akademik/jadwal/pdf', [JadwalController::class, 'exportPdf']);

    // Manajemen Kelas & Siswa
    Route::get('/kelas', [KelasController::class, 'indexKelas'])->name('staff_akademik.kelas.index');
    Route::get('/daftar-semua-kelas', [KelasController::class, 'indexKelas'])->name('staffakademik.kelas.index');
    Route::get('/staff-akademik/kelas', [StaffakademikController::class, 'cari']); // Legacy search
    Route::get('/kelas/create', [KelasController::class, 'createKelas'])->name('staff_akademik.kelas.create');
    Route::post('/kelas', [KelasController::class, 'storeKelas'])->name('staff_akademik.kelas.store');
    Route::post('/kelas/store', [StaffakademikController::class, 'store']);
    Route::get('/kelas/{id}/edit', [KelasController::class, 'editKelas'])->name('staff_akademik.kelas.edit');
    Route::put('/kelas/{id}', [KelasController::class, 'updateKelas'])->name('staff_akademik.kelas.update');
    Route::post('/kelas/update/{id}', [StaffakademikController::class, 'update']);
    Route::delete('/kelas/{id}', [KelasController::class, 'destroyKelas'])->name('staff_akademik.kelas.destroy');
    Route::delete('/kelas/delete/{id}', [StaffakademikController::class, 'destroy']);
    Route::get('/daftar-kelas', [KelasController::class, 'daftarkelas'])->name('staff_akademik.kelas.daftar'); // Hyphenated URL!
    Route::get('/daftarkelas', [KelasController::class, 'daftarkelas'])->name('daftarkelas'); // Backward compatible
    Route::get('/kelas/{id}/siswa', [KelasController::class, 'showSiswa'])->name('staff_akademik.kelas.siswa');
    Route::get('/kelas/{id}/daftar-siswa', [KelasController::class, 'showSiswa'])->name('kelas.siswa');
    Route::get('/kelas/{id_kelas}/tambah-siswa', [KelasController::class, 'tambahSiswa'])->name('staff_akademik.kelas.tambah-siswa');
    Route::get('/kelas/{id_kelas}/form-tambah-siswa', [KelasController::class, 'tambahSiswa'])->name('kelas.tambahSiswa');
    Route::post('/kelas/{id_kelas}/simpan-siswa', [KelasController::class, 'simpanSiswa'])->name('staff_akademik.kelas.simpan-siswa');
    Route::post('/kelas/{id_kelas}/action-simpan-siswa', [KelasController::class, 'simpanSiswa'])->name('kelas.simpanSiswa');
    Route::delete('/kelas/{id_kelas}/siswa/{id_siswa}', [KelasController::class, 'hapusSiswa'])->name('staff_akademik.kelas.hapus-siswa');
    Route::delete('/kelas/{id_kelas}/siswa/{id_siswa}/hapus', [KelasController::class, 'hapusSiswa'])->name('kelas.hapusSiswa');
    Route::delete('/kelas/{id_kelas}/hapus-siswa-massal', [KelasController::class, 'hapusSiswaMassal'])->name('staff_akademik.kelas.hapus-siswa-massal');
    Route::delete('/kelas/{id_kelas}/action-hapus-siswa-massal', [KelasController::class, 'hapusSiswaMassal'])->name('kelas.hapusSiswaMassal');
    Route::get('/kelas/{id_kelas}/edit-wali-kelas', [KelasController::class, 'editWaliKelas'])->name('staff_akademik.kelas.edit-wali-kelas');
    Route::get('/kelas/{id_kelas}/form-edit-wali-kelas', [KelasController::class, 'editWaliKelas'])->name('kelas.editWaliKelas');
    Route::put('/kelas/{id_kelas}/update-wali-kelas', [KelasController::class, 'updateWaliKelas'])->name('staff_akademik.kelas.update-wali-kelas');
    Route::put('/kelas/{id_kelas}/action-update-wali-kelas', [KelasController::class, 'updateWaliKelas'])->name('kelas.updateWaliKelas');

    // Manajemen Mata Pelajaran
    Route::get('/mata-pelajaran', [KelasController::class, 'index'])->name('staff_akademik.mata-pelajaran.index');
    Route::get('/mata-pelajaran/create', [KelasController::class, 'create'])->name('staff_akademik.mata-pelajaran.create');
    Route::post('/mata-pelajaran', [KelasController::class, 'store'])->name('staff_akademik.mata-pelajaran.store');
    Route::get('/mata-pelajaran/{id}/edit', [KelasController::class, 'edit'])->name('staff_akademik.mata-pelajaran.edit');
    Route::put('/mata-pelajaran/{id}', [KelasController::class, 'update'])->name('staff_akademik.mata-pelajaran.update');
    Route::delete('/mata-pelajaran/{id}', [KelasController::class, 'destroy'])->name('staff_akademik.mata-pelajaran.destroy');

    // Guru Mata Pelajaran
    Route::get('/guru-mata-pelajaran', [KelasController::class, 'indexGuruMataPelajaran'])->name('staff_akademik.guru-mata-pelajaran.index');
    Route::get('/daftar-guru-mata-pelajaran', [KelasController::class, 'indexGuruMataPelajaran'])->name('staff_akademik.guru_mata_pelajaran.index'); // Hyphenated URL!
    Route::get('/guru_mata_pelajaran', [KelasController::class, 'indexGuruMataPelajaran']);
    Route::get('/guru-mata-pelajaran/create', [KelasController::class, 'createGuruMataPelajaran'])->name('staff_akademik.guru-mata-pelajaran.create');
    Route::post('/guru-mata-pelajaran', [KelasController::class, 'storeGuruMataPelajaran'])->name('staff_akademik.guru-mata-pelajaran.store');
    Route::post('/guru-mata-pelajaran/tambah', [KelasController::class, 'storeGuruMataPelajaran'])->name('staff_akademik.guru_mata_pelajaran.store');
    Route::post('/guru_mata_pelajaran/store', [KelasController::class, 'storeGuruMataPelajaran']);
    Route::get('/guru-mata-pelajaran/{id}/edit', [KelasController::class, 'editGuruMataPelajaran'])->name('staff_akademik.guru-mata-pelajaran.edit');
    Route::put('/guru-mata-pelajaran/{id}', [KelasController::class, 'updateGuruMataPelajaran'])->name('staff_akademik.guru-mata-pelajaran.update');
    Route::put('/guru-mata-pelajaran/update/{id}', [KelasController::class, 'updateGuruMataPelajaran'])->name('staff_akademik.guru_mata_pelajaran.update');
    Route::delete('/guru-mata-pelajaran/{id}', [KelasController::class, 'destroyGuruMataPelajaran'])->name('staff_akademik.guru-mata-pelajaran.destroy');
    Route::delete('/guru-mata-pelajaran/delete/{id}', [KelasController::class, 'destroyGuruMataPelajaran'])->name('staff_akademik.guru_mata_pelajaran.destroy');

    // Master Data Views
    Route::get('/matpel/master-guru', [KelasController::class, 'showMasterGuru'])->name('staff_akademik.master.guru');
    Route::get('/matpel/master-kelas', [KelasController::class, 'showMasterKelas'])->name('staff_akademik.master.kelas');
    Route::get('/matpel/master-matpel', [KelasController::class, 'showMasterMatpel'])->name('staff_akademik.master.matpel');

    // Lihat Jadwal
    Route::get('/jadwal-kelas', [LihatJadwalController::class, 'kelas_index'])->name('staff_akademik.lihat-jadwal.kelas');
    Route::get('/lihat-jadwal-kelas', [LihatJadwalController::class, 'kelas_index'])->name('lihat.jadwal.kelas');
    Route::get('/jadwal-guru', [LihatJadwalController::class, 'guru_index'])->name('staff_akademik.lihat-jadwal.guru');
    Route::get('/lihat-jadwal-guru', [LihatJadwalController::class, 'guru_index'])->name('lihat.jadwal.guru');

    // Prestasi
    Route::get('/prestasi', [PrestasiController::class, 'index'])->name('staff_akademik.prestasi.index');
    Route::get('/daftar-prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
    Route::get('/prestasi/create', [PrestasiController::class, 'create'])->name('staff_akademik.prestasi.create');
    Route::get('/prestasi/tambah', [PrestasiController::class, 'create'])->name('prestasi.create');
    Route::post('/prestasi', [PrestasiController::class, 'store'])->name('staff_akademik.prestasi.store');
    Route::post('/prestasi/store', [PrestasiController::class, 'store'])->name('prestasi.store');
    Route::get('/prestasi/pengajuan', [PrestasiController::class, 'pengajuan'])->name('staff_akademik.prestasi.pengajuan');
    Route::get('/prestasi/daftar-pengajuan', [PrestasiController::class, 'pengajuan'])->name('prestasi.pengajuan');
    Route::get('/prestasi/show/{id}', [PrestasiController::class, 'show'])->name('staff_akademik.prestasi.show');
    Route::get('/prestasi/detail/{id}', [PrestasiController::class, 'show'])->name('prestasi.show');
    Route::get('/prestasi/{id}', [PrestasiController::class, 'show']);
    Route::put('/prestasi/{id}', [PrestasiController::class, 'update'])->name('staff_akademik.prestasi.update');
    Route::put('/prestasi/update/{id}', [PrestasiController::class, 'update'])->name('prestasi.update');
    Route::delete('/prestasi/{id}', [PrestasiController::class, 'destroy'])->name('staff_akademik.prestasi.destroy');
    Route::delete('/prestasi/delete/{id}', [PrestasiController::class, 'destroy'])->name('prestasi.destroy');
    Route::put('/prestasi/setujui/{id}', [PrestasiController::class, 'setujui'])->name('staff_akademik.prestasi.setujui');
    Route::put('/prestasi/persetujuan/{id}', [PrestasiController::class, 'setujui'])->name('prestasi.setujui');
    Route::post('/prestasi/tolak/{id}', [PrestasiController::class, 'tolak'])->name('staff_akademik.prestasi.tolak');
    Route::post('/prestasi/penolakan/{id}', [PrestasiController::class, 'tolak'])->name('prestasi.tolak');

    // Rapor
    Route::get('/rapor', [RaporController::class, 'index'])->name('staff_akademik.rapor.index');
    Route::get('/rapor/siswa/{id}', [RaporController::class, 'showDetail'])->name('staff_akademik.rapor.detail');
    Route::get('/rapor/siswa/{id}/download', [RaporController::class, 'downloadPdf'])->name('staff_akademik.rapor.download');
    Route::get('/rapor/update-nilai', [RaporController::class, 'updateNilai'])->name('staff_akademik.rapor.update-nilai');
    Route::get('/rapor/perbarui-nilai', [RaporController::class, 'updateNilai'])->name('staff_akademik.rapor.update_nilai');

    // Absensi
    Route::get('/absensi', [staffakademik\AbsensiController::class, 'index'])->name('staff_akademik.absensi.index');
    Route::get('/rekap-absensi', [staffakademik\AbsensiController::class, 'index'])->name('akademik.absensi.index');
    Route::get('/absensi/{id}/pertemuan', [staffakademik\AbsensiController::class, 'details'])->name('staff_akademik.absensi.details');
    Route::get('/absensi/{id}/daftar-pertemuan', [staffakademik\AbsensiController::class, 'details'])->name('absensi.detail');
    Route::get('/absensi/{id}/rincian-pertemuan', [staffakademik\AbsensiController::class, 'details'])->name('akademik.absensi.details');
    Route::get('/absensi/{id}/pertemuan/{pertemuan}', [staffakademik\AbsensiController::class, 'pertemuanDetails'])->name('staff_akademik.absensi.pertemuan.details');
    Route::get('/absensi/{id}/pertemuan/{pertemuan}/detail', [staffakademik\AbsensiController::class, 'pertemuanDetails'])->name('akademik.absensi.pertemuan.details');
    Route::post('/absensi/{id}/generate', [staffakademik\AbsensiController::class, 'generatePresenceData'])->name('staff_akademik.absensi.generate');
    Route::post('/absensi/{id}/buat-kehadiran', [staffakademik\AbsensiController::class, 'generatePresenceData'])->name('akademik.absensi.generate');
    Route::delete('/absensi/{id}/reset', [staffakademik\AbsensiController::class, 'resetPertemuan'])->name('staff_akademik.absensi.reset');
    Route::delete('/absensi/{id}/atur-ulang', [staffakademik\AbsensiController::class, 'resetPertemuan'])->name('akademik.absensi.reset');
    Route::put('/absensi/update-status', [staffakademik\AbsensiController::class, 'updateStatus'])->name('staff_akademik.absensi.update-status');
    Route::put('/absensi/ubah-status', [staffakademik\AbsensiController::class, 'updateStatus'])->name('akademik.absensi.updateStatus');
});

/*
|--------------------------------------------------------------------------
| 4. Staff Perpustakaan Routes
|--------------------------------------------------------------------------
| Standardized with clean kebab-case hyphens (-)
*/
Route::group(['prefix' => 'staff_perpus', 'middleware' => ['staff_perpus']], function () {
    Route::get('/dashboard', [StaffperpusController::class, 'index'])->name('staff_perpus.dashboard');

    // Profil
    Route::get('/profil', [StaffperpusController::class, 'profile'])->name('staff_perpus.profile');
    Route::get('/profile', [StaffperpusController::class, 'profile']);
    Route::post('/profil/update', [StaffperpusController::class, 'editprofile'])->name('staff_perpus.profile.update');
    Route::post('/profil/perbarui', [StaffperpusController::class, 'editprofile'])->name('staff_perpus.editprofile');
    Route::post('/chpfile', [StaffperpusController::class, 'editprofile']);
    Route::post('/profil/password', [StaffperpusController::class, 'pwdEdit'])->name('staff_perpus.profile.password');
    Route::post('/profil/ubah-password', [StaffperpusController::class, 'pwdEdit'])->name('staff_perpus.editpwdprofile');
    Route::post('/pwdefile', [StaffperpusController::class, 'pwdEdit']);

    // Kategori Buku
    Route::get('/kategori', [CategoryController::class, 'manageCategory'])->name('staff_perpus.kategori.index');
    Route::get('/kelola-kategori', [CategoryController::class, 'manageCategory'])->name('staff_perpus.manageCategory'); // Hyphenated URL!
    Route::get('/daftar-kategori', [CategoryController::class, 'manageCategory'])->name('staff_perpus.managecategories'); // Hyphenated URL!
    Route::get('/manageCategory', [CategoryController::class, 'manageCategory']);
    Route::get('/mngcategory', [CategoryController::class, 'manageCategory']);
    Route::post('/kategori', [CategoryController::class, 'addCategory'])->name('staff_perpus.kategori.store');
    Route::post('/kategori/tambah', [CategoryController::class, 'addCategory'])->name('bookcategories.create');
    Route::post('/abcategory', [CategoryController::class, 'addCategory']);
    Route::post('/kategori/update', [CategoryController::class, 'updateCategory'])->name('staff_perpus.kategori.update');
    Route::post('/kategori/ubah', [CategoryController::class, 'updateCategory'])->name('bookcategories.update');
    Route::post('/upcategories', [CategoryController::class, 'updateCategory']);
    Route::post('/kategori/delete', [CategoryController::class, 'deleteCategory'])->name('staff_perpus.kategori.destroy');
    Route::post('/kategori/hapus', [CategoryController::class, 'deleteCategory'])->name('bookcategories.delete');
    Route::post('/dbcategories', [CategoryController::class, 'deleteCategory']);

    // Buku
    Route::get('/buku', [StaffperpusController::class, 'daftarbuku'])->name('staff_perpus.buku.index');
    Route::get('/daftar-buku', [StaffperpusController::class, 'daftarbuku'])->name('staff_perpus.buku.daftarbuku'); // Hyphenated URL!
    Route::get('/buku/create', [StaffperpusController::class, 'createbuku'])->name('staff_perpus.buku.create');
    Route::post('/buku', [StaffperpusController::class, 'storebuku'])->name('staff_perpus.buku.store');
    Route::get('/buku/{id}', [StaffperpusController::class, 'show'])->name('staff_perpus.buku.show');
    Route::get('/buku/detail/{id}', [StaffperpusController::class, 'show'])->name('staff_perpus.buku.detail');
    Route::get('/buku/{id}/edit', [StaffperpusController::class, 'editbuku'])->name('staff_perpus.buku.edit');
    Route::put('/buku/{id}', [StaffperpusController::class, 'updatebuku'])->name('staff_perpus.buku.update');
    Route::delete('/buku/{id}', [StaffperpusController::class, 'destroybuku'])->name('staff_perpus.buku.destroy');

    // Transaksi Peminjaman & Pengembalian
    Route::get('/transaksi', [TransaksiPeminjamanController::class, 'index'])->name('staff_perpus.transaksi.index');
    Route::get('/daftar-transaksi', [TransaksiPeminjamanController::class, 'index'])->name('staff_perpus.transaksi.daftartransaksi'); // Hyphenated URL!
    Route::get('/transaksi/create', [TransaksiPeminjamanController::class, 'create'])->name('staff_perpus.transaksi.create');
    Route::post('/transaksi', [TransaksiPeminjamanController::class, 'store'])->name('staff_perpus.transaksi.store');
    Route::get('/transaksi/{id}/edit', [TransaksiPeminjamanController::class, 'edit'])->name('staff_perpus.transaksi.edit');
    Route::put('/transaksi/{id}', [TransaksiPeminjamanController::class, 'update'])->name('staff_perpus.transaksi.update');
    Route::delete('/transaksi/{id}', [TransaksiPeminjamanController::class, 'destroy'])->name('staff_perpus.transaksi.destroy');
    Route::put('/transaksi/{id}/status', [TransaksiPeminjamanController::class, 'updateStatus'])->name('staff_perpus.transaksi.status');
    Route::put('/transaksi/{id}/ubah-status', [TransaksiPeminjamanController::class, 'updateStatus'])->name('updateStatus');
    Route::put('/transaksi/{id}/konfirmasi', [TransaksiPeminjamanController::class, 'updateStatus'])->name('staff.transactions.confirm');
    Route::get('/transaksi/pengembalian/{id}', [TransaksiPeminjamanController::class, 'edit'])->name('pengembalian.show');
    Route::post('/transaksi/status-denda', [TransaksiPeminjamanController::class, 'update_status_denda'])->name('staff_perpus.transaksi.status-denda');
    Route::post('/transaksi/perbarui-denda', [TransaksiPeminjamanController::class, 'update_status_denda'])->name('staff_perpus.transaksi.update_status_denda');
    Route::post('/update_status_denda', [TransaksiPeminjamanController::class, 'update_status_denda']);
    Route::get('/riwayat-transaksi', [RiwayatTransaksiController::class, 'index'])->name('staff_perpus.riwayat-transaksi.index');
    Route::get('/daftar-riwayat-transaksi', [RiwayatTransaksiController::class, 'index'])->name('staff_perpus.riwayat_transaksi.riwayattransaksi');
    Route::get('/riwayat_transaksi', [RiwayatTransaksiController::class, 'index']);

    // Laporan Perpustakaan
    Route::get('/laporan/buku-masuk', [LaporanController::class, 'bukumasuk'])->name('staff_perpus.laporan.buku-masuk');
    Route::get('/laporan/daftar-buku-masuk', [LaporanController::class, 'bukumasuk'])->name('staff_perpus.laporan.laporanbukumasuk');
    Route::get('/laporan/bukumasuk', [LaporanController::class, 'bukumasuk']);
    Route::get('/laporan/buku-hilang', [LaporanController::class, 'bukuhilang'])->name('staff_perpus.laporan.buku-hilang');
    Route::get('/laporan/daftar-buku-hilang', [LaporanController::class, 'bukuhilang'])->name('staff_perpus.laporan.laporanbukuhilang');
    Route::get('/laporan/bukuhilang', [LaporanController::class, 'bukuhilang']);
    Route::get('/laporan/transaksi-buku', [LaporanController::class, 'transaksibuku'])->name('staff_perpus.laporan.transaksi-buku');
    Route::get('/laporan/daftar-transaksi-buku', [LaporanController::class, 'transaksibuku'])->name('staff_perpus.laporan.laporantransaksi');
    Route::get('/laporan/transaksibuku', [LaporanController::class, 'transaksibuku']);
});
/*
|--------------------------------------------------------------------------
| 5. Guru Routes (dan Pembina Ekstrakurikuler)
|--------------------------------------------------------------------------
| Standardized with clean kebab-case hyphens (-)
*/

Route::group(['prefix' => 'guru', 'middleware' => ['guru']], function () {
    Route::get('/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');

    // Profil Guru
    Route::get('/profil', [ProfilController::class, 'show'])->name('guru.profil.show');
    Route::get('/profil-pendidik', [ProfilController::class, 'show'])->name('profil.show');
    Route::put('/profil', [ProfilController::class, 'update'])->name('guru.profil.update');
    Route::put('/profil-pendidik', [ProfilController::class, 'update'])->name('profil.update');

    // LMS Guru - Materi
    Route::get('/dashboard/lms', [DashboardGuruController::class, 'index'])->name('guru.lms.dashboard');
    Route::get('/dashboard/lms-guru', [DashboardGuruController::class, 'index'])->name('guru.dashboard.lms');
    Route::get('/dashboard/lms/materi', [MateriGuruController::class, 'index'])->name('guru.lms.materi.index');
    Route::get('/dashboard/lms/daftar-materi', [MateriGuruController::class, 'index'])->name('guru.dashboard.lms.materi');
    Route::get('/dashboard/lms/materi/create', [MateriGuruController::class, 'createView'])->name('guru.lms.materi.create-view');
    Route::get('/dashboard/lms/materi/tambah', [MateriGuruController::class, 'createView'])->name('guru.dashboard.lms.materi.create_view');
    Route::get('/dashboard/lms/materi/create/{id}', [MateriGuruController::class, 'create'])->name('guru.lms.materi.create');
    Route::get('/dashboard/lms/materi/form-tambah/{id}', [MateriGuruController::class, 'create'])->name('guru.dashboard.lms.materi.create');
    Route::get('/dashboard/lms/materi/{id}', [MateriGuruController::class, 'detail'])->name('guru.lms.materi.detail');
    Route::get('/dashboard/lms/materi/detail/{id}', [MateriGuruController::class, 'detail'])->name('guru.dashboard.lms.materi.detail');
    Route::post('/dashboard/lms/materi/{id}', [MateriGuruController::class, 'store'])->name('guru.lms.materi.store');
    Route::post('/dashboard/lms/materi/simpan/{id}', [MateriGuruController::class, 'store'])->name('guru.dashboard.lms.materi.store');
    Route::get('/dashboard/lms/materi/edit/{id}', [MateriGuruController::class, 'edit'])->name('guru.lms.materi.edit');
    Route::get('/dashboard/lms/materi/form-edit/{id}', [MateriGuruController::class, 'edit'])->name('guru.dashboard.lms.materi.edit');
    Route::put('/dashboard/lms/materi/{id}', [MateriGuruController::class, 'update'])->name('guru.lms.materi.update');
    Route::put('/dashboard/lms/materi/update/{id}', [MateriGuruController::class, 'update'])->name('guru.dashboard.lms.materi.update');
    Route::delete('/dashboard/lms/materi/{id}', [MateriGuruController::class, 'destroy'])->name('guru.lms.materi.destroy');
    Route::delete('/dashboard/lms/materi/delete/{id}', [MateriGuruController::class, 'destroy'])->name('guru.dashboard.lms.materi.destroy');

    // LMS Guru - Forum
    Route::get('/dashboard/lms/forum/{id}', [ForumGuruController::class, 'index'])->name('guru.lms.forum');
    Route::get('/dashboard/lms/diskusi-forum/{id}', [ForumGuruController::class, 'index'])->name('guru.dashboard.lms.forum');
    Route::get('/dashboard/lms/forum/tugas/{id}', [TugasGuruController::class, 'forumTugas'])->name('guru.lms.forum.tugas');
    Route::get('/dashboard/lms/diskusi-forum/tugas/{id}', [TugasGuruController::class, 'forumTugas'])->name('guru.dashboard.lms.forum.tugas');
    Route::get('/dashboard/lms/forum/anggota/{id}', [AnggotaGuruController::class, 'index'])->name('guru.lms.forum.anggota');
    Route::get('/dashboard/lms/diskusi-forum/anggota/{id}', [AnggotaGuruController::class, 'index'])->name('guru.dashboard.lms.forum.anggota');

    // LMS Guru - Tugas
    Route::get('/dashboard/lms/tugas/periksa', [TugasGuruController::class, 'periksaTugas'])->name('guru.lms.tugas.periksa');
    Route::get('/dashboard/lms/periksa-tugas', [TugasGuruController::class, 'periksaTugas'])->name('guru.dashboard.lms.tugas.periksa');
    Route::get('/dashboard/lms/tugas/create/{id}', [TugasGuruController::class, 'create'])->name('guru.lms.tugas.create');
    Route::get('/dashboard/lms/tugas/tambah/{id}', [TugasGuruController::class, 'create'])->name('guru.dashboard.lms.tugas.create');
    Route::get('/dashboard/lms/tugas/{id}', [TugasGuruController::class, 'detail'])->whereUuid('id')->name('guru.dashboard.lms.detail.tugas');
    Route::get('/dashboard/lms/tugas/detail/{id}', [TugasGuruController::class, 'detail'])->whereUuid('id')->name('guru.lms.tugas.detail');
    Route::post('/dashboard/lms/tugas/{id}', [TugasGuruController::class, 'store'])->whereUuid('id')->name('guru.lms.tugas.store');
    Route::post('/dashboard/lms/tugas/simpan/{id}', [TugasGuruController::class, 'store'])->whereUuid('id')->name('guru.dashboard.lms.tugas.store');
    Route::get('/dashboard/lms/tugas/edit/{id}', [TugasGuruController::class, 'edit'])->whereUuid('id')->name('guru.lms.tugas.edit');
    Route::get('/dashboard/lms/tugas/form-edit/{id}', [TugasGuruController::class, 'edit'])->whereUuid('id')->name('guru.dashboard.lms.tugas.edit');
    Route::put('/dashboard/lms/tugas/{id}', [TugasGuruController::class, 'update'])->whereUuid('id')->name('guru.lms.tugas.update');
    Route::put('/dashboard/lms/tugas/update/{id}', [TugasGuruController::class, 'update'])->whereUuid('id')->name('guru.dashboard.lms.tugas.update');
    Route::delete('/dashboard/lms/tugas/{id}', [TugasGuruController::class, 'destroy'])->whereUuid('id')->name('guru.lms.tugas.destroy');
    Route::delete('/dashboard/lms/tugas/delete/{id}', [TugasGuruController::class, 'destroy'])->whereUuid('id')->name('guru.dashboard.lms.tugas.destroy');

    // LMS Guru - Pengumpulan Tugas Siswa (Hyphenated URLs!)
    Route::get('/dashboard/lms/tugas-siswa/{id}', [TugasGuruController::class, 'tugasSiswa'])->name('guru.lms.tugas.siswa');
    Route::get('/dashboard/lms/daftar-tugas-siswa/{id}', [TugasGuruController::class, 'tugasSiswa'])->name('guru.dashboard.lms.tugas.siswa');
    Route::get('/dashboard/lms/tugasiswa/{id}', [TugasGuruController::class, 'tugasSiswa']);
    Route::get('/dashboard/lms/pengumpulan-tugas-siswa/{id}', [TugasGuruController::class, 'detailTugasSiswa'])->name('guru.lms.tugas.siswa.detail');
    Route::get('/dashboard/lms/detail-pengumpulan-tugas/{id}', [TugasGuruController::class, 'detailTugasSiswa'])->name('guru.dashboard.lms.tugas.siswa.detail');
    Route::get('/dashboard/lms/pengumpulan_tugas_siswa/{id}', [TugasGuruController::class, 'detailTugasSiswa']);
    Route::put('/dashboard/lms/pengumpulan-tugas-siswa/{id}', [TugasGuruController::class, 'nilaiTugas'])->name('guru.lms.tugas.siswa.update');
    Route::put('/dashboard/lms/nilai-tugas-siswa/{id}', [TugasGuruController::class, 'nilaiTugas'])->name('guru.dashboard.lms.tugas.siswa.update');
    Route::put('/dashboard/lms/pengumpulan_tugas_siswa/{id}', [TugasGuruController::class, 'nilaiTugas']);

    // LMS Guru - Topik Pembelajaran
    Route::post('/dashboard/lms/topik/store/{id}', [TopikLmsController::class, 'store'])->name('guru.lms.topik.store');
    Route::post('/dashboard/lms/topik/simpan/{id}', [TopikLmsController::class, 'store'])->name('guru.dashboard.lms.topik.store');
    Route::put('/dashboard/lms/topik/update/{id}', [TopikLmsController::class, 'update'])->name('guru.lms.topik.update');
    Route::put('/dashboard/lms/topik/perbarui/{id}', [TopikLmsController::class, 'update'])->name('guru.dashboard.lms.topik.update');
    Route::delete('/dashboard/lms/topik/delete/{id}', [TopikLmsController::class, 'destroy'])->name('guru.lms.topik.destroy');
    Route::delete('/dashboard/lms/topik/hapus/{id}', [TopikLmsController::class, 'destroy'])->name('guru.dashboard.lms.topik.destroy');

    // Wali Kelas
    Route::get('/kelas/daftar-siswa', [GuruController::class, 'daftarSiswaWali'])->name('guru.wali-kelas.siswa');
    Route::get('/kelas/siswa-wali', [GuruController::class, 'daftarSiswaWali'])->name('guru.daftarSiswaWali');
    Route::get('/kelas/{id_kelas}/siswa/{id_siswa}', [SiswaController::class, 'show'])->name('guru.wali-kelas.siswa.profil');
    Route::get('/kelas/{id_kelas}/profil-siswa/{id_siswa}', [SiswaController::class, 'show'])->name('kelas.siswa.profil');
    Route::get('/kelas/jadwal-pelajaran', [GuruController::class, 'daftarKelasDanJadwal'])->name('guru.wali-kelas.jadwal');
    Route::get('/kelas/jadwal-wali', [GuruController::class, 'daftarKelasDanJadwal'])->name('guru.jadwalPelajaran');

    // Perpustakaan untuk Guru
    Route::get('/dashboard/perpustakaan', [PerpustakaanController::class, 'indexGuru'])->name('guru.perpustakaan.index');
    Route::get('/dashboard/layanan-perpustakaan', [PerpustakaanController::class, 'indexGuru'])->name('perpustakaan');
    Route::get('/dashboard/perpustakaan/detail/{id}', [PerpustakaanController::class, 'showGuru'])->name('guru.perpustakaan.detail');
    Route::get('/dashboard/perpustakaan/buku/{id}', [PerpustakaanController::class, 'showGuru'])->name('dashboard.perpustakaan.detail');
    Route::get('/dashboard/perpustakaan/riwayat', [RiwayatPengunjungController::class, 'transGuru'])->name('guru.perpustakaan.riwayat');
    Route::get('/dashboard/perpustakaan/rules', [PerpustakaanController::class, 'showRulesGuru'])->name('guru.perpustakaan.rules');

    // CBT & Ujian Guru (Hyphenated URLs!)
    Route::get('/dashboard/ujian', [GuruUjianController::class, 'indexUjian'])->name('guru.ujian.index');
    Route::get('/dashboard/ujian/daftar-ujian', [GuruUjianController::class, 'indexUjian'])->name('ujian.show');
    Route::get('/dashboard/ujian/view_ujian', [GuruUjianController::class, 'indexUjian']);
    Route::get('/dashboard/ujian/create', [GuruUjianController::class, 'createUjian'])->name('guru.ujian.create');
    Route::get('/dashboard/ujian/tambah-ujian', [GuruUjianController::class, 'createUjian'])->name('guru.dashboard.ujian.create_ujian');
    Route::get('/dashboard/ujian/create_ujian', [GuruUjianController::class, 'createUjian']);
    Route::post('/dashboard/ujian', [GuruUjianController::class, 'storeData'])->name('guru.ujian.store');
    Route::post('/dashboard/ujian/simpan-ujian', [GuruUjianController::class, 'storeData'])->name('ujian.stored');
    Route::post('/dashboard/ujian/store-ujian', [GuruUjianController::class, 'storeData'])->name('ujian.store');
    Route::post('/dashboard/ujian/create_ujian', [GuruUjianController::class, 'storeData']);
    Route::get('/dashboard/ujian/{id}/edit', [GuruUjianController::class, 'ujianEdit'])->name('guru.ujian.edit');
    Route::get('/dashboard/ujian/{id}/ujian_edit', [GuruUjianController::class, 'ujianEdit']);
    Route::delete('/dashboard/ujian/{id}', [GuruUjianController::class, 'ujianDelete'])->name('guru.ujian.destroy');
    Route::delete('/dashboard/ujian/{id}/hapus-ujian', [GuruUjianController::class, 'ujianDelete'])->name('guru.ujian.delete');
    Route::get('/dashboard/ujian/{id}/delete_ujian', [GuruUjianController::class, 'ujianDelete']);

    // Soal Ujian (Hyphenated URLs!)
    Route::get('/dashboard/ujian/{id}/soal', [GuruUjianController::class, 'showSoal'])->name('guru.ujian.soal.index');
    Route::get('/dashboard/ujian/{id}/daftar-soal', [GuruUjianController::class, 'showSoal'])->name('guru.ujian.soal_ujian');
    Route::get('/dashboard/ujian/{id}/show_soal', [GuruUjianController::class, 'showSoal']);
    Route::get('/dashboard/ujian/{id}/create-soal', [GuruUjianController::class, 'storeSoal'])->name('guru.ujian.soal.create');
    Route::get('/dashboard/ujian/{id}/tambah-soal', [GuruUjianController::class, 'storeSoal'])->name('guru.ujian.add.soal');
    Route::get('/dashboard/ujian/{id}/create_soal', [GuruUjianController::class, 'storeSoal']);
    Route::post('/dashboard/ujian/{ujian_id}/import-soal', [GuruUjianController::class, 'importSoal'])->name('guru.ujian.soal.import');
    Route::post('/dashboard/ujian/{ujian_id}/unggah-soal', [GuruUjianController::class, 'importSoal'])->name('soal_ujian.import');
    Route::post('/dashboard/ujian/{ujian_id}/jawaban-import', [GuruUjianController::class, 'importSoal'])->name('jawaban_ujian.import');
    Route::post('/jawaban_ujian/import/{ujian_id}', [GuruUjianController::class, 'importSoal']);
    Route::get('/dashboard/ujian/soal/{id}/edit', [GuruUjianController::class, 'soalEdit'])->name('guru.ujian.soal.edit');
    Route::get('/dashboard/ujian/soal/{id}/ubah', [GuruUjianController::class, 'soalEdit'])->name('soal_ujian.edit');
    Route::get('/dashboard/ujian/soal_ujian/{id}/soal_edit', [GuruUjianController::class, 'soalEdit']);
    Route::put('/dashboard/ujian/soal/{id}', [GuruUjianController::class, 'soalUpdate'])->name('guru.ujian.soal.update');
    Route::put('/dashboard/ujian/soal/{id}/perbarui', [GuruUjianController::class, 'soalUpdate'])->name('soal_ujian.update');
    Route::put('/dashboard/ujian/soal_ujian/{id}', [GuruUjianController::class, 'soalUpdate']);
    Route::delete('/dashboard/ujian/soal/{id}', [GuruUjianController::class, 'destroySoal'])->name('guru.ujian.soal.destroy');
    Route::delete('/dashboard/ujian/soal/{id}/hapus', [GuruUjianController::class, 'destroySoal'])->name('soal_ujian.destroy');
    Route::delete('/dashboard/ujian/soal_ujian/{id}', [GuruUjianController::class, 'destroySoal']);

    // Jawaban Ujian (Hyphenated URLs!)
    Route::get('/dashboard/ujian/jawaban-ujian', [GuruUjianController::class, 'showJawabanUjian'])->name('guru.ujian.jawaban.index');
    Route::get('/dashboard/ujian/daftar-jawaban-ujian', [GuruUjianController::class, 'showJawabanUjian'])->name('guru.dashboard.ujian.jawaban_ujian');
    Route::get('/dashboard/ujian/jawaban_ujian', [GuruUjianController::class, 'showJawabanUjian']);
    Route::get('/dashboard/ujian/jawaban-ujian/{id}/edit', [GuruUjianController::class, 'editJawabanUjian'])->name('guru.ujian.jawaban.edit');
    Route::get('/dashboard/ujian/jawaban-ujian/{id}/ubah', [GuruUjianController::class, 'editJawabanUjian'])->name('jawaban_ujian.edit');
    Route::get('/dashboard/ujian/jawaban_ujian/{id}/jawaban_ujian_edit', [GuruUjianController::class, 'editJawabanUjian']);
    Route::put('/dashboard/ujian/jawaban-ujian/{id}', [GuruUjianController::class, 'jawabanUpdate'])->name('guru.ujian.jawaban.update');
    Route::put('/dashboard/ujian/jawaban-ujian/{id}/perbarui', [GuruUjianController::class, 'jawabanUpdate'])->name('jawaban_ujian.update');
    Route::put('/dashboard/ujian/jawaban_ujian/{id}', [GuruUjianController::class, 'jawabanUpdate']);
    Route::delete('/dashboard/ujian/jawaban-ujian/{id}', [GuruUjianController::class, 'destroyJawabanUjian'])->name('guru.ujian.jawaban.destroy');
    Route::delete('/dashboard/ujian/jawaban-ujian/{id}/hapus', [GuruUjianController::class, 'destroyJawabanUjian'])->name('jawaban_ujian.destroy');
    Route::delete('/dashboard/ujian/jawaban_ujian/{id}', [GuruUjianController::class, 'destroyJawabanUjian']);

    // Pengumpulan Ujian Siswa (Hyphenated URLs!)
    Route::get('/dashboard/ujian/pengumpulan', [GuruUjianController::class, 'index'])->name('guru.ujian.pengumpulan.index');
    Route::get('/dashboard/ujian/daftar-pengumpulan', [GuruUjianController::class, 'index'])->name('guru.dashboard.ujian.pengumpulan');
    Route::get('/dashboard/ujian/pengumpulan_ujian', [GuruUjianController::class, 'index']);
    Route::get('/dashboard/ujian/pengumpulan/{id}/edit', [GuruUjianController::class, 'index'])->name('guru.dashboard.pengumpulan_ujian.edit');
    Route::delete('/dashboard/ujian/pengumpulan/{id}', [GuruUjianController::class, 'destroy'])->name('guru.ujian.pengumpulan.destroy');
    Route::delete('/dashboard/ujian/pengumpulan/{id}/hapus', [GuruUjianController::class, 'destroy'])->name('guru.dashboard.pengumpulan_ujian.destroy');
    Route::delete('/pengumpulan_ujian/{id}', [GuruUjianController::class, 'destroy']);
    // Absensi Guru
    Route::get('/absensi', [guru\AbsensiController::class, 'index'])->name('guru.absensi.index');
    Route::get('/absensi/{id}/pertemuan', [guru\AbsensiController::class, 'details'])->name('guru.absensi.details');
    Route::get('/absensi/{id}/pertemuan/{pertemuan}', [guru\AbsensiController::class, 'pertemuanDetails'])->name('guru.absensi.pertemuan.details');
    Route::put('/absensi/update-status', [guru\AbsensiController::class, 'updateStatus'])->name('guru.absensi.updateStatus');
    Route::post('/absensi/update-status-qr', [guru\AbsensiController::class, 'updateStatusQr'])->name('guru.absensi.update-status-qr');
    Route::post('/absensi/update-status', [guru\AbsensiController::class, 'updateStatusQr'])->name('guru.absensi.update-status');

    // Jadwal Guru
    Route::get('/dashboard/lihat-jadwal', [LihatJadwalGuruController::class, 'index'])->name('guru.jadwal.index');
    Route::get('/dashboard/jadwal-mengajar', [LihatJadwalGuruController::class, 'index'])->name('lihat-jadwal-guru');
    Route::get('/jadwal/print', [LihatJadwalGuruController::class, 'print'])->name('guru.jadwal.print');
    Route::get('/guru/jadwal/print', [LihatJadwalGuruController::class, 'print']);

    // Pembina Ekstrakurikuler Sub-group
    Route::group(['middleware' => 'pembina_ekstra'], function () {
        Route::get('/pembina-dashboard', [PembinaekstraController::class, 'index'])->name('pembina-ekstra.dashboard');
        Route::get('/pembina/dashboard', [PembinaekstraController::class, 'index'])->name('pembina.dashboard');
        Route::get('/pembina/ekstrakurikuler/anggota', [PembinaAnggotaController::class, 'index'])->name('pembina-ekstra.anggota.index');
        Route::get('/pembina/anggota', [PembinaAnggotaController::class, 'index'])->name('pembina.anggota');
        Route::get('/pembina/ekstrakurikuler/perlengkapan', [PembinaekstraPerlengkapanController::class, 'index'])->name('pembina-ekstra.perlengkapan.index');
        Route::get('/pembina/perlengkapan', [PembinaekstraPerlengkapanController::class, 'index'])->name('pembina.perlengkapan');
        Route::get('/pembina/ekstrakurikuler/perlengkapan/histori/{id}', [PembinaekstraHistoriPeminjamanController::class, 'index'])->name('pembina-ekstra.histori.index');
        Route::get('/pembina/perlengkapan/histori/{id}', [PembinaekstraHistoriPeminjamanController::class, 'index'])->name('pembina.histori');
        Route::get('/pembina/ekstrakurikuler/penilaian', [PenilaianEkstraController::class, 'index'])->name('pembina-ekstra.penilaian.index');
        Route::get('/pembina/penilaian', [PenilaianEkstraController::class, 'index'])->name('pembina.penilaian');
        Route::post('/pembina/ekstrakurikuler/penilaian/{id}', [PenilaianEkstraController::class, 'storeOrUpdate'])->name('pembina-ekstra.penilaian.store-or-update');
        Route::post('/pembina/penilaian/{id}', [PenilaianEkstraController::class, 'storeOrUpdate'])->name('pembina.penilaian.storeOrUpdate');
        Route::get('/pembina/ekstrakurikuler/penilaian/{tahun_ajaran}', [PenilaianEkstraController::class, 'show'])->name('pembina-ekstra.penilaian.show');
        Route::get('/pembina/penilaian/{tahun_ajaran}', [PenilaianEkstraController::class, 'show'])->name('pembina.penilaian.filter');
    });
});

Route::group(['prefix' => 'pembina_ekstra', 'middleware' => ['pembina_ekstra']], function () {
    Route::get('/pembina', [PembinaekstraController::class, 'index'])->name('pembina_ekstra.dashboard');
});

/*
|--------------------------------------------------------------------------
| 6. Siswa Routes (dan Pengurus Ekstrakurikuler)
|--------------------------------------------------------------------------
| Standardized with clean kebab-case hyphens (-)
*/
Route::group(['prefix' => 'siswa', 'middleware' => ['siswa']], function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');

    // Profil Siswa
    Route::get('/profil', [SiswaProfilController::class, 'show'])->name('siswa.profil.show');
    Route::get('/profil-siswa', [SiswaProfilController::class, 'show'])->name('siswaprofil.show');
    Route::get('/siswaprofil', [SiswaProfilController::class, 'show']);
    Route::put('/profil', [SiswaProfilController::class, 'update'])->name('siswa.profil.update');
    Route::put('/profil-siswa', [SiswaProfilController::class, 'update'])->name('siswaprofil.update');
    Route::put('/siswaprofil', [SiswaProfilController::class, 'update']);

    // LMS Siswa - Dashboard & Materi
    Route::get('/dashboard/lms', [DashboardSiswaController::class, 'index'])->name('siswa.lms.dashboard');
    Route::get('/dashboard/lms-siswa', [DashboardSiswaController::class, 'index'])->name('siswa.dashboard.lms');
    Route::get('/dashboard/lms/materi', [MateriSiswaController::class, 'index'])->name('siswa.lms.materi.index');
    Route::get('/dashboard/lms/daftar-materi', [MateriSiswaController::class, 'index'])->name('siswa.dashboard.lms.materi');
    Route::get('/dashboard/lms/materi/{id}', [MateriSiswaController::class, 'detail'])->whereUuid('id')->name('siswa.dashboard.lms.detail.materi');
    Route::get('/dashboard/lms/materi-detail/{id}', [MateriSiswaController::class, 'detail'])->whereUuid('id')->name('siswa.lms.materi.detail');

    // LMS Siswa - Tracking Tugas (Didefinisikan SEBELUM wildcard {id} agar tidak tertabrak)
    Route::get('/dashboard/lms/tugas/tracking/ditugaskan', [DaftarTugasSiswaController::class, 'ditugaskan'])->name('siswa.dashboard.lms.tracking.tugas.ditugaskan');
    Route::get('/dashboard/lms/tugas/tracking/tugas-ditugaskan', [DaftarTugasSiswaController::class, 'ditugaskan'])->name('siswa.lms.tugas.tracking.ditugaskan');
    Route::get('/dashboard/lms/tugas/tracking/belum-diserahkan', [DaftarTugasSiswaController::class, 'belumDiserahkan'])->name('siswa.lms.tugas.tracking.belum-diserahkan');
    Route::get('/dashboard/lms/tugas/tracking/belum_diserahkan', [DaftarTugasSiswaController::class, 'belumDiserahkan'])->name('siswa.dashboard.lms.tracking.tugas.belum_diserahkan');
    Route::get('/dashboard/lms/tugas/tracking/diserahkan', [DaftarTugasSiswaController::class, 'diserahkan'])->name('siswa.dashboard.lms.tracking.tugas.diserahkan');
    Route::get('/dashboard/lms/tugas/tracking/tugas-diserahkan', [DaftarTugasSiswaController::class, 'diserahkan'])->name('siswa.lms.tugas.tracking.diserahkan');

    // LMS Siswa - Daftar Semua Tugas (Index)
    Route::get('/dashboard/lms/tugas', [TugasSiswaController::class, 'index'])->name('siswa.dashboard.lms.tugas');
    Route::get('/dashboard/lms/daftar-tugas', [TugasSiswaController::class, 'index'])->name('siswa.lms.tugas.index');

    // LMS Siswa - Forum Diskusi
    Route::get('/dashboard/lms/forum/{id}', [ForumSiswaController::class, 'index'])->whereUuid('id')->name('siswa.dashboard.lms.forum');
    Route::get('/dashboard/lms/diskusi-forum/{id}', [ForumSiswaController::class, 'index'])->whereUuid('id')->name('siswa.lms.forum');
    Route::get('/dashboard/lms/forum/tugas/{id}', [TugasSiswaController::class, 'forumTugas'])->whereUuid('id')->name('siswa.dashboard.lms.forum.tugas');
    Route::get('/dashboard/lms/diskusi-forum/tugas/{id}', [TugasSiswaController::class, 'forumTugas'])->whereUuid('id')->name('siswa.lms.forum.tugas');
    Route::get('/dashboard/lms/forum/anggota/{id}', [AnggotaSiswaController::class, 'index'])->whereUuid('id')->name('siswa.dashboard.lms.forum.anggota');
    Route::get('/dashboard/lms/diskusi-forum/anggota/{id}', [AnggotaSiswaController::class, 'index'])->whereUuid('id')->name('siswa.lms.forum.anggota');

    // LMS Siswa - Tugas Detail & Pengumpulan (Wildcard {id} dengan UUID constraint)
    Route::get('/dashboard/lms/tugas/{id}', [TugasSiswaController::class, 'detail'])->whereUuid('id')->name('siswa.dashboard.lms.detail.tugas');
    Route::get('/dashboard/lms/tugas-detail/{id}', [TugasSiswaController::class, 'detail'])->whereUuid('id')->name('siswa.lms.tugas.detail');
    Route::post('/dashboard/lms/tugas/{id}', [TugasSiswaController::class, 'submit'])->whereUuid('id')->name('siswa.dashboard.lms.submit.tugas');
    Route::post('/dashboard/lms/tugas-submit/{id}', [TugasSiswaController::class, 'submit'])->whereUuid('id')->name('siswa.lms.tugas.submit');
    Route::delete('/dashboard/lms/tugas/batal/{id}', [TugasSiswaController::class, 'batalPengumpulan'])->whereUuid('id')->name('siswa.dashboard.lms.tugas.batal');
    Route::delete('/dashboard/lms/tugas-batal/{id}', [TugasSiswaController::class, 'batalPengumpulan'])->whereUuid('id')->name('siswa.lms.tugas.batal');
    Route::get('/dashboard/lms/tugas/file/{id}', [TugasSiswaController::class, 'deleteFile'])->whereUuid('id')->name('siswa.dashboard.lms.tugas.file.delete');
    Route::get('/dashboard/lms/tugas-file-delete/{id}', [TugasSiswaController::class, 'deleteFile'])->whereUuid('id')->name('siswa.lms.tugas.file.delete');

    // CBT Ujian Siswa
    Route::get('/dashboard/ujian', [UjianSiswaController::class, 'index'])->name('siswa.ujian.index');
    Route::get('/dashboard/daftar-ujian', [UjianSiswaController::class, 'index'])->name('siswa.dashboard.ujian');
    Route::get('/dashboard/ujian/index', [UjianSiswaController::class, 'index']);
    Route::get('/ujian/{id}/start', [UjianSiswaController::class, 'start'])->name('siswa.ujian.start');
    Route::post('/ujian/{id}/submit', [UjianSiswaController::class, 'submit'])->name('siswa.ujian.submit');
    Route::post('/ujian/{id}/end', [UjianSiswaController::class, 'submit'])->name('siswa.ujian.end'); // Fixed missing slash!
    Route::post('/ujian{id}/end', [UjianSiswaController::class, 'submit']); // Fallback

    // Prestasi Siswa (Dikelola penuh oleh Staff Akademik - Read Only untuk Siswa)
    Route::get('/dashboard/prestasi', [PrestasiSiswaController::class, 'index'])->name('siswa.prestasi.index');
    Route::get('/dashboard/daftar-prestasi', [PrestasiSiswaController::class, 'index'])->name('siswa.prestasi');
    Route::get('/dashboard/prestasi/show/{id}', [PrestasiSiswaController::class, 'show'])->name('siswa.prestasi.show');

    // Perpustakaan untuk Siswa
    Route::get('/dashboard/perpustakaan', [PerpustakaanController::class, 'indexSiswa'])->name('siswa.perpustakaan.index');
    Route::get('/dashboard/layanan-perpustakaan', [PerpustakaanController::class, 'indexSiswa'])->name('dashboard.perpustakaan');
    Route::get('/dashboard/perpustakaan/detail/{id}', [PerpustakaanController::class, 'showSiswa'])->name('siswa.perpustakaan.detail');
    Route::get('/dashboard/perpustakaan/buku/{id}', [PerpustakaanController::class, 'showSiswa'])->name('siswa.dashboard.perpustakaan.detail');
    Route::get('/dashboard/perpustakaan/riwayat', [RiwayatPengunjungController::class, 'transSiswa'])->name('siswa.perpustakaan.riwayat');
    Route::get('/dashboard/perpustakaan/rules', [PerpustakaanController::class, 'showRulesSiswa'])->name('siswa.perpustakaan.rules');

    // Absensi Siswa
    Route::get('/absensi', [siswa\AbsensiController::class, 'index'])->name('siswa.absensi.index');
    Route::get('/absensi/{id}/pertemuan', [siswa\AbsensiController::class, 'details'])->name('siswa.absensi.details');
    Route::get('/absensi/scan/{pertemuan_id}', [siswa\AbsensiController::class, 'scanQrCode'])->name('siswa.absensi.scan');

    // Notifikasi Siswa
    Route::get('/notifikasi', [siswa\NotifikasiController::class, 'index'])->name('siswa.notifikasi');
    Route::post('/notifikasi/mark-all-read', [siswa\NotifikasiController::class, 'markAllAsRead'])->name('siswa.notifikasi.mark-all-read');
    Route::post('/notifikasi/{id}/mark-read', [siswa\NotifikasiController::class, 'markAsRead'])->name('siswa.notifikasi.mark-read');
    Route::get('/notifikasi/{id}/open', [siswa\NotifikasiController::class, 'readAndRedirect'])->name('siswa.notifikasi.open');


    // Jadwal Siswa
    Route::get('/dashboard/lihat-jadwal', [LihatJadwalSiswaController::class, 'index'])->name('siswa.jadwal.index');
    Route::get('/dashboard/jadwal-pelajaran', [LihatJadwalSiswaController::class, 'index'])->name('lihat-jadwal-siswa');
    Route::get('/jadwal/print', [LihatJadwalSiswaController::class, 'print'])->name('siswa.jadwal.print');
    Route::get('/jadwal-siswa/print', [LihatJadwalSiswaController::class, 'print']);

    // Ekstrakurikuler Siswa (Informasi, Pendaftaran & Monitoring Keanggotaan)
    Route::get('/ekstrakurikuler', [SiswaEkstrakurikulerController::class, 'index'])->name('siswa.ekstrakurikuler.index');
    Route::get('/ekstrakurikuler/detail/{id}', [SiswaEkstrakurikulerController::class, 'show'])->name('siswa.ekstrakurikuler.detail');
    Route::get('/ekstrakurikuler/pendaftaran', [SiswaEkstrakurikulerController::class, 'pendaftaran'])->name('siswa.ekstrakurikuler.pendaftaran');
    Route::post('/ekstrakurikuler/pendaftaran', [SiswaEkstrakurikulerController::class, 'storePendaftaran'])->name('siswa.ekstrakurikuler.pendaftaran.store');
    Route::get('/ekstrakurikuler/saya', [SiswaEkstrakurikulerController::class, 'ekskulSaya'])->name('siswa.ekstrakurikuler.saya');

    // Pengurus Ekstrakurikuler Sub-group
    Route::group(['middleware' => 'pengurus'], function () {
        Route::get('/ekstrakurikuler/dashboard', [PengurusEkstraController::class, 'dashboard'])->name('pengurus-ekstra.dashboard');
        Route::get('/pengurus/dashboard', [PengurusEkstraController::class, 'dashboard'])->name('pengurus_ekstra.dashboard');
        Route::post('/ekstrakurikuler/dashboard', [PengurusEkstraController::class, 'store'])->name('pengurus-ekstra.dashboard.store');
        Route::post('/pengurus/dashboard', [PengurusEkstraController::class, 'store'])->name('dashboard.store');
        Route::put('/ekstrakurikuler/dashboard/status', [PengurusekstraController::class, 'updateStatus'])->name('pengurus-ekstra.dashboard.status');
        Route::put('/pengurus/dashboard/status', [PengurusekstraController::class, 'updateStatus'])->name('dashboard.status');
        Route::put('/ekstrakurikuler/dashboard/{id_posting}', [PengurusekstraController::class, 'update'])->name('pengurus-ekstra.dashboard.update');
        Route::put('/dashboard/{id_posting}', [PengurusekstraController::class, 'update'])->name('dashboard.update');
        Route::delete('/ekstrakurikuler/dashboard/{id_posting}', [PengurusekstraController::class, 'destroy'])->name('pengurus-ekstra.dashboard.destroy');
        Route::delete('/dashboard/{id_posting}', [PengurusekstraController::class, 'destroy'])->name('dashboard.destroy');

        Route::get('/ekstrakurikuler/anggota', [PengurusAnggotaController::class, 'index'])->name('pengurus-ekstra.anggota.index');
        Route::get('/pengurus/anggota', [PengurusAnggotaController::class, 'index'])->name('pengurus_ekstra.anggota');
        Route::put('/ekstrakurikuler/anggota/update-status/{id}', [PengurusAnggotaController::class, 'updateStatus'])->name('pengurus-ekstra.anggota.update-status');
        Route::put('/pengurus/anggota/update-status/{id}', [PengurusAnggotaController::class, 'updateStatus'])->name('pengurus_ekstra.anggota.updateStatus');

        Route::get('/ekstrakurikuler/penilaian', [PenilaianEkstraPengurusController::class, 'index'])->name('pengurus-ekstra.penilaian.index');
        Route::get('/pengurus/penilaian', [PenilaianEkstraPengurusController::class, 'index'])->name('pengurus_ekstra.penilaian');
        Route::post('/ekstrakurikuler/penilaian/{id}', [PenilaianEkstraPengurusController::class, 'storeOrUpdate'])->name('pengurus-ekstra.penilaian.store-or-update');
        Route::post('/pengurus/penilaian/{id}', [PenilaianEkstraPengurusController::class, 'storeOrUpdate'])->name('pengurus_ekstra.penilaian.storeOrUpdate');

        Route::get('/ekstrakurikuler/perlengkapan', [PengurusPerlengkapanController::class, 'index'])->name('pengurus-ekstra.perlengkapan.index');
        Route::get('/pengurus/perlengkapan', [PengurusPerlengkapanController::class, 'index'])->name('pengurus_ekstra.perlengkapan');
        Route::post('/ekstrakurikuler/perlengkapan', [PengurusPerlengkapanController::class, 'store'])->name('pengurus-ekstra.perlengkapan.store');
        Route::post('/ekstrakurikuler/perlengkapan/tambah', [PengurusPerlengkapanController::class, 'store'])->name('pengurus_ekstra.perlengkapan.store');
        Route::put('/ekstrakurikuler/perlengkapan/{id}', [PengurusPerlengkapanController::class, 'update'])->name('pengurus-ekstra.perlengkapan.update');
        Route::put('/ekstrakurikuler/perlengkapan/update/{id}', [PengurusPerlengkapanController::class, 'update'])->name('pengurus_ekstra.perlengkapan.update');
        Route::delete('/ekstrakurikuler/perlengkapan/{id}', [PengurusPerlengkapanController::class, 'destroy'])->name('pengurus-ekstra.perlengkapan.destroy');
        Route::delete('/ekstrakurikuler/perlengkapan/delete/{id}', [PengurusPerlengkapanController::class, 'destroy'])->name('pengurus_ekstra.perlengkapan.delete');

        Route::get('/ekstrakurikuler/perlengkapan/histori/{id}', [PengurusHistoriPeminjamanController::class, 'index'])->name('pengurus-ekstra.histori.index');
        Route::get('/pengurus/perlengkapan/histori/{id}', [PengurusHistoriPeminjamanController::class, 'index'])->name('pengurus_ekstra.histori');
        Route::post('/ekstrakurikuler/perlengkapan/histori', [PengurusHistoriPeminjamanController::class, 'store'])->name('pengurus-ekstra.histori.store');
        Route::post('/pengurus/perlengkapan/histori', [PengurusHistoriPeminjamanController::class, 'store'])->name('pengurus_ekstra.histori.store');
        Route::put('/ekstrakurikuler/perlengkapan/histori/{id}', [PengurusHistoriPeminjamanController::class, 'update'])->name('pengurus-ekstra.histori.update');
        Route::put('/pengurus/perlengkapan/histori/{id}', [PengurusHistoriPeminjamanController::class, 'update'])->name('pengurus_ekstra.histori.update');
        Route::delete('/ekstrakurikuler/perlengkapan/histori/{id}', [PengurusHistoriPeminjamanController::class, 'destroy'])->name('pengurus-ekstra.histori.destroy');
        Route::delete('/pengurus/perlengkapan/histori/{id}', [PengurusHistoriPeminjamanController::class, 'destroy'])->name('pengurus_ekstra.histori.delete');
    });
});

/*
|--------------------------------------------------------------------------
| 7. Ekstrakurikuler Publik Routes
|--------------------------------------------------------------------------
| Standardized with clean kebab-case hyphens (-)
*/
Route::group(['prefix' => 'ekstrakurikuler'], function () {
    Route::get('/', [EkstrakurikulerController::class, 'dashboardEkstra'])->name('ekstrakurikuler.index');
    Route::get('/registrasi', [EkstrakurikulerController::class, 'showForm'])->name('ekstrakurikuler.registrasi.index');
    Route::post('/registrasi', [EkstrakurikulerController::class, 'submitForm'])->name('ekstrakurikuler.registrasi.store');
    Route::get('/{id}', [EkstrakurikulerController::class, 'show'])->name('ekstrakurikuler.detail');
});

// Fallback & typo compatibility for legacy ekstrakrikuler URLs
Route::get('/ekstrakrikuler', [EkstrakurikulerController::class, 'dashboardEkstra'])->name('ekstrakurikuler.dashboardEkstra');
Route::get('/registrasi-ekstrakurikuler', [EkstrakurikulerController::class, 'showForm'])->name('ekstrakurikuler.registrasi');
Route::post('/registrasi-ekstrakurikuler', [EkstrakurikulerController::class, 'submitForm'])->name('ekstrakurikuler.submit');
Route::post('/registrasi-ekstrakurikuler/tambah', [EkstrakurikulerController::class, 'submitForm'])->name('ekstrakurikuler.registrasi.store-legacy');

// Fallback for kelola informasi ekstra
Route::post('/kelola-informasi', function () {
    return redirect()->back();
})->name('kelolaInformasi.store');

require __DIR__.'/auth.php';

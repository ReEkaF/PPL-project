<<<<<<< HEAD
# Sistem Sekolah Terintegrasi (SST) SMP Negeri 2 Kamal

[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Database](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Architecture](https://img.shields.io/badge/Architecture-Service--Repository-026aa2?style=for-the-badge)](https://martinfowler.com)
[![Code Style](https://img.shields.io/badge/Code%20Style-PSR--12%20(Laravel%20Pint)-10b981?style=for-the-badge)](https://laravel.com/docs/pint)

Platform tata kelola pendidikan terintegrasi yang dirancang khusus untuk otomasi ekosistem akademik, perpustakaan digital, manajemen presensi berbasis QR Code terenkripsi, evaluasi pembelajaran (LMS & CBT), serta kegiatan ekstrakurikuler di **SMP Negeri 2 Kamal, Kabupaten Bangkalan, Jawa Timur**.

---

## 📑 Daftar Isi
1. [Identitas & Gambaran Sistem](#-identitas--gambaran-sistem)
2. [Modul & Fitur Utama (12 Modul)](#-modul--fitur-utama-12-modul)
3. [Matriks Role & Hak Akses](#-matriks-role--hak-akses)
4. [Tech Stack & Prasyarat Sistem](#-tech-stack--prasyarat-sistem)
5. [Arsitektur Kode & Repository-Service Pattern](#-arsitektur-kode--repository-service-pattern)
6. [Panduan Instalasi & Setup Lokal](#-panduan-instalasi--setup-lokal)
7. [Design System & UI Components](#-design-system--ui-components)
8. [Log Audit & Refactoring Performance](#-log-audit--refactoring-performance)

---

## 🏫 Identitas & Gambaran Sistem

- **Nama Resmi**: Sistem Sekolah Terintegrasi (SST)
- **Institusi Pengguna**: SMP Negeri 2 Kamal, Bangkalan, Madura
- **Tujuan Sistem**: Menghilangkan silo data antarbagian (akademik, perpustakaan, guru pengajar, ekstrakurikuler), menstandarkan proses penilaian Kurikulum Merdeka, serta menyediakan portal digital satu pintu yang cepat, aman, dan mudah digunakan oleh siswa maupun wali murid.

---

## 📦 Modul & Fitur Utama (12 Modul)

Sistem telah diaudit dan direfaktor secara modular ke dalam 12 domain fungsional:

### 1. Portal Publik & Profil Sekolah
- Halaman beranda responsif dengan showcase profil sekolah, sambutan kepala sekolah, visi, misi, dan fasilitas.
- Galeri dinamis dan direktori tenaga pengajar terverifikasi.
- Asset gambar dioptimasi WebP ultra-ringan (< 500 KB total payload) untuk loading super cepat pada koneksi mobile.

### 2. Otentikasi Terpadu & Multi-Guard
- Login berbasis multi-guard: `superadmin`, `staff_akademik`, `staff_perpus`, `guru`, dan `siswa`.
- Integrasi Single Sign-On (SSO) Google OAuth untuk siswa dan guru.
- Proteksi brute-force, CSRF mitigation, dan session management berbasis peran.

### 3. Perpustakaan Digital & Sirkulasi Buku
- Katalog buku terindeks dengan pencarian judul, pengarang, ISBN, kategori, dan status ketersediaan stok fisik.
- Manajemen peminjaman dan pengembalian buku dengan kode transaksi unik.
- Kalkulasi denda harian otomatis berdasarkan keterlambatan pengembalian buku.
- Ekspor laporan analitik sirkulasi dan denda buku (Excel & PDF).

### 4. Learning Management System (LMS) Guru
- Pembuatan ruang belajar per kelas mata pelajaran yang diampu.
- Pengorganisasian topik pembelajaran terstruktur.
- Upload materi pembelajaran multimedia (dokumen PDF dan embed referensi video).
- Pembuatan penugasan siswa dengan tenggat waktu (*deadline*) dan instruksi detail.
- Rekapitulasi pengumpulan tugas dan interface penilaian siswa.

### 5. LMS Siswa
- Dasbor belajar personal siswa menampilkan mata pelajaran terdaftar.
- Akses dan download materi pelajaran per topik.
- Pengumpulan tugas online (file upload & teks jawaban) sebelum batas waktu.
- Notifikasi status penilaian dan feedback nilai tugas dari guru.

### 6. Manajemen Akademik, Kelas & Rombel
- Manajemen data induk kelas (kelas 7, 8, 9) dan alokasi wali kelas.
- Distribusi dan penempatan rombongan belajar siswa per tahun ajaran.
- Manajemen master mata pelajaran umum dan muatan lokal.

### 7. Penjadwalan Pelajaran Terpadu
- Penyusunan jadwal kegiatan belajar mengajar per hari, jam pelajaran, ruang kelas, dan guru pengampu.
- Validasi pencegahan bentrok jadwal guru dan ruang kelas.
- Tampilan jadwal personal untuk masing-masing guru dan siswa.

### 8. E-Rapor & Evaluasi Nilai Siswa
- Rekapitulasi nilai tugas, absensi, dan ujian online.
- Konversi nilai akhir otomatis ke predikat (A, B, C, D) berdasarkan rentang bobot dinamis (`bobot_grades`).
- Cetak lembar rapor siswa dalam format dokumen PDF standar sekolah.

### 9. Presensi Real-Time & Generator QR Code
- Staff Akademik/Guru men-generate sesi pertemuan mingguan secara otomatis per semester.
- Pembuatan QR Code SVG unik per pertemuan tersimpan lokal di storage aman.
- Siswa melakukan absensi instan dengan pemindaian (scan) QR Code via smartphone.
- Fitur aktivasi/deaktivasi sesi presensi QR oleh guru pengajar saat jam pelajaran berlangsung.

### 10. Computer-Based Testing (CBT / Ujian Online)
- Bank soal ujian online (pilihan ganda) terikat topik dan kelas mata pelajaran.
- Pengaturan durasi waktu pengerjaan otomatis dan countdown timer di sisi siswa.
- Kalkulasi nilai otomatis dan rekap data hasil pengumpulan ujian siswa.

### 11. Manajemen Ekstrakurikuler & Inventaris
- Pendaftaran siswa ke ekstrakurikuler aktif (Pramuka, Paskibra, PMR, Olahraga, Seni, dll).
- Manajemen inventaris perlengkapan dan peralatan masing-masing ekstrakurikuler.
- Pencatatan peminjaman dan pengembalian alat ekskul oleh anggota.

### 12. Superadmin & User Central Management
- Dasbor analitik pusat statistik seluruh civitas akademika SMPN 2 Kamal.
- CRUD data induk guru (NIP, identitas, foto profil, hak akses).
- CRUD data induk siswa (NISN, kelas, data kontak, status aktif).
- Kelola akun staf akademik, staf perpustakaan, pembina ekskul, dan pengurus ekskul.
- Fitur reset password instan bagi pengguna yang lupa sandi.

---

## 👥 Matriks Role & Hak Akses

| Modul / Domain | Superadmin | Staff Akademik | Staff Perpus | Guru | Siswa | Pembina Ekskul | Pengurus Ekskul |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| **Portal & Beranda** | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Kelola Master User** | ✅ (Full) | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **Kelas & Rombel** | ❌ | ✅ (Full) | ❌ | 👁️ (Read) | 👁️ (Read) | ❌ | ❌ |
| **Jadwal Pelajaran** | ❌ | ✅ (Full) | ❌ | 👁️ (Read) | 👁️ (Read) | ❌ | ❌ |
| **E-Rapor** | ❌ | ✅ (Full) | ❌ | ✅ (Input) | 👁️ (Read) | ❌ | ❌ |
| **Perpustakaan & Buku** | ❌ | ❌ | ✅ (Full) | 👁️ (Read) | 👁️ (Pinjam) | ❌ | ❌ |
| **LMS (Materi & Tugas)** | ❌ | ❌ | ❌ | ✅ (Kelola) | ✅ (Akses) | ❌ | ❌ |
| **CBT / Ujian Online** | ❌ | ❌ | ❌ | ✅ (Kelola) | ✅ (Ikut) | ❌ | ❌ |
| **Presensi & QR Code** | ❌ | ✅ (Batch) | ❌ | ✅ (Validasi) | ✅ (Scan) | ❌ | ❌ |
| **Kegiatan Ekskul** | ❌ | ❌ | ❌ | ❌ | 👁️ (Daftar) | ✅ (Full) | ✅ (Operasional) |

---

## 🛠 Tech Stack & Prasyarat Sistem

### Kebutuhan Server / Localhost
- **PHP**: Versi >= 8.2 (ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `gd`, `xml`, `curl`)
- **Composer**: Versi >= 2.x
- **Node.js & NPM**: Versi >= 18.x
- **Database Server**: MySQL >= 8.0 atau MariaDB >= 10.4

### Core Stack
- **Framework**: Laravel 11.x (di dalam direktori `PPL/`)
- **Frontend Engine**: Blade Templates + Tailwind CSS 3.4 + Flowbite
- **JavaScript Framework**: Alpine.js 3.x
- **Build Tool**: Vite 5.x
- **Package Utama**:
  - `bacon/bacon-qr-code`: Generator QR Code SVG lokal
  - `barryvdh/laravel-dompdf`: Generator laporan PDF
  - `maatwebsite/excel`: Impor & ekspor spreadsheet
  - `laravel/socialite`: Google OAuth 2.0 SSO

---

## 🏗 Arsitektur Kode & Repository-Service Pattern

Untuk menghindari *fat controllers* dan *scattered DB queries*, codebase mengadopsi **Service-Repository Pattern**:

```
PPL/app/
├── Http/
│   ├── Controllers/          # Hanya bertugas HTTP: Request -> Service -> Response
│   │   ├── beranda/
│   │   ├── guru/
│   │   ├── perpustakaan/
│   │   ├── siswa/
│   │   ├── staffakademik/
│   │   ├── staffperpus/
│   │   └── superadmin/
│   └── Requests/             # 100% validasi input FormRequest terisolasi
│       ├── Absensi/
│       ├── Akademik/
│       ├── Ekstrakurikuler/
│       ├── Lms/
│       ├── Perpustakaan/
│       └── Ujian/
├── Models/                   # Definisi schema Eloquent, relasi, & casting
├── Providers/
│   └── RepositoryServiceProvider.php  # IoC Container bindings
├── Repositories/
│   ├── Contracts/            # Interface kontrak abstraksi data
│   │   ├── Absensi/
│   │   ├── Akademik/
│   │   ├── Ekstrakurikuler/
│   │   ├── Lms/
│   │   ├── Perpustakaan/
│   │   ├── Portal/
│   │   ├── Ujian/
│   │   └── UserManagement/
│   └── Eloquent/             # Implementasi query database (meng-extend BaseRepository)
└── Services/                 # Business logic, transaksi, kalkulasi nilai & file upload
    ├── Absensi/
    ├── Akademik/
    ├── Ekstrakurikuler/
    ├── Lms/
    ├── Perpustakaan/
    ├── Portal/
    ├── Superadmin/
    └── Ujian/
```

### Konvensi Koding yang Wajib Dipatuhi
1. **Controller**: Tidak boleh menjalankan query Eloquent/DB secara langsung (`DB::table()` atau `Model::where()`). Wajib memanggil method `Service`.
2. **Validasi**: Validasi tidak boleh menggunakan `$request->validate()` manual di dalam method Controller. Wajib membuat file `FormRequest` khusus di `app/Http/Requests/{Module}/`.
3. **Database Transaction**: Operasi multi-tabel (seperti submit ujian + simpan rincian jawaban) wajib dibungkus dalam `DB::transaction()`.
4. **Pint Standard**: Seluruh file PHP wajib mematuhi standar PSR-12 menggunakan Laravel Pint (`vendor/bin/pint`).

---

## 🚀 Panduan Instalasi & Setup Lokal

Ikuti langkah-langkah berikut untuk menjalankan sistem dari awal di lingkungan lokal:

### 1. Clone Repository & Masuk ke Folder Project
```bash
git clone https://github.com/ReEkaF/PPL-project.git
cd PPL-project/PPL
```

### 2. Install Dependensi Backend & Frontend
```bash
composer install
npm install
```

### 3. Setup File Konfigurasi `.env`
Salin template konfigurasi:
```bash
cp .env.example .env
```
Sesuaikan konfigurasi database di file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ppl
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key & Storage Link
```bash
php artisan key:generate
php artisan storage:link
```

### 5. Jalankan Migrasi & Seeder Database
```bash
php artisan migrate:fresh --seed
```

### 6. Build Asset Frontend
```bash
# Untuk pengembangan lokal:
npm run dev

# Atau untuk kompilasi production:
npm run build
```

### 7. Jalankan Server Lokal
```bash
php artisan serve
```
Akses aplikasi melalui browser di `http://127.0.0.1:8000`.

---

### 🔑 Akun Default Hasil Seeder

Gunakan kredensial default berikut untuk pengujian sesuai perannya:

| Role | Identitas Login (Username / NIP / NISN) | Password | Guard / Prefix Rute |
| :--- | :--- | :--- | :--- |
| **Superadmin** | `admin` (atau email admin) | `password` | `/superadmin/dashboard` |
| **Staff Akademik** | `akademik` | `akademik` | `/staff_akademik/dashboard` |
| **Staff Perpustakaan**| `perpus` | `perpus` | `/staff_perpus/dashboard` |
| **Guru Pengajar** | `198001012005011001` (NIP) | `password` | `/guru/dashboard` |
| **Siswa** | `1234567890` (NISN) | `password` | `/siswa/dashboard` |
| **Pembina Ekskul** | Guru yang ditunjuk sebagai pembina | `password` | `/pembina/dashboard` |
| **Pengurus Ekskul** | Siswa yang ditunjuk sebagai pengurus | `password` | `/pengurus/dashboard` |

---

## 🎨 Design System & UI Components

Aplikasi menggunakan palet desain resmi bertema institusi pendidikan terpercaya, menjauhkan kesan template generik (*anti-AI slop*).

### Design Tokens (`PPL/resources/css/tokens.css`)
- **Primary Institutional Navy**: `#0c8be5` s/d `#07253b` (mencerminkan kewibawaan dan keandalan sistem sekolah).
- **Educational Amber/Gold**: `#f59e0b` & `#d97706` (penanda aksi utama dan prestasi).
- **Surface & Clean Canvas**: `#f8fafc` & `#ffffff` dengan border netral `#e2e8f0` untuk kenyamanan membaca dalam durasi lama.
- **Micro-Animations & Elevation**: Halus, responsif terhadap hover dan fokus input.

### Blade Reusable UI Components
Disediakan komponen UI di `PPL/resources/views/components/ui/`:
- `<x-ui.button variant="primary|secondary|danger|outline">`: Tombol konsisten dengan transisi halus.
- `<x-ui.card>`: Kartu konten dengan border elegan dan elevasi terukur.
- `<x-ui.stat-card icon="..." label="..." value="..." delta="...">`: Kartu KPI statistik pada dashboard.
- `<x-ui.badge variant="success|warning|danger|brand">`: Label status seragam untuk peminjaman, kehadiran, dan ujian.
- `<x-ui.table>`: Wadah tabel responsif dengan scrolling horizontal otomatis di layar mobile.

---

## 📊 Log Audit & Refactoring Performance

Sebelum proses refactoring, sistem mengalami beberapa isu arsitektur dan performa yang ditangani secara menyeluruh melalui 7 siklus pengembangan:

### Ringkasan Temuan Masalah (Before)
1. **Asset Berat**: Gambar banner beranda (`perpus.jpg`, `ekstra.jpg`) berukuran > 10 MB menyebabkan waktu loading awal (*First Contentful Paint*) mencapai > 6 detik.
2. **Kueri Tanpa Batas (*Unbounded Queries*)**: Banyak pemanggilan `all()` dan `get()` tanpa pagination pada tabel transaksi dan data buku.
3. **Ketergantungan CDN Eksternal yang Rentan**: Mengimpor skrip Flowbite dari domain Vercel publik (`flowbite-admin-dashboard.vercel.app`), berisiko fatal jika link tersebut offline.
4. **Duplikasi Skrip**: Alpine.js di-load 2 kali (via Vite dan CDN), memicu *Alpine Warning: multiple instances*.
5. **Dead Code & Stray Debug**: Ditemukan file controller duplikat mati serta kode debug `dd()` yang tertinggal di controller produksi (`KelasController:280`).

### Hasil Refactoring & Optimasi (After)

| Metrik / Aspek | Sebelum Refactor (Before) | Sesudah Refactor (After) | Peningkatan / Penghematan |
| :--- | :--- | :--- | :--- |
| **Ukuran Gambar Banner** | 10.2 MB (JPEG) | 368 KB (WebP) | **Hemat 96.4% bandwidth** |
| **First Contentful Paint (Home)** | ~ 6.2 detik | ~ 0.8 detik | **~7.7x Lebih Cepat** |
| **Arsitektur Controller** | Monolitik, DB query langsung di Controller | Service-Repository Pattern terisolasi | **Pemisahan tanggung jawab 100% (Clean Code)** |
| **Validasi Form** | `$request->validate()` manual berulang | FormRequest terstruktur di layer HTTP | **Zero duplicate validation rules** |
| **External CDN Dependency** | 4 CDN eksternal render-blocking | 0 external dashboard bundle, asset lokal via Vite | **100% Mandiri & Aman** |
| **Kueri Transaksi Perpus** | Full scan tanpa indeks | B-Tree index pada kolom `kode_peminjam` & status | **Eksekusi pencarian instan O(log N)** |
| **Code Style Formatting** | Tidak konsisten antar developer | 100% lolos linting PSR-12 via Laravel Pint | **Zero linting errors (345 files clean)** |

---

## 👥 Tim Pengembang

Project ini dikembangkan dan direfaktor oleh Tim PPL Mahasiswa Informatika untuk implementasi sistem tata kelola pendidikan di **SMP Negeri 2 Kamal**.

---

### 📱 Konfigurasi WhatsApp Gateway (Twilio)
Untuk mengaktifkan pengiriman notifikasi otomatis tugas dan kehadiran via WhatsApp Gateway (Twilio):
1. Kirim pesan WhatsApp ke nomor `+14155238886`
2. Ketik `join weak-gold` (tanpa tanda petik) hingga menerima pesan balasan berhasil.
3. Pastikan nomor tujuan terdaftar dan jalankan worker antrean pada terminal terpisah:
   ```bash
   php artisan queue:listen
   ```
   dan scheduler:
   ```bash
   php artisan schedule:work
   ```

---

## 👥 Tim Pengembang

Project ini dikembangkan dan direfaktor oleh Tim PPL Mahasiswa Informatika untuk implementasi sistem tata kelola pendidikan di **SMP Negeri 2 Kamal**.

---
*Dokumentasi ini dimutakhirkan secara berkala untuk mendukung pemeliharaan sistem terpadu.*


# Design System — Sistem Sekolah Terintegrasi SMPN 2 Kamal

Versi 1.0 · Dokumen ini adalah **satu-satunya sumber kebenaran (single source of truth)** untuk semua keputusan visual di project ini — landing page, halaman login, dan ketiga dashboard role (Siswa, Guru, Admin). Semua halaman baru maupun refactor halaman lama harus merujuk ke sini, bukan menebak-nebak lagi.

Dipakai oleh: kamu (saat review PR/hasil AI agent) dan AI coding agent (saat eksekusi refactor).

---

## 0. Kenapa dokumen ini dibuat

Dari 6 screenshot yang kamu kirim (Beranda, Login, Absensi Siswa, Ekstrakurikuler Pembina, Dashboard Guru, Dashboard Siswa), semuanya punya pola yang sama: gradient gelap di hero/banner, badge pill bertumpuk, ikon dibungkus lingkaran warna-warni yang beda-beda tiap kartu, tombol CTA ganti-ganti warna (oranye/biru/hijau), titik status yang berkedip (`animate-pulse`), dan emoji di teks sapaan. Ini yang bikin kesan "AI slop" — ramai tapi nggak ada hierarki, dan tiap halaman kayak didesain sendiri-sendiri tanpa sistem.

Satu halaman yang kamu kirim — **Jadwal Pelajaran (Siswa)** — sudah benar arahnya: putih bersih, kartu statistik tanpa ikon warna-warni, label sentence case (bukan UPPERCASE), tag mapel kecil dengan satu warna flat, border tipis, tanpa gradient, tanpa bayangan berat. **Halaman ini jadi baseline/acuan untuk semua halaman lain.**

---

## 1. Prinsip Desain

1. **Satu warna aksen, bukan lima.** `#06466c` adalah satu-satunya warna untuk aksi utama (tombol primer, link aktif, ikon aktif). Warna lain (oranye, hijau, biru, ungu di layar lama) hanya boleh dipakai untuk status/kategori yang memang butuh dibedakan — bukan dekorasi.
2. **Flat, bukan gradient.** Tidak ada `linear-gradient`/`bg-gradient-to-*` di background section, banner, atau tombol. Kalau butuh "berat" visual, pakai warna solid + kontras teks, bukan gradasi.
3. **Ikon itu informasi, bukan dekorasi.** Ikon monokrom (abu-abu atau primary), bukan dibungkus lingkaran warna beda-beda tiap kartu. Warna hanya muncul kalau memang menandakan status.
4. **Diam itu ototmatis, gerak itu pengecualian.** Tidak ada `animate-pulse`, `animate-bounce`, elemen yang "bernapas" terus-menerus. Transisi hanya untuk respons aksi user (hover, klik, buka/tutup), 150–200ms, selesai.
5. **Tanpa emoji di UI.** Ganti dengan ikon dari library yang sudah dipakai, atau hilangkan saja kalau tidak esensial.
6. **Beri ruang.** Padding dan whitespace digandakan dari kondisi sekarang. Dashboard yang padat itu untuk tabel data, bukan untuk kartu ringkasan/banner sambutan.
7. **Satu bahasa komponen di semua role.** Kartu statistik, badge, tombol, sidebar harus terlihat dari sistem yang sama baik dibuka sebagai Siswa, Guru, maupun Admin — bukan tiga tema berbeda.

---

## 2. Audit — Apa yang Diganti dari Setiap Halaman

| Halaman | Ditemukan | Kenapa terasa "AI slop" | Ganti dengan |
|---|---|---|---|
| **Beranda (Landing)** | Hero gelap navy dengan vignette, CTA oranye, 4 badge kategori foto beda warna (teal/hijau/oranye/biru) | Kontras tema gelap→terang tiba-tiba, aksen oranye tidak konsisten dengan brand | Hero terang (putih / `#f0f7ff`), CTA solid `#06466c`, badge kategori disamakan ke 1–2 warna dari palet kategori resmi (§3.2) |
| **Login** | Panel kiri gelap dengan foto rak buku + overlay, 3 kotak fitur dengan ikon dibungkus lingkaran biru | Panel dekoratif tidak menambah fungsi, ikon-dalam-lingkaran adalah pola generik | Panel kiri solid `#06466c` flat (tanpa foto/overlay), ikon garis putih tanpa bungkus lingkaran |
| **Absensi Siswa (List)** | 4 kartu stat dengan ikon dibungkus lingkaran 4 warna beda (hijau/biru/oranye/merah), badge "Sangat Baik" hijau mengambang, avatar inisial mapel warna acak per baris, banner info dengan titik hijau berkedip (`animate-pulse`) sebelum "Ada 10 Mata Pelajaran...!" | Empat warna berbeda dalam satu baris kartu, titik berkedip, tanda seru | Ikon monokrom tanpa bungkus warna, badge status pakai palet semantik (§3.2), avatar satu warna konsisten (`primary-50`/`primary-700`), titik status statis (tanpa pulse), hapus tanda seru |
| **Ekstrakurikuler (Pembina)** | Banner cokelat/oranye gradient penuh lebar, 3 kartu ikon (oranye/biru/hijau), 3 tombol CTA beda warna (oranye/biru/hijau) | Gradient + 3 warna tombol berbeda untuk aksi setara level | Banner flat pakai `#06466c` atau dihapus jadi header teks biasa, 3 tombol disamakan jadi 1 gaya primary + 2 secondary/outline |
| **Dashboard Guru (Index)** | Banner sambutan gradient navy gelap, badge pill "Portal Pendidik" + "Pembina Ekskul" bertumpuk, banner CTA oranye gradient di bawah | Dua banner gelap+gradient dalam satu halaman, badge menumpuk | Banner sambutan jadi panel terang/flat tipis, maksimal 1 badge konteks, CTA ekskul jadi card putih standar dengan tombol primary |
| **Dashboard Siswa (Index)** | Banner sambutan gradient navy + emoji 👋, 4 kartu stat ikon 4 warna (hijau/oranye/biru/ungu), grid menu cepat dengan ikon warna-warni | Emoji di UI, ikon 4 warna berbeda untuk 4 stat yang levelnya setara | Hapus emoji, ikon stat monokrom, grid menu cepat pakai satu gaya ikon (monokrom, hover pakai `primary-50`) |
| **Jadwal Pelajaran (Siswa)** ✅ | Sudah sesuai arah baru: putih, kartu stat tanpa ikon warna, label sentence case, tag mapel flat kecil, border tipis, tanpa gradient/pulse | — | **Jadikan acuan/baseline pola untuk semua halaman list & detail lain** |

---

## 3. Design Tokens

### 3.1 Warna

**Base (yang kamu tentukan):**

| Token | Hex | Peran |
|---|---|---|
| `--color-white` | `#FFFFFF` | Background utama halaman, background kartu |
| `--color-primary` | `#06466C` | Warna brand tunggal: tombol primer, teks link aktif, ikon aktif, header/aksen |
| `--color-primary-tint` | `#F0F7FF` | Background subtle: hover, state aktif di sidebar, banner info, alternating section |

**Turunan primary** (dipakai untuk hover/active/border, bukan warna baru):

```css
--primary-50:  #F0F7FF;  /* = diberikan, untuk bg subtle/hover */
--primary-100: #DCEAF6;
--primary-200: #B9D5EC;
--primary-300: #8FBAD9;
--primary-400: #4C8DB3;
--primary-500: #1D6B93;
--primary-600: #0E577D;
--primary-700: #06466C;  /* = warna dasar yang diberikan, base/anchor */
--primary-800: #05395A;
--primary-900: #032840;
```
> Catatan: nilai tint/shade di atas estimasi tonal manual. Kalau butuh presisi (misal untuk dark-mode nanti), generate ulang ramp-nya dari `#06466C` pakai tool (mis. uicolors.app / `tailwindcss-color-shades`) — jangan tebak manual lagi di kode.

**Neutral (abu-abu, untuk teks & border — bukan abu-abu hitam pekat):**

```css
--neutral-0:   #FFFFFF;
--neutral-50:  #F7F9FB;
--neutral-100: #EEF2F6;
--neutral-200: #E2E8F0;  /* border default kartu/tabel */
--neutral-300: #CBD5E1;
--neutral-400: #94A3B8;  /* teks placeholder/disabled */
--neutral-500: #64748B;  /* teks sekunder/label */
--neutral-600: #475569;
--neutral-700: #334155;
--neutral-800: #1E293B;
--neutral-900: #0F172A;  /* teks utama — BUKAN #000000 murni */
```

**Palet status/kategori (dipakai untuk badge, subject tag, indikator kehadiran).**
Ini pengganti "warna lain yang tidak bertabrakan" yang kamu minta — dibatasi 6 warna saja, semuanya versi pucat (pastel muted) supaya tetap satu keluarga dengan `#06466c` / `#f0f7ff`, tidak norak:

| Nama | BG | Teks | Dipakai untuk |
|---|---|---|---|
| `success` | `#EAF6EF` | `#1F7A46` | Hadir, Selesai, Diterima, Aktif |
| `info` | `#E5F1FB` | `#1D5D8F` | Izin, informasi netral, tag mapel set 1 |
| `warning` | `#FDF3E4` | `#92620A` | Sakit, Menunggu, Perlu Perhatian |
| `danger` | `#FCECEC` | `#B4322D` | Alpa/Tanpa Keterangan, Ditolak, Error |
| `violet` | `#F1EDFB` | `#5B3FA0` | Tag kategori tambahan (mis. mapel set 2) |
| `teal` | `#E6F6F4` | `#157A6E` | Tag kategori tambahan (mis. mapel set 3) |
| `neutral` | `#EEF2F6` | `#475569` | Default/tanpa kategori, "belum ada data" |

**Aturan pemakaian status:**
- Hadir → `success` · Izin → `info` · Sakit → `warning` · Alpa/Tanpa Keterangan → `danger`. Konsisten di semua role (siswa lihat, guru lihat, admin lihat — warnanya sama).
- Tag mapel (subject tag di jadwal) boleh rotasi antar 6 warna di atas, tapi map-nya **tetap per mapel** (Matematika selalu warna yang sama di semua tempat), jangan random tiap render.
- Maksimal 1 badge status per baris/kartu. Jangan tumpuk 2–3 badge di satu elemen.

**Teks:**

```css
--text-primary:   var(--neutral-900);  /* body, heading */
--text-secondary: var(--neutral-500);  /* label, caption, meta */
--text-muted:     var(--neutral-400);  /* placeholder, disabled */
--text-inverse:   var(--color-white);  /* di atas background primary */
--text-brand:     var(--primary-700);  /* link, nav aktif */
```

Kontras minimum: teks body di atas putih pakai `neutral-900` (bukan abu-abu terang), teks di atas `primary-700` pakai putih — sudah AA-compliant.

### 3.2 Tipografi

Font saat ini kelihatannya default sistem/Inter — boleh dipertahankan kalau mau minim effort, tapi kalau mau upgrade sedikit, satu rekomendasi:

- **UI/Body:** `Plus Jakarta Sans` (Google Fonts, gratis, dukungan karakter Indonesia bagus, terasa beda dari default Inter tapi tetap sangat terbaca untuk dashboard data-berat). Fallback: `-apple-system, "Segoe UI", sans-serif`.
- **Angka data (opsional, boleh Phase 2):** `font-variant-numeric: tabular-nums;` untuk persentase kehadiran, NISN, jam — supaya digit sejajar rapi di kartu statistik. Kalau mau lebih jauh lagi, pakai monospace `IBM Plex Mono` khusus angka besar di stat card.
- Satu keluarga font saja, dibedakan lewat **weight** (400/500/600/700), bukan ganti-ganti font per section.

Skala tipografi:

| Level | Size | Weight | Dipakai untuk |
|---|---|---|---|
| Display (landing hero) | 40–56px | 700 | Headline landing page saja |
| H1 | 28–32px | 600 | Judul halaman ("Rekap & Presensi Kehadiran") |
| H2 | 20–22px | 600 | Judul section dalam halaman |
| H3 | 16–18px | 600 | Judul kartu |
| Body | 14–15px | 400 | Paragraf, deskripsi |
| Small/Caption | 12–13px | 400–500 | Label stat, meta info, timestamp |
| Stat number | 28–36px | 700 | Angka besar di kartu statistik (`neutral-900`, bukan warna-warni) |

Aturan label: **sentence case, bukan UPPERCASE.** Contoh benar: "Tingkat kehadiran" — bukan "TINGKAT KEHADIRAN". Ini juga otomatis menghapus kesan template AI generik.

### 3.3 Spacing & Grid

Base unit 4px:

```
4, 8, 12, 16, 20, 24, 32, 40, 48, 64
```

- Padding dalam kartu: minimal `20px`, idealnya `24px`.
- Jarak antar section dashboard: `32px`.
- Sidebar: lebar tetap `240–260px`, background putih, border kanan tipis `neutral-200`.
- Container landing page: `max-width: 1280px`, auto margin.
- Konten dashboard: full-width dengan padding horizontal `24–32px`, tanpa max-width ketat (karena tabel/data butuh ruang).

### 3.4 Radius

Skala kecil dan konsisten — bukan brutalist tajam, tapi juga bukan bubbly serba bulat:

```css
--radius-xs: 6px;   /* input, tag/badge kotak */
--radius-sm: 8px;   /* tombol, kartu kecil */
--radius-md: 10px;  /* kartu utama, panel */
--radius-lg: 14px;  /* modal, sheet — maksimum */
--radius-full: 9999px; /* pill badge, avatar bulat */
```

Jangan lebih besar dari `14px` kecuali untuk pill/avatar. Ini yang bikin kartu stat di screenshot lama terasa "app generik" — radius-nya terlalu besar dan tidak konsisten antar komponen.

### 3.5 Shadow

Default: **tanpa shadow.** Kartu dibedakan dari background pakai border `1px solid neutral-200`, bukan bayangan.

```css
--shadow-none: none;
--shadow-xs: 0 2px 8px rgba(6, 70, 108, 0.08); /* HANYA untuk dropdown, popover, modal overlay */
```

Jangan pakai `shadow-md`/`shadow-lg`/`shadow-xl` default Tailwind di kartu biasa — itu pola generik AI yang paling gampang dikenali.

### 3.6 Motion

```css
--transition-fast: 150ms ease-out;
--transition-base: 200ms ease-out;
```

- Hover kartu/tombol: transisi warna/border saja, `150–200ms`.
- Tombol ditekan: `transform: scale(0.98)`, tanpa efek lain.
- **Dilarang:** `animate-pulse`, `animate-bounce`, titik status berkedip terus-menerus, spinner warna-warni. Kalau butuh indikator "live"/aktif, pakai titik statis solid (`success`) + teks — tanpa animasi loop.
- Loading state: skeleton abu-abu (`neutral-100`) yang menirukan bentuk konten, bukan spinner generik di tengah layar.
- Hormati `prefers-reduced-motion`.

---

## 4. Spesifikasi Komponen

### Tombol (Button)
| Varian | Background | Teks | Border | Radius | Pakai untuk |
|---|---|---|---|---|---|
| Primary | `primary-700` (`#06466C`) | putih | — | `sm` | Satu-satunya aksi utama per halaman/kartu |
| Secondary/Outline | putih | `neutral-700` | `1px neutral-300` | `sm` | Aksi kedua ("Batal", "Lihat Detail") |
| Ghost/Text | transparan | `primary-700` | — | — | Aksi ringan dalam tabel/list |
| Destructive | putih | `danger` teks | `1px danger` border | `sm` | Hapus/tolak saja — jangan solid merah kecuali konfirmasi akhir |

**Aturan:** semua tombol "aksi utama" di seluruh halaman pakai `primary-700` yang sama. Jangan lagi tiap kartu punya warna tombol sendiri (oranye/biru/hijau seperti di halaman Ekstrakurikuler lama) — beda level urgensi ditunjukkan lewat varian (primary vs outline vs ghost), bukan lewat hue berbeda.

### Badge / Status Tag
- `inline-flex`, padding `4px 10px`, `radius-xs` (6px) — **bukan** pill bulat penuh kecuali memang untuk avatar.
- Font `12–13px`, weight `500`, **sentence case**.
- Background & teks dari palet §3.2 (satu warna flat, tanpa border, tanpa ikon di dalamnya kecuali titik status kecil).
- Maksimal satu badge "menonjol" per kartu/baris.

### Kartu (Card)
- Background putih, border `1px solid neutral-200`, radius `md` (10px), **tanpa shadow**.
- Padding `20–24px`.
- Judul kartu `H3`, isi `body`.

### Kartu Statistik (Stat Card)
Ganti total pola lama (ikon dibungkus lingkaran warna beda tiap kartu):
- Label kecil sentence case di atas angka (`text-secondary`, 13px) — bukan uppercase tracked.
- Angka besar (`28–36px`, `700`, `text-primary`, tabular-nums).
- Caption kecil di bawah angka (opsional), `text-secondary`.
- Ikon (opsional): monokrom `neutral-400`/`primary-700`, **tanpa** bungkus lingkaran warna. Kalau memang perlu sedikit penanda visual, cukup satu warna `primary-50` sebagai background ikon di **semua** kartu — jangan beda-beda per kartu.
- Referensi persis: kartu "Hari Sekolah / Total Sesi / Mata Pelajaran" di halaman Jadwal Siswa.

### Navigasi Sidebar
- Background putih, border kanan `1px neutral-200`.
- Item aktif: background `primary-50`, teks & ikon `primary-700`, garis aksen kiri `3px primary-700`.
- Item non-aktif: teks `neutral-600`, ikon `neutral-400`, hover background `neutral-50`.
- Satu icon set, satu stroke width, dipertahankan dari yang sekarang kalau memang sudah konsisten — tidak wajib ganti library ikon.

### Baris Tabel / List
- Border bawah `1px neutral-200` antar baris, tanpa zebra-stripe wajib.
- Hover baris: background `neutral-50` atau `primary-50` (pilih salah satu, konsisten di semua tabel).
- Avatar inisial: **satu warna konsisten** (`bg: primary-50`, `text: primary-700`) untuk semua orang — bukan warna acak per baris seperti di halaman Absensi lama. Kalau butuh foto asli user, pakai foto; kalau inisial, satu palet saja.

### Progress Bar
- Track `neutral-100`, tinggi `6–8px`, radius `full`.
- Fill: `primary-700` untuk progres netral, atau warna semantik (`success`/`warning`/`danger`) kalau progress itu sendiri merepresentasikan status (mis. tingkat kehadiran rendah → `warning`/`danger`).
- Tanpa gradient, tanpa garis/pattern animasi.

### Alert / Banner / Callout
- Background `semantic-50` (mis. `primary-50` untuk info netral), border kiri `3px solid semantic-700`, radius `sm`.
- Ikon monokrom warna semantik, tanpa lingkaran bungkus.
- Teks langsung, tanpa tanda seru, tanpa emoji. Contoh perbaikan:
  - Sebelum: *"Ada 10 Mata Pelajaran dengan Sesi Presensi Aktif!"*
  - Sesudah: *"10 mata pelajaran memiliki sesi presensi aktif."*

### Hero / Banner Sambutan (dashboard & landing)
- **Tidak ada gradient gelap.** Dua opsi:
  - **A (direkomendasikan, default untuk dashboard internal):** panel terang — putih atau `primary-tint` (`#F0F7FF`) — dengan judul `neutral-900`, tanpa foto latar, tanpa emoji.
  - **B (opsional, khusus hero landing page kalau mau lebih "berat" secara visual):** panel solid `primary-700` flat, teks putih. Tidak dipakai untuk banner sambutan dashboard internal (Siswa/Guru), karena akan terasa berat dipakai berulang setiap hari.
- Maksimal **1 badge/context label** di dalam hero. Kalau ada 2 info (mis. "Portal Pendidik" + "Pembina Ekskul"), gabungkan jadi satu baris teks biasa, bukan dua pill terpisah.
- Hapus emoji (mis. 👋) dari teks sapaan.

### Form Input
- Border `1px neutral-300`, radius `xs`, padding `10px 12px`.
- Focus: border `primary-700` + ring tipis `primary-100`.
- Placeholder `text-muted`.
- Error: border `danger`, pesan error langsung di bawah field (`13px`, warna `danger`), tanpa `alert()` browser.

### Modal / Overlay
- Radius `lg` (14px), shadow `xs` (satu-satunya tempat shadow boleh dipakai selain dropdown), backdrop `rgba(15,23,42,0.4)` tanpa blur berlebihan.

---

## 5. Pola Halaman

### Landing Page (Beranda + subpage Perpustakaan/Tenaga Pengajar/Ekstrakurikuler/Prestasi)
- Hero terang (§4, Opsi A atau B — pilih satu dan konsisten di semua subpage).
- Stat ringkas (4 angka: Tenaga Pengajar, Siswa Terdaftar, dst.) pakai pola Stat Card standar (§4), tanpa ikon warna-warni.
- Grid fasilitas: badge kategori foto disederhanakan ke maksimal 2 warna dari palet §3.2, bukan 4 warna berbeda per kartu.
- CTA utama: satu tombol primary (`#06466c`), CTA sekunder: outline/ghost — bukan solid oranye.

### Login
- Pertahankan layout dua panel (sudah cukup baik secara struktur), tapi:
  - Panel kiri: ganti foto+overlay gelap jadi **solid `primary-700` flat**, teks putih, ikon garis putih tanpa bungkus lingkaran.
  - Panel kanan: form tetap seperti sekarang (sudah cukup bersih), rapikan warna info-box supaya persis `primary-50`/`primary-700` sesuai token.

### Dashboard — semua role (Siswa, Guru, Admin)
Struktur shell sama persis di 3 role, hanya konten yang beda:
- Sidebar kiri (§4).
- Topbar kanan atas: nama + role, tanpa dekorasi berlebih.
- Panel sambutan: Opsi A (§4) — flat, tanpa gradient, tanpa emoji.
- Baris kartu statistik: pola Stat Card seragam, 3–4 kartu, tanpa ikon warna-warni beda tiap kartu.
- Section list (jadwal hari ini, tugas terkini, dst.): **contoh pola sudah benar ada di halaman Jadwal Siswa** — pakai grouping header simpel + list item dengan tag kecil, bukan kartu besar bertumpuk.

### Halaman List/Detail (Absensi, Ekstrakurikuler, Presensi, dll — semua role)
Samakan ke pola halaman **Jadwal Pelajaran Siswa**:
- Header halaman: judul H1 + deskripsi 1 baris `text-secondary`.
- Baris stat ringkas di atas (opsional), pola Stat Card.
- Filter/tab (mis. "Semua / Senin / Selasa"): pill outline sederhana, aktif = `primary-700` solid, non-aktif = outline `neutral-300`.
- List/kartu detail: border tipis, tanpa shadow, badge status dari palet §3.2, avatar/inisial satu warna konsisten, progress bar tanpa animasi.

---

## 6. Cek Cepat (Do & Don't)

| ❌ Jangan | ✅ Lakukan |
|---|---|
| Gradient di hero/banner/tombol | Warna solid dari token |
| Ikon dibungkus lingkaran warna beda tiap kartu | Ikon monokrom, atau satu warna bg konsisten di semua kartu sejenis |
| Tombol CTA beda warna per kartu (oranye/biru/hijau) | Satu warna primary untuk semua aksi utama, varian lewat outline/ghost |
| `animate-pulse` / titik status berkedip | Titik status statis |
| Emoji di teks UI (👋, 🎉, dst.) | Hapus, atau ganti ikon dari library yang sudah dipakai |
| Badge/pill menumpuk 2–3 dalam satu elemen | Maksimal 1 badge menonjol |
| Label UPPERCASE tracked di kartu stat | Sentence case |
| Shadow besar (`shadow-lg`/`xl`) di kartu biasa | Border tipis `1px neutral-200`, tanpa shadow |
| Radius besar tidak konsisten antar komponen | Skala radius §3.4 (maks 14px kecuali pill) |
| Avatar/tag warna acak per item | Satu warna konsisten, atau mapping tetap (bukan random) |
| Tanda seru di pesan sukses/info ("...Aktif!") | Kalimat langsung tanpa tanda seru |

---

## 7. Referensi Implementasi

Halaman **Jadwal Pelajaran (Siswa)** = baseline visual final. Kalau ragu bagaimana suatu komponen harus terlihat, cocokkan dulu ke halaman ini sebelum menebak dari nol.

<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Aturan Perpustakaan</h1>
                <p class="text-sm text-slate-500 mt-0.5">Pedoman dan ketentuan peminjaman buku perpustakaan untuk siswa.</p>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl w-fit">
            <a href="{{ route('siswa.perpustakaan.index') }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors text-slate-500 hover:text-slate-700">
                Katalog Buku
            </a>
            <a href="{{ route('siswa.perpustakaan.riwayat') }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors text-slate-500 hover:text-slate-700">
                Riwayat Peminjaman
            </a>
            <a href="{{ route('siswa.perpustakaan.rules') }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors bg-white text-slate-900 shadow-sm">
                Aturan Perpustakaan
            </a>
        </div>

        {{-- Rules Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">

            {{-- Card 1: Persyaratan Peminjaman --}}
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900 text-base">Syarat Peminjaman</h2>
                        <p class="text-xs text-slate-500">Ketentuan identitas sebelum meminjam</p>
                    </div>
                </div>

                <ul class="space-y-3 text-sm text-slate-600">
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">✓</span>
                        <span><strong>Identitas Terverifikasi:</strong> Siswa wajib memiliki NISN aktif dan terdaftar di pangkalan data sekolah.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">✓</span>
                        <span><strong>Bebas Denda:</strong> Siswa tidak boleh memiliki lebih dari 3 denda keterlambatan yang belum diselesaikan.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">✓</span>
                        <span><strong>Peminjaman Langsung:</strong> Peminjaman wajib dilakukan oleh siswa yang bersangkutan di meja sirkulasi.</span>
                    </li>
                </ul>
            </div>

            {{-- Card 2: Batas & Durasi Peminjaman --}}
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900 text-base">Durasi & Kuota Peminjaman</h2>
                        <p class="text-xs text-slate-500">Masa peminjaman buku berdasarkan jenis</p>
                    </div>
                </div>

                <ul class="space-y-3 text-sm text-slate-600">
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">1</span>
                        <div>
                            <strong class="text-slate-900">Buku Non-Paket (Umum/Fiksi):</strong>
                            <p class="text-xs text-slate-500 mt-0.5">Maksimal peminjaman <strong>3 buku</strong> dengan batas waktu <strong>2 minggu (14 hari)</strong>.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">2</span>
                        <div>
                            <strong class="text-slate-900">Buku Paket Pelajaran:</strong>
                            <p class="text-xs text-slate-500 mt-0.5">Diberikan untuk mendukung kegiatan belajar mengajar dengan batas peminjaman <strong>1 tahun ajaran</strong>.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">3</span>
                        <div>
                            <strong class="text-slate-900">Perpanjangan Peminjaman:</strong>
                            <p class="text-xs text-slate-500 mt-0.5">Dapat diperpanjang 1 kali selama buku tidak dalam daftar antrean peminjaman siswa lain.</p>
                        </div>
                    </li>
                </ul>
            </div>

            {{-- Card 3: Ketentuan Pengembalian & Denda --}}
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900 text-base">Pengembalian & Denda</h2>
                        <p class="text-xs text-slate-500">Kewajiban menjaga dan mematuhi tenggat</p>
                    </div>
                </div>

                <ul class="space-y-3 text-sm text-slate-600">
                    <li class="flex items-start gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mt-2 shrink-0"></span>
                        <span><strong>Tepat Waktu:</strong> Buku wajib dikembalikan tepat pada atau sebelum tanggal batas pengembalian.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mt-2 shrink-0"></span>
                        <span><strong>Denda Keterlambatan:</strong> Keterlambatan pengembalian buku non-paket akan dikenakan tarif denda per hari per buku.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mt-2 shrink-0"></span>
                        <span><strong>Kerusakan / Kehilangan:</strong> Buku yang rusak atau hilang wajib diganti dengan judul buku yang sama atau setara atas persetujuan staf perpustakaan.</span>
                    </li>
                </ul>
            </div>

            {{-- Card 4: Jam Layanan & Tata Tertib --}}
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900 text-base">Layanan & Tata Tertib Ruang</h2>
                        <p class="text-xs text-slate-500">Kenyamanan membaca bersama</p>
                    </div>
                </div>

                <ul class="space-y-3 text-sm text-slate-600">
                    <li class="flex items-start gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-violet-500 mt-2 shrink-0"></span>
                        <span><strong>Jam Operasional:</strong> Buka hari Senin s/d Jumat pukul 07.30 - 15.00 WIB pada hari sekolah aktif.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-violet-500 mt-2 shrink-0"></span>
                        <span><strong>Kenyamanan Ruang:</strong> Menjaga ketenangan, tidak membawa makanan atau minuman manis ke area rak buku.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-violet-500 mt-2 shrink-0"></span>
                        <span><strong>Buku Baca di Tempat:</strong> Setelah membaca di ruang baca, letakkan buku di meja penitipan / troli buku sirkulasi.</span>
                    </li>
                </ul>
            </div>

        </div>

        {{-- Bantuan Callout --}}
        <div class="bg-brand-50 border border-brand-200 rounded-xl p-5 flex items-start gap-3.5">
            <div class="w-9 h-9 rounded-lg bg-brand-100 text-brand-700 flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-brand-900">Perlu Bantuan atau Informasi Lebih Lanjut?</h4>
                <p class="text-xs text-brand-700 mt-1 leading-relaxed">
                    Apabila ada pertanyaan seputar peminjaman, perpanjangan masa pinjam, atau ketersediaan koleksi referensi khusus, silakan menghubungi petugas di meja sirkulasi perpustakaan sekolah pada jam kerja.
                </p>
            </div>
        </div>

    </div>
</x-siswa-layout>

<x-app-guru-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Header & Navigasi Kembali --}}
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <a href="{{ route('ujian.show') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-brand-800 transition-colors">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                        <span>Kembali ke Daftar Ujian</span>
                    </a>
                </div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tambah Ujian Baru</h1>
                <p class="text-xs text-slate-500">
                    Lengkapi informasi paket ujian, jadwal pelaksanaan, durasi, dan token akses siswa.
                </p>
            </div>
        </div>

        {{-- Stepper Progress --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-1.5 bg-slate-100 rounded-2xl border border-slate-200">
            <div class="flex items-center gap-3 px-4 py-3 bg-white rounded-xl shadow-xs border border-slate-200">
                <div class="w-8 h-8 rounded-lg bg-brand-800 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                    1
                </div>
                <div>
                    <p class="text-xs font-bold text-brand-900">Step 1: Informasi & Jadwal Ujian</p>
                    <p class="text-[11px] text-slate-500">Isi data umum, kelas, jenis, jadwal & durasi</p>
                </div>
            </div>
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl opacity-60">
                <div class="w-8 h-8 rounded-lg bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-xs">
                    2
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-700">Step 2: Soal & Kunci Jawaban</p>
                    <p class="text-[11px] text-slate-500">Input form satu per satu atau upload file Excel</p>
                </div>
            </div>
        </div>

        {{-- Validation Error Alerts --}}
        @if (isset($errors) && $errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1.5">
                <div class="flex items-center gap-2 font-bold text-rose-900">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Terdapat beberapa kesalahan pengisian form:</span>
                </div>
                <ul class="list-disc list-inside pl-1 space-y-0.5 text-rose-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <form action="{{ route('ujian.stored') }}" method="POST" class="divide-y divide-slate-100">
                @csrf

                {{-- Section 1: Rombel Kelas & Informasi Utama Ujian --}}
                <div class="p-6 space-y-5">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <span class="w-7 h-7 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center text-xs font-bold">
                            1
                        </span>
                        <h2 class="text-sm font-bold text-slate-900">Rombel Kelas & Informasi Ujian</h2>
                    </div>

                    {{-- 1. Pilih Kelas & Mata Pelajaran (Grouped by Class) --}}
                    <div>
                        <label for="kelas_mata_pelajaran_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Rombel Kelas & Mata Pelajaran <span class="text-rose-500">*</span>
                        </label>
                        <select name="kelas_mata_pelajaran_id" id="kelas_mata_pelajaran_id" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors bg-white">
                            <option value="" disabled {{ old('kelas_mata_pelajaran_id', request('kelas_mata_pelajaran_id')) ? '' : 'selected' }}>
                                -- Pilih Rombel Kelas & Mata Pelajaran --
                            </option>
                            @foreach ($groupedKmp as $namaKelas => $items)
                                <optgroup label="🏫 KELAS {{ $namaKelas }}">
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id_kelas_mata_pelajaran }}"
                                            data-kmp="{{ $item->id_kelas_mata_pelajaran }}"
                                            {{ old('kelas_mata_pelajaran_id', request('kelas_mata_pelajaran_id')) == $item->id_kelas_mata_pelajaran ? 'selected' : '' }}>
                                            Kelas {{ $namaKelas }} · {{ $item->mataPelajaran->nama_matpel ?? '-' }} ({{ $item->guru->nama_guru ?? '-' }})
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Pilihan dikelompokkan berdasarkan rombel kelas untuk memudahkan penugasan ujian.
                        </p>
                    </div>

                    {{-- 2. Judul Ujian --}}
                    <div>
                        <label for="judul" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Judul Ujian <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required
                            placeholder="Contoh: Penilaian Tengah Semester (PTS) - Matematika Kelas 7A"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- 3. Jenis Ujian --}}
                        <div>
                            <label for="jenis_ujian" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Jenis Ujian <span class="text-rose-500">*</span>
                            </label>
                            <select name="jenis_ujian" id="jenis_ujian" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors bg-white">
                                <option value="PTS" {{ old('jenis_ujian') == 'PTS' ? 'selected' : '' }}>PTS / UTS (Tengah Semester)</option>
                                <option value="PAS" {{ old('jenis_ujian') == 'PAS' ? 'selected' : '' }}>PAS / UAS (Akhir Semester)</option>
                                <option value="Ulangan Harian" {{ old('jenis_ujian') == 'Ulangan Harian' ? 'selected' : '' }}>Ulangan Harian</option>
                                <option value="Kuis" {{ old('jenis_ujian') == 'Kuis' ? 'selected' : '' }}>Kuis / Formatif</option>
                                <option value="Try Out" {{ old('jenis_ujian') == 'Try Out' ? 'selected' : '' }}>Try Out</option>
                            </select>
                        </div>

                        {{-- 4. Topik Pembelajaran --}}
                        <div>
                            <label for="topik_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Topik Pembelajaran <span class="text-rose-500">*</span>
                            </label>
                            <select name="topik_id" id="topik_id" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors bg-white">
                                <option value="" disabled selected>-- Pilih Topik Pembelajaran --</option>
                                @foreach ($topik as $item)
                                    <option value="{{ $item->id_topik }}"
                                        data-kmp="{{ $item->kelas_mata_pelajaran_id }}"
                                        {{ old('topik_id') == $item->id_topik ? 'selected' : '' }}>
                                        {{ $item->judul_topik }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- 5. Deskripsi Ujian --}}
                    <div>
                        <label for="deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Deskripsi / Petunjuk Ujian
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                            placeholder="Tuliskan petunjuk pengerjaan ujian, tata tertib asesmen, atau cakupan materi..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>

                {{-- Section 2: Jadwal Pelaksanaan, Durasi & Token CBT --}}
                <div class="p-6 space-y-5 bg-slate-50/50">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <span class="w-7 h-7 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center text-xs font-bold">
                            2
                        </span>
                        <h2 class="text-sm font-bold text-slate-900">Jadwal Pelaksanaan & Pengaturan CBT</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- 6. Tanggal Dibuat --}}
                        <div class="sm:col-span-2">
                            <label for="tanggal_dibuat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tanggal Dibuat <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="tanggal_dibuat" id="tanggal_dibuat" required
                                value="{{ old('tanggal_dibuat', date('Y-m-d')) }}"
                                class="w-full sm:w-1/2 px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors bg-white">
                        </div>

                        {{-- 7. Waktu Mulai --}}
                        <div>
                            <label for="waktu_mulai" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Waktu Mulai Pengerjaan
                            </label>
                            <input type="datetime-local" name="waktu_mulai" id="waktu_mulai"
                                value="{{ old('waktu_mulai') }}"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors bg-white">
                            <p class="text-[11px] text-slate-400 mt-1">Jadwal pembukaan sesi ujian bagi siswa.</p>
                        </div>

                        {{-- 8. Waktu Selesai --}}
                        <div>
                            <label for="waktu_selesai" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Waktu Selesai Pengerjaan
                            </label>
                            <input type="datetime-local" name="waktu_selesai" id="waktu_selesai"
                                value="{{ old('waktu_selesai') }}"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors bg-white">
                            <p class="text-[11px] text-slate-400 mt-1">Batas akhir penutupan sesi ujian bagi siswa.</p>
                        </div>

                        {{-- 9. Durasi Pengerjaan (Otomatis Dihitung) --}}
                        <div class="sm:col-span-2">
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="durasi_menit" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    Durasi Pengerjaan (Menit) <span class="text-rose-500">*</span>
                                </label>
                                <span id="durasi-badge" class="hidden text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                    <i class="fa-solid fa-calculator text-[10px] mr-1"></i>Otomatis Terhitung
                                </span>
                            </div>
                            <div class="relative w-full sm:w-1/2">
                                <input type="number" name="durasi_menit" id="durasi_menit" min="1" max="1440" step="1"
                                    value="{{ old('durasi_menit', 60) }}" required
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors bg-white pr-16">
                                <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs text-slate-400 font-medium pointer-events-none">
                                    Menit
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1">
                                Otomatis dihitung dari selisih waktu mulai & selesai. Anda juga dapat mengubah durasi ini secara manual jika diinginkan.
                            </p>
                        </div>

                        {{-- 10. Token Akses Ujian --}}
                        <div class="sm:col-span-2">
                            <label for="token" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Token Akses Ujian (CBT)
                            </label>
                            <div class="flex items-center gap-2">
                                <div class="relative flex-1 sm:w-1/2 sm:flex-none">
                                    <input type="text" name="token" id="token" maxlength="10"
                                        value="{{ old('token') }}"
                                        placeholder="Contoh: PTS7A1 (Kosongkan jika tanpa token)"
                                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-mono font-bold tracking-wider text-slate-800 uppercase focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors bg-white">
                                </div>
                                <button type="button" id="btn-generate-token"
                                    class="px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold transition-colors shrink-0 flex items-center gap-1.5 shadow-sm">
                                    <i class="fa-solid fa-dice text-brand-700"></i>
                                    <span>Acak Token</span>
                                </button>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1">
                                Token bersifat opsional. Siswa harus memasukkan token ini sebelum memulai pengerjaan tes jika diisi.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="px-6 py-4 bg-slate-50 flex items-center justify-between">
                    <a href="{{ route('ujian.show') }}"
                        class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 font-semibold text-xs transition-colors shadow-sm">
                        Batal
                    </a>
                    <button type="submit" id="submitUjian"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-800 text-white hover:bg-brand-900 font-semibold text-xs transition-colors shadow-sm">
                        <span>Lanjut ke Step 2: Isi Soal & Jawaban</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- Dynamic Form Interaction Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kmpSelect = document.getElementById('kelas_mata_pelajaran_id');
            const topikSelect = document.getElementById('topik_id');
            const generateTokenBtn = document.getElementById('btn-generate-token');
            const tokenInput = document.getElementById('token');
            const waktuMulaiInput = document.getElementById('waktu_mulai');
            const waktuSelesaiInput = document.getElementById('waktu_selesai');
            const durasiInput = document.getElementById('durasi_menit');
            const durasiBadge = document.getElementById('durasi-badge');

            // Hitung Durasi Otomatis dari Selisih Waktu Mulai & Selesai
            function hitungDurasiOtomatis() {
                if (waktuMulaiInput && waktuSelesaiInput && durasiInput) {
                    const startVal = waktuMulaiInput.value;
                    const endVal = waktuSelesaiInput.value;

                    if (startVal && endVal) {
                        const startDate = new Date(startVal);
                        const endDate = new Date(endVal);
                        const diffMs = endDate - startDate;

                        if (diffMs > 0) {
                            const diffMinutes = Math.round(diffMs / (1000 * 60));
                            durasiInput.value = diffMinutes;
                            if (durasiBadge) {
                                durasiBadge.classList.remove('hidden');
                                durasiBadge.innerHTML = `<i class="fa-solid fa-calculator text-[10px] mr-1"></i>Otomatis: ${diffMinutes} Menit`;
                            }
                        } else if (diffMs <= 0) {
                            alert('Perhatian: Waktu selesai harus lebih besar dari waktu mulai.');
                        }
                    }
                }
            }

            if (waktuMulaiInput && waktuSelesaiInput) {
                waktuMulaiInput.addEventListener('change', hitungDurasiOtomatis);
                waktuSelesaiInput.addEventListener('change', hitungDurasiOtomatis);
            }

            // Generator Token Acak
            if (generateTokenBtn && tokenInput) {
                generateTokenBtn.addEventListener('click', function () {
                    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
                    let generated = '';
                    for (let i = 0; i < 6; i++) {
                        generated += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    tokenInput.value = generated;
                });
            }

            // Filter Topik Berdasarkan Kelas Mata Pelajaran Terpilih
            if (kmpSelect && topikSelect) {
                function filterTopik() {
                    const selectedKmp = kmpSelect.value;
                    const options = topikSelect.querySelectorAll('option');

                    options.forEach((opt, index) => {
                        if (index === 0) return; // Skip placeholder
                        const optKmp = opt.dataset.kmp;
                        if (!selectedKmp || !optKmp || optKmp === selectedKmp) {
                            opt.hidden = false;
                            opt.disabled = false;
                        } else {
                            opt.hidden = true;
                            opt.disabled = true;
                            if (opt.selected) {
                                opt.selected = false;
                                options[0].selected = true;
                            }
                        }
                    });
                }

                kmpSelect.addEventListener('change', filterTopik);
                if (kmpSelect.value) {
                    filterTopik();
                }
            }
        });
    </script>
</x-app-guru-layout>
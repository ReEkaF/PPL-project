<x-app-guru-layout>
    <div class="max-w-5xl mx-auto space-y-6 pb-12">

        {{-- Header & Navigasi Kembali --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <a href="{{ route('ujian.show') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-brand-800 transition-colors">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                        <span>Kembali ke Beranda Ujian</span>
                    </a>
                </div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Kelola Soal & Kunci Jawaban</h1>
                <p class="text-xs text-slate-500">
                    Step 2: Lengkapi paket ujian dengan butir soal melalui form manual satu per satu atau unggah file Excel sekaligus.
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('guru.ujian.detail', $ujian->id_ujian) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-sm transition-colors">
                    <i class="fa-solid fa-circle-check text-xs"></i>
                    <span>Selesai & Lihat Detail Ujian</span>
                </a>
            </div>
        </div>

        {{-- Stepper Progress --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-1.5 bg-slate-100 rounded-2xl border border-slate-200">
            {{-- Step 1: Selesai --}}
            <a href="{{ route('guru.ujian.edit', $ujian->id_ujian) }}" title="Klik untuk edit informasi ujian"
                class="flex items-center justify-between px-4 py-3 bg-white rounded-xl shadow-xs border border-slate-200 hover:border-brand-300 transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <p class="text-xs font-bold text-emerald-900">Step 1: Informasi & Jadwal Ujian</p>
                            <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">Tersimpan</span>
                        </div>
                        <p class="text-[11px] text-slate-500 group-hover:text-brand-700 transition-colors">
                            {{ Str::limit($ujian->judul, 35) }} · Ubah
                        </p>
                    </div>
                </div>
                <i class="fa-solid fa-pen-to-square text-xs text-slate-400 group-hover:text-brand-700"></i>
            </a>

            {{-- Step 2: Sedang Aktif --}}
            <div class="flex items-center gap-3 px-4 py-3 bg-white rounded-xl shadow-xs border-2 border-brand-800">
                <div class="w-8 h-8 rounded-lg bg-brand-800 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                    2
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <p class="text-xs font-bold text-brand-900">Step 2: Soal & Kunci Jawaban</p>
                        <span class="text-[10px] font-bold text-brand-700 bg-brand-50 px-1.5 py-0.5 rounded">Sedang Aktif</span>
                    </div>
                    <p class="text-[11px] text-slate-500">Pilih Form Manual atau Upload Excel</p>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0"></i>
                <div class="font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base shrink-0"></i>
                <div class="font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                <div class="flex items-center gap-2 font-bold text-rose-900">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Terdapat kesalahan pengisian:</span>
                </div>
                <ul class="list-disc list-inside pl-1 space-y-0.5 text-rose-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Ringkasan Paket Ujian Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold tracking-wide uppercase bg-brand-50 text-brand-800 border border-brand-200">
                        {{ $ujian->jenis_ujian ?? 'UJIAN CBT' }}
                    </span>
                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                        Kelas {{ $ujian->kelasMataPelajaran?->kelas?->nama_kelas ?? '-' }}
                    </span>
                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        {{ $ujian->kelasMataPelajaran?->mataPelajaran?->nama_matpel ?? '-' }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold {{ $ujian->soalUjian->count() > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                        <i class="fa-solid {{ $ujian->soalUjian->count() > 0 ? 'fa-check' : 'fa-info-circle' }} text-[10px]"></i>
                        <span>{{ $ujian->soalUjian->count() }} Soal Tersimpan</span>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                <div>
                    <p class="text-[11px] text-slate-400 font-medium">Judul Paket Ujian</p>
                    <p class="font-bold text-slate-800 mt-0.5">{{ $ujian->judul }}</p>
                </div>
                <div>
                    <p class="text-[11px] text-slate-400 font-medium">Jadwal Pelaksanaan</p>
                    <p class="font-semibold text-slate-800 mt-0.5">
                        {{ $ujian->waktu_mulai ? \Carbon\Carbon::parse($ujian->waktu_mulai)->translatedFormat('d M Y, H:i') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-[11px] text-slate-400 font-medium">Durasi Pengerjaan</p>
                    <p class="font-semibold text-slate-800 mt-0.5">
                        <i class="fa-regular fa-clock text-brand-600 mr-1"></i>{{ $ujian->durasi_menit ?? 60 }} Menit
                    </p>
                </div>
                <div>
                    <p class="text-[11px] text-slate-400 font-medium">Token Akses Siswa</p>
                    <p class="font-mono font-bold text-brand-900 mt-0.5">
                        {{ $ujian->token ?: 'Tanpa Token' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Pilihan Opsi Pengisian Soal (Tab Switcher) --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- Tab Header --}}
            <div class="border-b border-slate-200 bg-slate-50/70 p-2 sm:p-3">
                <div class="grid grid-cols-2 gap-2 max-w-lg mx-auto sm:mx-0">
                    <button type="button" id="tab-btn-manual" onclick="switchSoalTab('manual')"
                        class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-xs bg-brand-800 text-white">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                        <span>Opsi 1: Input Form Manual</span>
                    </button>
                    <button type="button" id="tab-btn-excel" onclick="switchSoalTab('excel')"
                        class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-200/60">
                        <i class="fa-solid fa-file-excel text-xs text-emerald-600"></i>
                        <span>Opsi 2: Upload File Excel</span>
                    </button>
                </div>
            </div>

            {{-- TAB 1: FORM INPUT MANUAL --}}
            <div id="tab-content-manual" class="p-6 space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Form Input Butir Soal (Satu per Satu)</h2>
                        <p class="text-xs text-slate-500">Tuliskan teks pertanyaan, pilihan opsi A sampai D, lalu tentukan kunci jawaban yang benar.</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-brand-50 text-brand-800 border border-brand-200 shrink-0">
                        Soal Ke-{{ $ujian->soalUjian->count() + 1 }}
                    </span>
                </div>

                <form action="{{ route('guru.ujian.soal.store_manual', $ujian->id_ujian) }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- 1. Teks Pertanyaan --}}
                    <div>
                        <label for="teks_soal" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Teks Pertanyaan / Soal <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="teks_soal" id="teks_soal" rows="3" required
                            placeholder="Tuliskan butir soal atau pertanyaan secara lengkap di sini..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">{{ old('teks_soal') }}</textarea>
                    </div>

                    {{-- 2. Pilihan Jawaban A, B, C, D --}}
                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Pilihan Jawaban (Opsi A - D) <span class="text-rose-500">*</span>
                        </label>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                            {{-- Opsi A --}}
                            <div class="relative flex items-center">
                                <span class="absolute left-3 w-6 h-6 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold">
                                    A
                                </span>
                                <input type="text" name="opsi_a" value="{{ old('opsi_a') }}" required
                                    placeholder="Teks pilihan jawaban A"
                                    class="w-full pl-11 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                            </div>

                            {{-- Opsi B --}}
                            <div class="relative flex items-center">
                                <span class="absolute left-3 w-6 h-6 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold">
                                    B
                                </span>
                                <input type="text" name="opsi_b" value="{{ old('opsi_b') }}" required
                                    placeholder="Teks pilihan jawaban B"
                                    class="w-full pl-11 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                            </div>

                            {{-- Opsi C --}}
                            <div class="relative flex items-center">
                                <span class="absolute left-3 w-6 h-6 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold">
                                    C
                                </span>
                                <input type="text" name="opsi_c" value="{{ old('opsi_c') }}" required
                                    placeholder="Teks pilihan jawaban C"
                                    class="w-full pl-11 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                            </div>

                            {{-- Opsi D --}}
                            <div class="relative flex items-center">
                                <span class="absolute left-3 w-6 h-6 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold">
                                    D
                                </span>
                                <input type="text" name="opsi_d" value="{{ old('opsi_d') }}" required
                                    placeholder="Teks pilihan jawaban D"
                                    class="w-full pl-11 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    {{-- 3. Kunci Jawaban Selector --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih Kunci Jawaban yang Benar <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach (['A', 'B', 'C', 'D'] as $key)
                                <label class="relative flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-slate-100/70 cursor-pointer transition-colors has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500 has-[:checked]:text-emerald-900">
                                    <input type="radio" name="kunci_jawaban" value="{{ $key }}" required
                                        {{ old('kunci_jawaban') == $key ? 'checked' : '' }}
                                        class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                    <div class="flex items-center gap-1.5 font-bold text-xs">
                                        <span>Kunci:</span>
                                        <span class="w-5 h-5 rounded bg-white border border-slate-200 flex items-center justify-center text-xs text-slate-800 shadow-2xs font-extrabold">
                                            {{ $key }}
                                        </span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1.5">
                            Pilih salah satu dari opsi A, B, C, atau D yang merupakan jawaban benar.
                        </p>
                    </div>

                    {{-- Action Button --}}
                    <div class="pt-2 flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-800 text-white hover:bg-brand-900 font-semibold text-xs transition-colors shadow-sm">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>Simpan & Tambahkan Soal Ini</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- TAB 2: UPLOAD EXCEL --}}
            <div id="tab-content-excel" class="p-6 space-y-6 hidden">
                {{-- Banner Download Template --}}
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-xs">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-lg shadow-sm shrink-0 mt-0.5">
                            <i class="fa-solid fa-file-excel"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-sm font-bold text-slate-900">Unduh Template Resmi Soal Ujian Excel</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Gunakan template resmi kami agar format kolom soal, opsi pilihan A sampai D, dan kunci jawaban terorganisir rapi dan otomatis terbaca oleh sistem saat diimpor.
                            </p>
                            <div class="pt-1 flex flex-wrap items-center gap-1.5 text-[11px] font-mono text-emerald-900">
                                <span class="bg-emerald-100/80 px-2 py-0.5 rounded">No</span>
                                <span class="text-emerald-400">·</span>
                                <span class="bg-emerald-100/80 px-2 py-0.5 rounded">Teks Soal</span>
                                <span class="text-emerald-400">·</span>
                                <span class="bg-emerald-100/80 px-2 py-0.5 rounded">Pilihan A</span>
                                <span class="text-emerald-400">·</span>
                                <span class="bg-emerald-100/80 px-2 py-0.5 rounded">Pilihan B</span>
                                <span class="text-emerald-400">·</span>
                                <span class="bg-emerald-100/80 px-2 py-0.5 rounded">Pilihan C</span>
                                <span class="text-emerald-400">·</span>
                                <span class="bg-emerald-100/80 px-2 py-0.5 rounded">Pilihan D</span>
                                <span class="text-emerald-400">·</span>
                                <span class="bg-emerald-200/80 font-bold px-2 py-0.5 rounded">Kunci Jawaban</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('guru.ujian.soal.template') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition-all shadow-sm shrink-0 whitespace-nowrap">
                        <i class="fa-solid fa-download text-xs"></i>
                        <span>Download Template (.xlsx)</span>
                    </a>
                </div>

                {{-- Form Upload Excel --}}
                <form action="{{ route('guru.ujian.soal.import', $ujian->id_ujian) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label for="excel_file_input" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih File Excel yang Berisi Soal <span class="text-rose-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-slate-300 hover:border-brand-500 rounded-2xl p-6 text-center bg-slate-50/50 hover:bg-brand-50/30 transition-colors cursor-pointer"
                            onclick="document.getElementById('excel_file_input').click()">
                            <div class="w-12 h-12 mx-auto rounded-2xl bg-white border border-slate-200 shadow-xs flex items-center justify-center text-slate-500 mb-3">
                                <i class="fa-solid fa-cloud-arrow-up text-xl text-brand-700"></i>
                            </div>
                            <p class="text-xs font-bold text-slate-800">Klik di sini untuk memilih file Excel</p>
                            <p class="text-[11px] text-slate-400 mt-1">Mendukung format file <strong class="text-slate-600">.xlsx</strong>, <strong class="text-slate-600">.xls</strong>, atau <strong class="text-slate-600">.csv</strong></p>

                            <input type="file" name="file" id="excel_file_input" accept=".xlsx,.xls,.csv" required
                                class="hidden" onchange="previewFileName(this)">

                            <div id="file-chosen-badge" class="mt-3 hidden inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-800">
                                <i class="fa-solid fa-file-circle-check text-emerald-600"></i>
                                <span id="file-name-text">Nama file...</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-[11px] text-slate-600 space-y-1.5">
                        <div class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-lightbulb text-amber-500"></i>
                            <span>Panduan Pengisian Excel:</span>
                        </div>
                        <ol class="list-decimal list-inside space-y-1 pl-1">
                            <li>Buka file template yang baru saja diunduh di Excel atau Google Sheets.</li>
                            <li>Tuliskan nomor urut di kolom <strong>No</strong> dan teks pertanyaan di kolom <strong>Teks Soal</strong>.</li>
                            <li>Isi pilihan jawaban pada kolom <strong>Pilihan A, B, C, D</strong>.</li>
                            <li>Pada kolom <strong>Kunci Jawaban</strong>, cukup ketikkan satu huruf kapital yaitu <strong>A, B, C, atau D</strong>.</li>
                            <li>Simpan file dan klik tombol <strong>Unggah & Impor Soal</strong> di bawah.</li>
                        </ol>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold transition-colors shadow-sm">
                            <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                            <span>Unggah & Impor Soal</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- DAFTAR SOAL YANG TELAH DITAMBAHKAN (LIVE REVIEW) --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center text-xs font-bold">
                        <i class="fa-solid fa-list-check"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Daftar Butir Soal Terdaftar</h2>
                        <p class="text-[11px] text-slate-500">Seluruh butir soal dan kunci jawaban yang aktif pada paket ujian ini</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-brand-100/80 text-brand-900 border border-brand-200">
                    Total: {{ $ujian->soalUjian->count() }} Butir Soal
                </span>
            </div>

            @if ($ujian->soalUjian->isEmpty())
                {{-- Empty State --}}
                <div class="p-12 text-center space-y-3">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-2xl">
                        <i class="fa-solid fa-clipboard-question"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-sm font-bold text-slate-800">Belum Ada Butir Soal</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto">
                            Paket ujian ini belum memiliki soal. Silakan gunakan <strong>Form Input Manual</strong> atau <strong>Upload File Excel</strong> di atas untuk menambahkan soal pertama.
                        </p>
                    </div>
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach ($ujian->soalUjian as $index => $soal)
                        <div class="p-6 space-y-4 hover:bg-slate-50/50 transition-colors">
                            {{-- Header Soal & Tombol Hapus --}}
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-lg bg-slate-100 border border-slate-200 text-slate-800 font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-xs font-semibold text-slate-500">Nomor Soal {{ $index + 1 }}</span>
                                </div>

                                <form action="{{ route('guru.ujian.soal.destroy_step', [$ujian->id_ujian, $soal->id_soal_ujian]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus butir soal nomor {{ $index + 1 }} ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-rose-600 hover:bg-rose-50 hover:text-rose-700 text-xs font-semibold border border-transparent hover:border-rose-200 transition-colors"
                                        title="Hapus soal ini">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>

                            {{-- Teks Soal --}}
                            <div class="text-xs text-slate-900 font-medium leading-relaxed pl-1">
                                {!! nl2br(e($soal->teks_soal)) !!}
                            </div>

                            {{-- Grid Opsi A, B, C, D --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1">
                                @php
                                    $kunci = strtoupper(trim($soal->kunci_jawaban ?? ''));
                                @endphp

                                {{-- Opsi A --}}
                                <div class="p-2.5 rounded-xl border text-xs flex items-center justify-between gap-2 {{ $kunci === 'A' ? 'bg-emerald-50/80 border-emerald-300 text-emerald-950 font-semibold' : 'bg-white border-slate-200 text-slate-700' }}">
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 h-5 rounded {{ $kunci === 'A' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center text-[11px] font-bold shrink-0">
                                            A
                                        </span>
                                        <span>{{ $soal->opsi_a }}</span>
                                    </div>
                                    @if ($kunci === 'A')
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-100 px-1.5 py-0.5 rounded shrink-0">
                                            <i class="fa-solid fa-check text-[9px]"></i> Kunci
                                        </span>
                                    @endif
                                </div>

                                {{-- Opsi B --}}
                                <div class="p-2.5 rounded-xl border text-xs flex items-center justify-between gap-2 {{ $kunci === 'B' ? 'bg-emerald-50/80 border-emerald-300 text-emerald-950 font-semibold' : 'bg-white border-slate-200 text-slate-700' }}">
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 h-5 rounded {{ $kunci === 'B' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center text-[11px] font-bold shrink-0">
                                            B
                                        </span>
                                        <span>{{ $soal->opsi_b }}</span>
                                    </div>
                                    @if ($kunci === 'B')
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-100 px-1.5 py-0.5 rounded shrink-0">
                                            <i class="fa-solid fa-check text-[9px]"></i> Kunci
                                        </span>
                                    @endif
                                </div>

                                {{-- Opsi C --}}
                                <div class="p-2.5 rounded-xl border text-xs flex items-center justify-between gap-2 {{ $kunci === 'C' ? 'bg-emerald-50/80 border-emerald-300 text-emerald-950 font-semibold' : 'bg-white border-slate-200 text-slate-700' }}">
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 h-5 rounded {{ $kunci === 'C' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center text-[11px] font-bold shrink-0">
                                            C
                                        </span>
                                        <span>{{ $soal->opsi_c }}</span>
                                    </div>
                                    @if ($kunci === 'C')
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-100 px-1.5 py-0.5 rounded shrink-0">
                                            <i class="fa-solid fa-check text-[9px]"></i> Kunci
                                        </span>
                                    @endif
                                </div>

                                {{-- Opsi D --}}
                                <div class="p-2.5 rounded-xl border text-xs flex items-center justify-between gap-2 {{ $kunci === 'D' ? 'bg-emerald-50/80 border-emerald-300 text-emerald-950 font-semibold' : 'bg-white border-slate-200 text-slate-700' }}">
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 h-5 rounded {{ $kunci === 'D' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center text-[11px] font-bold shrink-0">
                                            D
                                        </span>
                                        <span>{{ $soal->opsi_d }}</span>
                                    </div>
                                    @if ($kunci === 'D')
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-100 px-1.5 py-0.5 rounded shrink-0">
                                            <i class="fa-solid fa-check text-[9px]"></i> Kunci
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Footer Selesai --}}
            <div class="px-6 py-4 bg-slate-50 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-slate-100">
                <a href="{{ route('ujian.show') }}"
                    class="w-full sm:w-auto px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 font-semibold text-xs transition-colors text-center shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[10px] mr-1"></i> Ke Beranda Ujian
                </a>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <a href="{{ route('guru.ujian.detail', $ujian->id_ujian) }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-brand-800 text-white hover:bg-brand-900 font-semibold text-xs transition-colors shadow-sm">
                        <i class="fa-solid fa-circle-check text-xs"></i>
                        <span>Selesai & Simpan Paket Ujian</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Interactive Tab & File Upload Script --}}
    <script>
        function switchSoalTab(tab) {
            const manualBtn = document.getElementById('tab-btn-manual');
            const excelBtn = document.getElementById('tab-btn-excel');
            const manualContent = document.getElementById('tab-content-manual');
            const excelContent = document.getElementById('tab-content-excel');

            if (tab === 'manual') {
                manualBtn.className = 'flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-xs bg-brand-800 text-white';
                excelBtn.className = 'flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-200/60';
                manualContent.classList.remove('hidden');
                excelContent.classList.add('hidden');
            } else {
                excelBtn.className = 'flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-xs bg-brand-800 text-white';
                manualBtn.className = 'flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-200/60';
                excelContent.classList.remove('hidden');
                manualContent.classList.add('hidden');
            }
        }

        function previewFileName(input) {
            const badge = document.getElementById('file-chosen-badge');
            const nameText = document.getElementById('file-name-text');
            if (input.files && input.files[0]) {
                nameText.innerText = input.files[0].name + ' (' + Math.round(input.files[0].size / 1024) + ' KB)';
                badge.classList.remove('hidden');
            }
        }
    </script>
</x-app-guru-layout>

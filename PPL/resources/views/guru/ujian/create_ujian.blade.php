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
                    Lengkapi informasi ujian sesuai dengan mata pelajaran dan kelas yang diampu.
                </p>
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

        {{-- Form Card (Sesuai Tabel Migrasi Ujian) --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <form action="{{ route('ujian.stored') }}" method="POST">
                @csrf

                <div class="p-6 space-y-5">
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
                            placeholder="Contoh: Penilaian Tengah Semester (UTS) - Matematika Kelas 7A"
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
                                <option value="UTS" {{ old('jenis_ujian') == 'UTS' ? 'selected' : '' }}>UTS (Ujian Tengah Semester)</option>
                                <option value="UAS" {{ old('jenis_ujian') == 'UAS' ? 'selected' : '' }}>UAS (Ujian Akhir Semester)</option>
                                <option value="Ulangan Harian" {{ old('jenis_ujian') == 'Ulangan Harian' ? 'selected' : '' }}>Ulangan Harian</option>
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

                    {{-- 5. Tanggal Dibuat --}}
                    <div>
                        <label for="tanggal_dibuat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Tanggal Dibuat <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="tanggal_dibuat" id="tanggal_dibuat" required
                            value="{{ old('tanggal_dibuat', date('Y-m-d')) }}"
                            class="w-full sm:w-1/2 px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors bg-white">
                    </div>

                    {{-- 6. Deskripsi Ujian --}}
                    <div>
                        <label for="deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Deskripsi Ujian <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" required
                            placeholder="Tuliskan petunjuk pengerjaan ujian atau instruksi penting bagi siswa..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('ujian.show') }}"
                        class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 font-semibold text-xs transition-colors shadow-sm">
                        Batal
                    </a>
                    <button type="submit" id="submitUjian"
                        class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-brand-800 text-white hover:bg-brand-900 font-semibold text-xs transition-colors shadow-sm">
                        <i class="fa-solid fa-check text-xs"></i>
                        <span>Simpan Ujian</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- Filter Topik Berdasarkan Kelas Mata Pelajaran Terpilih --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kmpSelect = document.getElementById('kelas_mata_pelajaran_id');
            const topikSelect = document.getElementById('topik_id');

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
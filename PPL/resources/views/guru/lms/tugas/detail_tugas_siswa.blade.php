<x-app-guru-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div>
            <a href="{{ route('guru.dashboard.lms.tugas.siswa', $tugas->id_tugas) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-800 transition-colors mb-2">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Daftar Pengumpulan</span>
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Penilaian Tugas Siswa</h1>
                    <p class="text-sm text-slate-500 mt-0.5">
                        Tugas: <span class="font-semibold text-slate-700">{{ $tugas->judul }}</span> • Kelas {{ $kelas->nama_kelas ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Flash Notification --}}
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- 2 Columns: Student Navigator (Left) + Grading Workspace (Right) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column: Student Roster Navigator --}}
            <div class="space-y-4">
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                    <h2 class="font-bold text-slate-900 text-sm mb-3 flex items-center justify-between">
                        <span>Daftar Siswa ({{ $siswaList->count() }})</span>
                        <span class="text-[11px] font-normal text-slate-400">Pilih untuk koreksi</span>
                    </h2>
                    <div class="space-y-1.5 max-h-[500px] overflow-y-auto pr-1">
                        @foreach ($siswaList as $s)
                            @php
                                $sub = $pengumpulanTugas->firstWhere('siswa_id', $s->id_siswa);
                                $isCurrent = $sub && $sub->id_pengumpulan_tugas === $pengumpulan->id_pengumpulan_tugas;
                            @endphp
                            @if ($sub)
                                <a href="{{ route('guru.dashboard.lms.tugas.siswa.detail', $sub->id_pengumpulan_tugas) }}"
                                    class="flex items-center justify-between p-2.5 rounded-xl text-xs transition-colors {{ $isCurrent ? 'bg-brand-50 border border-brand-200 text-brand-900 font-semibold' : 'hover:bg-slate-50 text-slate-700' }}">
                                    <span class="truncate max-w-[150px]">{{ $s->nama_siswa }}</span>
                                    @if ($sub->nilai !== null)
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            {{ $sub->nilai }}
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-amber-100 text-amber-800">
                                            Belum Dinilai
                                        </span>
                                    @endif
                                </a>
                            @else
                                <div class="flex items-center justify-between p-2.5 rounded-xl text-xs text-slate-400">
                                    <span class="truncate max-w-[150px]">{{ $s->nama_siswa }}</span>
                                    <span class="text-[10px] italic">Belum Kirim</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Column (2 cols): Submission & Grading Form --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Submission Detail Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-5">
                    
                    {{-- Student Identity Header --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user-graduate text-slate-500 text-base"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-slate-900 text-base">{{ $pengumpulan->siswa->nama_siswa }}</h2>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Diserahkan: {{ !empty($pengumpulan->tanggal_pengumpulan) ? \Carbon\Carbon::parse($pengumpulan->tanggal_pengumpulan)->format('d F Y, H:i') . ' WIB' : '-' }}
                                </p>
                            </div>
                        </div>

                        <div>
                            @if ($pengumpulan->status == 'terlambat diserahkan')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                    <i class="fa-regular fa-clock text-[10px]"></i> Terlambat
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <i class="fa-solid fa-check text-[10px]"></i> Diserahkan Tepat Waktu
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Attached Files --}}
                    <div class="space-y-3">
                        <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Berkas Lampiran Siswa</h3>
                        
                        @if ($pengumpulan->pengumpulanTugasFile->isNotEmpty())
                            <div class="space-y-2">
                                @foreach ($pengumpulan->pengumpulanTugasFile as $file)
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-slate-100/80 transition-colors">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-brand-700 flex items-center justify-center shrink-0">
                                                <i class="fa-regular fa-file-lines text-sm"></i>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-800 truncate">{{ $file->original_name }}</span>
                                        </div>
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-brand-50 hover:text-brand-700 hover:border-brand-300 transition-colors shadow-sm shrink-0">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                            <span>Buka Berkas</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-400 italic p-4 rounded-xl bg-slate-50 text-center">
                                Siswa tidak menyertakan berkas lampiran.
                            </p>
                        @endif
                    </div>

                    {{-- Grading Form --}}
                    <div class="pt-5 border-t border-slate-100 space-y-4">
                        <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-award text-amber-500"></i>
                            Input Nilai & Komentar Pendidik
                        </h3>

                        <form action="{{ route('guru.dashboard.lms.tugas.siswa.update', $pengumpulan->id_pengumpulan_tugas) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="nilai" class="block text-xs font-semibold text-slate-700 mb-1">
                                        Nilai Tugas (Skala 0 - 100) <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="number" name="nilai" id="nilai" min="0" max="100" required
                                        value="{{ $pengumpulan->nilai }}"
                                        placeholder="Contoh: 85"
                                        class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 font-bold focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                                </div>
                            </div>

                            <div>
                                <label for="komentar" class="block text-xs font-semibold text-slate-700 mb-1">
                                    Catatan / Feedback untuk Siswa
                                </label>
                                <textarea name="komentar" id="komentar" rows="3"
                                    placeholder="Berikan apresiasi atau catatan perbaikan untuk siswa..."
                                    class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">{{ $pengumpulan->komentar }}</textarea>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-semibold bg-brand-800 text-white hover:bg-brand-900 transition-colors shadow-sm">
                                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                                    <span>Simpan Penilaian</span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>
</x-app-guru-layout>

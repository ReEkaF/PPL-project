<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Top Navigation Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('siswa.dashboard.lms.tugas') }}"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-brand-800 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <div class="flex items-center gap-1.5 text-xs text-slate-400">
                        <a href="{{ route('siswa.dashboard') }}" class="hover:text-brand-700 transition-colors">Dashboard</a>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                        <a href="{{ route('siswa.lms.dashboard') }}" class="hover:text-brand-700 transition-colors">LMS</a>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                        <a href="{{ route('siswa.dashboard.lms.tugas') }}" class="hover:text-brand-700 transition-colors">Tugas</a>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                        <span class="text-slate-600 font-medium">Detail</span>
                    </div>
                    <h1 class="text-lg font-bold text-slate-900 mt-0.5">Tugas Pembelajaran</h1>
                </div>
            </div>

            {{-- Forum Shortcut --}}
            @if ($tugas->kelas_mata_pelajaran_id)
                <a href="{{ route('siswa.lms.forum', ['id' => $tugas->kelas_mata_pelajaran_id]) }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-brand-50 hover:text-brand-800 hover:border-brand-200 transition-all shadow-sm self-start sm:self-auto">
                    <i class="fa-solid fa-comments text-brand-700 text-xs"></i>
                    <span>Tanya di Forum Kelas</span>
                </a>
            @endif
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between gap-3 text-xs shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between gap-3 text-xs shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{-- Hero Header Card --}}
        <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 overflow-hidden bg-gradient-to-br from-white via-white to-slate-50/50">

            {{-- Metadata Badges Row --}}
            <div class="flex flex-wrap items-center gap-2 mb-4">
                {{-- Kelas Badge --}}
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-800 border border-brand-200/70">
                    <i class="fa-solid fa-users text-[11px]"></i>
                    Kelas {{ $tugas->kelasMataPelajaran->kelas->nama_kelas ?? 'Kelas' }}
                </span>

                {{-- Mapel Badge --}}
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    <i class="fa-solid fa-book-open text-[11px] text-brand-700"></i>
                    {{ $tugas->kelasMataPelajaran->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }}
                </span>

                {{-- Topik / Bab Badge --}}
                @if ($tugas->topik)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-800 border border-purple-200/70">
                        <i class="fa-solid fa-bookmark text-[11px] text-purple-600"></i>
                        {{ $tugas->topik->judul_topik }}
                    </span>
                @endif

                {{-- Status Badge --}}
                @php
                    $isSubmitted = (bool) $pengumpulan;
                    $isGraded = $isSubmitted && ($pengumpulan->nilai !== null);
                    $isLate = false;
                    $deadlinePassed = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($tugas->deadline));

                    if ($isSubmitted) {
                        $submittedAt = \Carbon\Carbon::parse($pengumpulan->created_at ?? $pengumpulan->tanggal_pengumpulan);
                        $isLate = $submittedAt->gt(\Carbon\Carbon::parse($tugas->deadline));
                    }
                @endphp

                @if ($isGraded)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <i class="fa-solid fa-award text-emerald-600 text-[11px]"></i>
                        Dinilai: {{ $pengumpulan->nilai }}/100
                    </span>
                @elseif ($isSubmitted)
                    @if ($isLate)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                            <i class="fa-solid fa-clock text-amber-600 text-[11px]"></i>
                            Diserahkan Terlambat
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-[11px]"></i>
                            Sudah Diserahkan
                        </span>
                    @endif
                @else
                    @if ($deadlinePassed)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                            <i class="fa-solid fa-triangle-exclamation text-rose-600 text-[11px]"></i>
                            Belum Diserahkan (Lewat Batas)
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200">
                            <i class="fa-solid fa-hourglass-half text-sky-600 text-[11px]"></i>
                            Ditugaskan
                        </span>
                    @endif
                @endif
            </div>

            {{-- Title --}}
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                {{ $tugas->judul }}
            </h2>

            {{-- Teacher & Timestamp Footer --}}
            <div class="flex flex-wrap items-center gap-4 sm:gap-6 mt-6 pt-5 border-t border-slate-100 text-xs text-slate-500">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-brand-100 text-brand-800 flex items-center justify-center font-bold text-xs">
                        {{ strtoupper(substr($tugas->kelasMataPelajaran->guru->nama_guru ?? 'G', 0, 1)) }}
                    </div>
                    <div>
                        <span class="text-slate-400">Guru Pengampu:</span>
                        <span class="font-bold text-slate-800 ml-1">
                            {{ $tugas->kelasMataPelajaran->guru->nama_guru ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 text-slate-500">
                    <i class="fa-regular fa-calendar text-slate-400"></i>
                    <span>Diberikan: {{ $tugas->created_at ? $tugas->created_at->translatedFormat('d F Y · H:i') . ' WIB' : '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Deadline Alert Banner --}}
        @if ($isSubmitted)
            <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200 text-emerald-800 flex items-center justify-between gap-4 text-xs shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shrink-0">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <p class="font-bold text-emerald-900">Tugas Anda Sudah Berhasil Diserahkan</p>
                        <p class="text-emerald-700 text-[11px] mt-0.5">
                            Waktu pengumpulan: {{ \Carbon\Carbon::parse($pengumpulan->created_at ?? $pengumpulan->tanggal_pengumpulan)->translatedFormat('l, d F Y · H:i') }} WIB
                            @if ($isLate)
                                <span class="text-amber-700 font-semibold">(Melewati batas waktu)</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @else
            @if ($deadlinePassed)
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center gap-3 text-xs shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center text-sm font-bold shrink-0">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <p class="font-bold text-rose-900">Batas Waktu Pengumpulan Telah Berakhir</p>
                        <p class="text-rose-700 text-[11px] mt-0.5">
                            Tenggat waktu: {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('l, d F Y · H:i') }} WIB ({{ \Carbon\Carbon::parse($tugas->deadline)->diffForHumans() }})
                        </p>
                    </div>
                </div>
            @else
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 flex items-center justify-between gap-4 text-xs shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-bold shrink-0">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div>
                            <p class="font-bold text-amber-900">Batas Waktu Pengumpulan Tugas</p>
                            <p class="text-amber-700 text-[11px] mt-0.5">
                                {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('l, d F Y · H:i') }} WIB
                                <span class="font-semibold">({{ \Carbon\Carbon::parse($tugas->deadline)->diffForHumans() }})</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        {{-- Main 2-Column Grid Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column (2 cols): Instruksi Tugas & Lampiran Guru --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Deskripsi / Instruksi Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7">
                    <div class="flex items-center justify-between pb-3.5 mb-5 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center text-sm font-semibold">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">Petunjuk & Instruksi Pengerjaan</h3>
                                <p class="text-[11px] text-slate-400">Bacalah instruksi pengerjaan dari guru secara teliti</p>
                            </div>
                        </div>
                    </div>

                    @if (!empty(trim(strip_tags($tugas->deskripsi))))
                        <div class="prose prose-slate max-w-none text-slate-700 text-sm leading-relaxed space-y-3">
                            {!! $tugas->deskripsi !!}
                        </div>
                    @else
                        <div class="py-8 text-center bg-slate-50/60 rounded-xl border border-dashed border-slate-200">
                            <i class="fa-regular fa-file-lines text-slate-300 text-3xl mb-2 block"></i>
                            <p class="text-xs text-slate-500 font-medium">Tidak ada rincian teks tambahan.</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Silakan kerjakan sesuai berkas lampiran soal di bawah.</p>
                        </div>
                    @endif
                </div>

                {{-- Lampiran dari Guru Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7">
                    <div class="flex items-center justify-between pb-3.5 mb-5 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center text-sm font-semibold">
                                <i class="fa-solid fa-paperclip"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">Lampiran Berkas dari Guru</h3>
                                <p class="text-[11px] text-slate-400">Lembar kerja, petunjuk pengerjaan, atau template tugas</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                            {{ $filetugas->count() }} Berkas
                        </span>
                    </div>

                    @if ($filetugas->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            @foreach ($filetugas as $file)
                                @php
                                    $ext = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
                                    $parts = explode('/', $file->file_path);
                                    $rawName = end($parts);
                                    $displayName = $file->original_name ?? (strlen($rawName) > 11 ? substr($rawName, 11) : $rawName);

                                    $iconConfig = match($ext) {
                                        'pdf' => ['icon' => 'fa-solid fa-file-pdf', 'class' => 'text-rose-600 bg-rose-50 border-rose-200'],
                                        'doc', 'docx' => ['icon' => 'fa-solid fa-file-word', 'class' => 'text-blue-600 bg-blue-50 border-blue-200'],
                                        'ppt', 'pptx' => ['icon' => 'fa-solid fa-file-powerpoint', 'class' => 'text-amber-600 bg-amber-50 border-amber-200'],
                                        'xls', 'xlsx' => ['icon' => 'fa-solid fa-file-excel', 'class' => 'text-emerald-600 bg-emerald-50 border-emerald-200'],
                                        'jpg', 'jpeg', 'png', 'gif', 'webp' => ['icon' => 'fa-solid fa-file-image', 'class' => 'text-purple-600 bg-purple-50 border-purple-200'],
                                        'zip', 'rar', '7z' => ['icon' => 'fa-solid fa-file-zipper', 'class' => 'text-amber-700 bg-amber-50 border-amber-200'],
                                        default => ['icon' => 'fa-solid fa-file-lines', 'class' => 'text-slate-600 bg-slate-50 border-slate-200'],
                                    };
                                @endphp

                                <div class="flex items-center justify-between p-3.5 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-brand-300 hover:shadow-sm transition-all group">
                                    <div class="flex items-center gap-3 min-w-0 pr-2">
                                        <div class="w-10 h-10 rounded-xl {{ $iconConfig['class'] }} border flex items-center justify-center text-lg shrink-0">
                                            <i class="{{ $iconConfig['icon'] }}"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-slate-800 truncate group-hover:text-brand-800 transition-colors" title="{{ $displayName }}">
                                                {{ $displayName }}
                                            </p>
                                            <span class="inline-flex items-center text-[10px] font-semibold uppercase text-slate-400 tracking-wider mt-0.5">
                                                .{{ $ext }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1.5 shrink-0">
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                            title="Buka / Preview"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-brand-50 hover:text-brand-800 hover:border-brand-200 transition-colors">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
                                        </a>
                                        <a href="{{ asset('storage/' . $file->file_path) }}" download="{{ $displayName }}"
                                            title="Unduh Berkas"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-brand-50 hover:text-brand-800 hover:border-brand-200 transition-colors">
                                            <i class="fa-solid fa-download text-[11px]"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-8 text-center bg-slate-50/60 rounded-xl border border-dashed border-slate-200">
                            <i class="fa-solid fa-folder-open text-slate-300 text-3xl mb-2 block"></i>
                            <p class="text-xs text-slate-500 font-medium">Tidak ada lampiran berkas dari guru untuk tugas ini.</p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- Right Column (1 col): Panel Penyerahan & Penilaian --}}
            <div class="space-y-6">

                {{-- Penilaian Guru (Jika Sudah Dinilai) --}}
                @if ($pengumpulan && $pengumpulan->nilai !== null)
                    <div class="bg-white rounded-2xl border border-emerald-200 shadow-sm p-6 overflow-hidden relative">

                        <h3 class="font-bold text-slate-900 text-sm pb-3 mb-4 border-b border-slate-100 flex items-center justify-between">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-medal text-amber-500"></i>
                                <span>Hasil Penilaian Guru</span>
                            </span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Sudah Dinilai
                            </span>
                        </h3>

                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 flex flex-col items-center justify-center shrink-0 shadow-inner">
                                <span class="text-2xl font-black text-emerald-700 leading-none">{{ $pengumpulan->nilai }}</span>
                                <span class="text-[10px] font-bold text-emerald-600 mt-1">/ 100</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Nilai Akhir Tugas</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">
                                    {{ $pengumpulan->nilai >= 75 ? 'Tuntas Melampaui KKM' : 'Perlu Peningkatan' }}
                                </p>
                            </div>
                        </div>

                        @if (!empty($pengumpulan->komentar))
                            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-700 space-y-1">
                                <div class="flex items-center gap-1.5 font-bold text-slate-600 text-[11px]">
                                    <i class="fa-solid fa-comment-dots text-brand-600"></i>
                                    <span>Catatan & Umpan Balik Guru:</span>
                                </div>
                                <p class="text-slate-700 italic pl-4 border-l-2 border-brand-300">
                                    "{{ $pengumpulan->komentar }}"
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Panel Pengumpulan Tugas Saya --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-file-arrow-up text-brand-700"></i>
                            <h3 class="font-bold text-slate-900 text-sm">Pengumpulan Saya</h3>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $status_color }}">
                            {{ $status_text }}
                        </span>
                    </div>

                    {{-- Berkas yang Telah Dikumpulkan --}}
                    @if ($pengumpulan && $pengumpulan->pengumpulanTugasFile->count() > 0)
                        <div class="space-y-2.5 mb-5">
                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Berkas Terkirim:</p>
                            @foreach ($pengumpulan->pengumpulanTugasFile as $file)
                                @php
                                    $ext = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
                                @endphp
                                <div class="flex items-center justify-between p-3 bg-slate-50/80 border border-slate-200 rounded-xl hover:bg-white transition-colors group">
                                    <div class="flex items-center gap-2.5 min-w-0 pr-2">
                                        <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center text-xs shrink-0">
                                            <i class="fa-solid fa-file"></i>
                                        </div>
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                            class="text-xs font-semibold text-slate-700 hover:text-brand-800 truncate transition-colors" title="{{ $file->original_name }}">
                                            {{ $file->original_name }}
                                        </a>
                                    </div>

                                    @if ($pengumpulan->nilai === null)
                                        <button type="button" onclick="confirmDeleteFile('{{ route('siswa.dashboard.lms.tugas.file.delete', $file->id_pengumpulan_tugas_file) }}', '{{ $file->original_name }}')"
                                            title="Hapus berkas ini"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors shrink-0">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Form Penyerahan atau Tombol Pembatalan --}}
                    @if ($pengumpulan)
                        @if ($pengumpulan->nilai === null)
                            <form id="batal-penyerahan-form" action="{{ route('siswa.dashboard.lms.tugas.batal', $pengumpulan->id_pengumpulan_tugas) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmBatalPenyerahan()"
                                    class="w-full py-2.5 px-4 text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 rounded-xl hover:bg-rose-100 hover:border-rose-300 transition-all shadow-sm flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-rotate-left text-xs"></i>
                                    <span>Batalkan Penyerahan Tugas</span>
                                </button>
                            </form>
                            <p class="text-[10px] text-slate-400 text-center mt-2">
                                Anda dapat membatalkan penyerahan untuk mengunggah ulang selama tugas belum dinilai guru.
                            </p>
                        @else
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-center text-xs text-slate-500 font-medium">
                                <i class="fa-solid fa-lock text-slate-400 mr-1"></i>
                                Tugas ini telah dinilai oleh guru dan tidak dapat diubah kembali.
                            </div>
                        @endif
                    @else
                        {{-- Form Upload Pengumpulan Tugas Baru --}}
                        <form id="form-submit-tugas" action="{{ route('siswa.dashboard.lms.submit.tugas', $tugas->id_tugas) }}"
                            method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            {{-- Dropzone / Upload Area --}}
                            <label for="files"
                                class="block cursor-pointer border-2 border-dashed border-slate-300 rounded-2xl p-6 text-center hover:border-brand-500 hover:bg-brand-50/40 transition-all group bg-slate-50/40">
                                <input type="file" id="files" name="files[]" class="sr-only" multiple accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar">
                                <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-400 group-hover:text-brand-700 group-hover:border-brand-200 flex items-center justify-center mx-auto mb-3 transition-colors shadow-sm">
                                    <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                </div>
                                <p class="text-xs font-bold text-slate-800 group-hover:text-brand-800 transition-colors">
                                    Klik atau seret file tugas ke sini
                                </p>
                                <p class="text-[10px] text-slate-400 mt-1">
                                    PDF, DOC, DOCX, PPT, PPTX, XLS, ZIP · Maks. 10MB
                                </p>
                            </label>

                            {{-- Daftar File yang Dipilih Sebelum Disubmit --}}
                            <div id="file-list" class="space-y-2"></div>

                            {{-- Submit Button --}}
                            <button type="submit" id="btn-submit-tugas"
                                class="w-full py-3 px-4 text-xs font-bold text-white bg-brand-800 hover:bg-brand-900 rounded-xl transition-all shadow-sm hover:shadow flex items-center justify-center gap-2">
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                <span>Kumpulkan Tugas</span>
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Informasi Singkat Rombel --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-bold text-slate-900 text-sm pb-3 mb-4 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-brand-700"></i>
                        <span>Informasi Pembelajaran</span>
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400">Kelas</span>
                            <span class="font-bold text-slate-800">
                                {{ $tugas->kelasMataPelajaran->kelas->nama_kelas ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400">Mata Pelajaran</span>
                            <span class="font-bold text-slate-800">
                                {{ $tugas->kelasMataPelajaran->mataPelajaran->nama_matpel ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400">Guru Pengampu</span>
                            <span class="font-bold text-slate-800">
                                {{ $tugas->kelasMataPelajaran->guru->nama_guru ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-1">
                            <span class="text-slate-400">Topik / Modul</span>
                            <span class="font-bold text-slate-800 text-right truncate max-w-[160px]" title="{{ $tugas->topik->judul_topik ?? '-' }}">
                                {{ $tugas->topik->judul_topik ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-siswa-layout>

{{-- SweetAlert2 for Interactive Confirmation --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // File upload management for students
    document.addEventListener('DOMContentLoaded', function () {
        let selectedFiles = [];
        const fileInput = document.getElementById('files');
        const fileList = document.getElementById('file-list');
        const formSubmit = document.getElementById('form-submit-tugas');
        if (!fileInput) return;

        const maxSize = 10 * 1024 * 1024; // 10MB

        fileInput.addEventListener('change', function () {
            const newFiles = Array.from(this.files).filter(f => {
                if (f.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran Terlalu Besar',
                        text: `File "${f.name}" melebihi batas maksimal 10MB.`,
                        customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl text-xs font-semibold px-4 py-2' }
                    });
                    return false;
                }
                return true;
            });
            selectedFiles = [...selectedFiles, ...newFiles];
            renderSelectedFiles();
        });

        function renderSelectedFiles() {
            if (!fileList) return;
            fileList.innerHTML = '';
            selectedFiles.forEach((f, i) => {
                const sizeKb = (f.size / 1024).toFixed(0);
                fileList.insertAdjacentHTML('beforeend', `
                    <div class="flex items-center justify-between p-3 bg-brand-50/50 border border-brand-200 rounded-xl text-xs group">
                        <div class="flex items-center gap-2.5 min-w-0 pr-2">
                            <div class="w-7 h-7 rounded-lg bg-brand-100 text-brand-700 flex items-center justify-center text-xs shrink-0 font-bold">
                                <i class="fa-solid fa-file"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-slate-800 truncate">${f.name}</p>
                                <span class="text-[10px] text-slate-400">${sizeKb} KB</span>
                            </div>
                        </div>
                        <button type="button" onclick="removeSelectedFile(${i})"
                            class="w-6 h-6 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-colors shrink-0">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </div>`);
            });
        }

        window.removeSelectedFile = function (i) {
            selectedFiles.splice(i, 1);
            renderSelectedFiles();
        };

        if (formSubmit) {
            formSubmit.addEventListener('submit', function (e) {
                if (selectedFiles.length === 0 && fileInput.files.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Berkas Tugas',
                        text: 'Silakan pilih atau unggah minimal satu berkas tugas Anda terlebih dahulu.',
                        customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl text-xs font-semibold px-4 py-2' }
                    });
                }
            });
        }
    });

    // Confirmation for cancelling submission
    function confirmBatalPenyerahan() {
        Swal.fire({
            title: 'Batalkan Penyerahan Tugas?',
            text: 'Tugas yang telah diserahkan akan ditarik kembali dan Anda dapat mengunggah berkas baru.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Batalkan Penyerahan',
            cancelButtonText: 'Tutup',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl text-xs font-semibold px-4 py-2.5',
                cancelButton: 'rounded-xl text-xs font-semibold px-4 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('batal-penyerahan-form').submit();
            }
        });
    }

    // Confirmation for deleting single uploaded file
    function confirmDeleteFile(url, fileName) {
        Swal.fire({
            title: 'Hapus Berkas Ini?',
            text: `Berkas "${fileName}" akan dihapus dari pengumpulan tugas Anda.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus File',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl text-xs font-semibold px-4 py-2.5',
                cancelButton: 'rounded-xl text-xs font-semibold px-4 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>

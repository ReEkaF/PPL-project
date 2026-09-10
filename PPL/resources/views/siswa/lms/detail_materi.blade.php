<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Top Navigation Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('siswa.lms.materi.index') }}"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-brand-800 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <div class="flex items-center gap-1.5 text-xs text-slate-400">
                        <a href="{{ route('siswa.dashboard') }}" class="hover:text-brand-700 transition-colors">Dashboard</a>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                        <a href="{{ route('siswa.lms.dashboard') }}" class="hover:text-brand-700 transition-colors">LMS</a>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                        <a href="{{ route('siswa.lms.materi.index') }}" class="hover:text-brand-700 transition-colors">Materi</a>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                        <span class="text-slate-600 font-medium">Detail</span>
                    </div>
                    <h1 class="text-lg font-bold text-slate-900 mt-0.5">Materi Pembelajaran</h1>
                </div>
            </div>

            {{-- Forum Shortcut --}}
            @if ($materi->kelas_mata_pelajaran_id)
                <a href="{{ route('siswa.lms.forum', ['id' => $materi->kelas_mata_pelajaran_id]) }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-brand-50 hover:text-brand-800 hover:border-brand-200 transition-all shadow-sm self-start sm:self-auto">
                    <i class="fa-solid fa-comments text-brand-700 text-xs"></i>
                    <span>Diskusi di Forum Kelas</span>
                </a>
            @endif
        </div>

        {{-- Hero Header Card --}}
        <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 overflow-hidden ">
            {{-- Accent Top Border --}}

            {{-- Metadata Badges Row --}}
            <div class="flex flex-wrap items-center gap-2 mb-4">
                {{-- Kelas Badge --}}
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-800 border border-brand-200/70">
                    <i class="fa-solid fa-users text-[11px]"></i>
                    Kelas {{ $materi->kelasMataPelajaran->kelas->nama_kelas ?? 'Kelas' }}
                </span>

                {{-- Mapel Badge --}}
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    <i class="fa-solid fa-book-open text-[11px] text-brand-700"></i>
                    {{ $materi->kelasMataPelajaran->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }}
                </span>

                {{-- Topik / Bab Badge --}}
                @if ($materi->topik)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200/70">
                        <i class="fa-solid fa-bookmark text-[11px] text-amber-600"></i>
                        {{ $materi->topik->judul_topik }}
                    </span>
                @endif
            </div>

            {{-- Title --}}
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                {{ $materi->judul_materi }}
            </h2>

            {{-- Teacher & Timestamp Footer --}}
            <div class="flex flex-wrap items-center gap-4 sm:gap-6 mt-6 pt-5 border-t border-slate-100 text-xs text-slate-500">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-brand-100 text-brand-800 flex items-center justify-center font-bold text-xs">
                        {{ strtoupper(substr($materi->kelasMataPelajaran->guru->nama_guru ?? 'G', 0, 1)) }}
                    </div>
                    <div>
                        <span class="text-slate-400">Guru Pengampu:</span>
                        <span class="font-bold text-slate-800 ml-1">
                            {{ $materi->kelasMataPelajaran->guru->nama_guru ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 text-slate-500">
                    <i class="fa-regular fa-calendar-check text-slate-400"></i>
                    <span>Diterbitkan: {{ $materi->created_at ? $materi->created_at->translatedFormat('d F Y · H:i') . ' WIB' : '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Main 2-Column Grid Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column (2 cols): Isi Materi & Dokumen Lampiran --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Deskripsi / Isi Materi Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7">
                    <div class="flex items-center justify-between pb-3.5 mb-5 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center text-sm font-semibold">
                                <i class="fa-solid fa-book-reader"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">Uraian & Bahan Pembelajaran</h3>
                                <p class="text-[11px] text-slate-400">Pelajari instruksi dan rangkuman bacaan berikut</p>
                            </div>
                        </div>
                    </div>

                    @if (!empty(trim(strip_tags($materi->deskripsi))))
                        <div class="prose prose-slate max-w-none text-slate-700 text-sm leading-relaxed space-y-3">
                            {!! $materi->deskripsi !!}
                        </div>
                    @else
                        <div class="py-8 text-center bg-slate-50/60 rounded-xl border border-dashed border-slate-200">
                            <i class="fa-regular fa-file-lines text-slate-300 text-3xl mb-2 block"></i>
                            <p class="text-xs text-slate-500 font-medium">Tidak ada uraian tertulis pada materi ini.</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Silakan langsung pelajari dokumen atau berkas lampiran yang tersedia di bawah.</p>
                        </div>
                    @endif
                </div>

                {{-- Lampiran Berkas Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7">
                    <div class="flex items-center justify-between pb-3.5 mb-5 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center text-sm font-semibold">
                                <i class="fa-solid fa-paperclip"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">Dokumen & Berkas Lampiran</h3>
                                <p class="text-[11px] text-slate-400">Unduh atau buka file penunjang belajar yang diberikan guru</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                            {{ count($file_materi) }} Berkas
                        </span>
                    </div>

                    @if (count($file_materi))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            @foreach ($file_materi as $item)
                                @php
                                    $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                                    $parts = explode('/', $item->file_path);
                                    $rawName = end($parts);
                                    $displayName = $item->original_name ?? (strlen($rawName) > 11 ? substr($rawName, 11) : $rawName);

                                    // Icon styling based on file extension
                                    $iconConfig = match($ext) {
                                        'pdf' => ['icon' => 'fa-solid fa-file-pdf', 'class' => 'text-rose-600 bg-rose-50 border-rose-200'],
                                        'doc', 'docx' => ['icon' => 'fa-solid fa-file-word', 'class' => 'text-blue-600 bg-blue-50 border-blue-200'],
                                        'ppt', 'pptx' => ['icon' => 'fa-solid fa-file-powerpoint', 'class' => 'text-amber-600 bg-amber-50 border-amber-200'],
                                        'xls', 'xlsx' => ['icon' => 'fa-solid fa-file-excel', 'class' => 'text-emerald-600 bg-emerald-50 border-emerald-200'],
                                        'jpg', 'jpeg', 'png', 'gif', 'webp' => ['icon' => 'fa-solid fa-file-image', 'class' => 'text-purple-600 bg-purple-50 border-purple-200'],
                                        'mp4', 'mkv', 'avi' => ['icon' => 'fa-solid fa-file-video', 'class' => 'text-sky-600 bg-sky-50 border-sky-200'],
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
                                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                            title="Buka / Preview"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-brand-50 hover:text-brand-800 hover:border-brand-200 transition-colors">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
                                        </a>
                                        <a href="{{ asset('storage/' . $item->file_path) }}" download="{{ $displayName }}"
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
                            <p class="text-xs text-slate-500 font-medium">Tidak ada berkas lampiran tambahan pada materi ini.</p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- Right Column (1 col): Ringkasan Rombel & Pintasan LMS --}}
            <div class="space-y-6">

                {{-- Informasi Kelas Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-bold text-slate-900 text-sm pb-3 mb-4 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-chalkboard text-brand-700"></i>
                        <span>Informasi Kelas</span>
                    </h3>

                    <div class="space-y-3.5 text-xs">
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400">Rombel / Kelas</span>
                            <span class="font-bold text-slate-800">
                                {{ $materi->kelasMataPelajaran->kelas->nama_kelas ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400">Mata Pelajaran</span>
                            <span class="font-bold text-slate-800">
                                {{ $materi->kelasMataPelajaran->mataPelajaran->nama_matpel ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400">Guru Pengampu</span>
                            <span class="font-bold text-slate-800">
                                {{ $materi->kelasMataPelajaran->guru->nama_guru ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-1">
                            <span class="text-slate-400">Topik / Bab</span>
                            <span class="font-bold text-slate-800 text-right truncate max-w-[160px]" title="{{ $materi->topik->judul_topik ?? '-' }}">
                                {{ $materi->topik->judul_topik ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Navigasi Pintasan Kelas --}}
                @if ($materi->kelas_mata_pelajaran_id)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                        <h3 class="font-bold text-slate-900 text-sm pb-3 mb-3 border-b border-slate-100 flex items-center gap-2">
                            <i class="fa-solid fa-compass text-brand-700"></i>
                            <span>Pintasan Rombel Ini</span>
                        </h3>

                        <div class="space-y-2">
                            <a href="{{ route('siswa.lms.forum', ['id' => $materi->kelas_mata_pelajaran_id]) }}"
                                class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-brand-300 hover:bg-brand-50/50 text-slate-700 hover:text-brand-800 transition-all text-xs font-semibold group">
                                <div class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-comments text-brand-700"></i>
                                    <span>Forum Diskusi Kelas</span>
                                </div>
                                <i class="fa-solid fa-arrow-right text-[11px] text-slate-400 group-hover:text-brand-700 transition-colors"></i>
                            </a>

                            <a href="{{ route('siswa.lms.forum.tugas', ['id' => $materi->kelas_mata_pelajaran_id]) }}"
                                class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-brand-300 hover:bg-brand-50/50 text-slate-700 hover:text-brand-800 transition-all text-xs font-semibold group">
                                <div class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-clipboard-list text-brand-700"></i>
                                    <span>Tugas di Kelas Ini</span>
                                </div>
                                <i class="fa-solid fa-arrow-right text-[11px] text-slate-400 group-hover:text-brand-700 transition-colors"></i>
                            </a>

                            <a href="{{ route('siswa.lms.forum.anggota', ['id' => $materi->kelas_mata_pelajaran_id]) }}"
                                class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-brand-300 hover:bg-brand-50/50 text-slate-700 hover:text-brand-800 transition-all text-xs font-semibold group">
                                <div class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-users text-brand-700"></i>
                                    <span>Teman Sekelas</span>
                                </div>
                                <i class="fa-solid fa-arrow-right text-[11px] text-slate-400 group-hover:text-brand-700 transition-colors"></i>
                            </a>
                        </div>
                    </div>
                @endif

            </div>

        </div>

    </div>
</x-siswa-layout>

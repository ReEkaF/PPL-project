<x-app-guru-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Top Navigation Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('guru.lms.materi.index') }}"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-brand-800 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <div class="flex items-center gap-1.5 text-xs text-slate-400">
                        <a href="{{ route('guru.dashboard') }}" class="hover:text-brand-700 transition-colors">Dashboard</a>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                        <a href="{{ route('guru.lms.dashboard') }}" class="hover:text-brand-700 transition-colors">LMS</a>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                        <a href="{{ route('guru.lms.materi.index') }}" class="hover:text-brand-700 transition-colors">Materi</a>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                        <span class="text-slate-600 font-medium">Detail</span>
                    </div>
                    <h1 class="text-lg font-bold text-slate-900 mt-0.5">Detail Materi Pembelajaran</h1>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2.5 self-start sm:self-auto">
                <a href="{{ route('guru.lms.materi.edit', ['id' => $materi->id_materi]) }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-brand-50 hover:text-brand-800 hover:border-brand-200 transition-all shadow-sm">
                    <i class="fa-solid fa-pen-to-square text-brand-700 text-xs"></i>
                    <span>Edit Materi</span>
                </a>

                <button type="button" onclick="confirmDelete()"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-100 hover:border-rose-300 transition-all shadow-sm">
                    <i class="fa-solid fa-trash-can text-rose-600 text-xs"></i>
                    <span>Hapus</span>
                </button>

                {{-- Hidden Form for Delete Action --}}
                <form id="delete-materi-form" action="{{ route('guru.lms.materi.destroy', ['id' => $materi->id_materi]) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
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

        {{-- Hero Header Card --}}
        <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 overflow-hidden bg-gradient-to-br from-white via-white to-slate-50/50">
            {{-- Accent Top Border --}}
            <div class="absolute top-0 left-0 right-0 h-1.5"></div>

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

                {{-- Status Badge --}}
                @php
                    $isPublished = ($materi->status == '1' || $materi->status === 1 || strtolower((string)$materi->status) === 'publish');
                @endphp
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $isPublished ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $isPublished ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    {{ $isPublished ? 'Terbit' : 'Draft' }}
                </span>
            </div>

            {{-- Title --}}
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                {{ $materi->judul_materi }}
            </h2>

            {{-- Teacher & Timestamp Footer --}}
            <div class="flex flex-wrap items-center gap-4 sm:gap-6 mt-6 pt-5 border-t border-slate-100 text-xs text-slate-500">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-brand-100 text-brand-800 flex items-center justify-center font-bold text-xs">
                        {{ strtoupper(substr($materi->kelasMataPelajaran->guru->nama_guru ?? auth()->guard('web-guru')->user()->nama_guru ?? 'G', 0, 1)) }}
                    </div>
                    <div>
                        <span class="text-slate-400">Pengampu:</span>
                        <span class="font-bold text-slate-800 ml-1">
                            {{ $materi->kelasMataPelajaran->guru->nama_guru ?? auth()->guard('web-guru')->user()->nama_guru ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 text-slate-500">
                    <i class="fa-regular fa-calendar-check text-slate-400"></i>
                    <span>Dibuat: {{ $materi->created_at ? $materi->created_at->translatedFormat('d F Y · H:i') . ' WIB' : '-' }}</span>
                </div>

                @if ($materi->updated_at && $materi->updated_at->ne($materi->created_at))
                    <div class="flex items-center gap-1.5 text-slate-400">
                        <i class="fa-solid fa-clock-rotate-left text-[11px]"></i>
                        <span>Diperbarui: {{ $materi->updated_at->diffForHumans() }}</span>
                    </div>
                @endif
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
                                <p class="text-[11px] text-slate-400">Catatan, instruksi dan rangkuman materi dari guru</p>
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
                            <p class="text-[11px] text-slate-400 mt-0.5">Siswa dapat langsung mempelajari dokumen atau berkas lampiran yang tersedia di bawah.</p>
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
                                <p class="text-[11px] text-slate-400">File penunjang pembelajaran yang dapat diunduh siswa</p>
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
                            <p class="text-xs text-slate-500 font-medium">Belum ada berkas atau dokumen yang dilampirkan.</p>
                            <a href="{{ route('guru.lms.materi.edit', ['id' => $materi->id_materi]) }}"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-800 mt-2">
                                <i class="fa-solid fa-plus text-[10px]"></i>
                                <span>Unggah Berkas Sekarang</span>
                            </a>
                        </div>
                    @endif
                </div>

            </div>

            {{-- Right Column (1 col): Ringkasan Rombel & Navigasi LMS --}}
            <div class="space-y-6">

                {{-- Informasi Kelas Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-bold text-slate-900 text-sm pb-3 mb-4 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-chalkboard text-brand-700"></i>
                        <span>Informasi Rombel</span>
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
                            <span class="text-slate-400">Total Siswa</span>
                            <span class="font-bold text-slate-800">
                                {{ $materi->kelasMataPelajaran->kelas->siswa->count() ?? 0 }} Siswa
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-1">
                            <span class="text-slate-400">Topik / Modul</span>
                            <span class="font-bold text-slate-800 text-right truncate max-w-[160px]" title="{{ $materi->topik->judul_topik ?? '-' }}">
                                {{ $materi->topik->judul_topik ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Navigasi Cepat Kelas --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-bold text-slate-900 text-sm pb-3 mb-3 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-compass text-brand-700"></i>
                        <span>Navigasi Rombel Ini</span>
                    </h3>

                    <div class="space-y-2">
                        <a href="{{ route('guru.lms.forum', ['id' => $materi->kelas_mata_pelajaran_id]) }}"
                            class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-brand-300 hover:bg-brand-50/50 text-slate-700 hover:text-brand-800 transition-all text-xs font-semibold group">
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-comments text-brand-700"></i>
                                <span>Forum Diskusi Kelas</span>
                            </div>
                            <i class="fa-solid fa-arrow-right text-[11px] text-slate-400 group-hover:text-brand-700 transition-colors"></i>
                        </a>

                        <a href="{{ route('guru.lms.forum.tugas', ['id' => $materi->kelas_mata_pelajaran_id]) }}"
                            class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-brand-300 hover:bg-brand-50/50 text-slate-700 hover:text-brand-800 transition-all text-xs font-semibold group">
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-clipboard-list text-brand-700"></i>
                                <span>Tugas Pembelajaran</span>
                            </div>
                            <i class="fa-solid fa-arrow-right text-[11px] text-slate-400 group-hover:text-brand-700 transition-colors"></i>
                        </a>

                        <a href="{{ route('guru.lms.forum.anggota', ['id' => $materi->kelas_mata_pelajaran_id]) }}"
                            class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-brand-300 hover:bg-brand-50/50 text-slate-700 hover:text-brand-800 transition-all text-xs font-semibold group">
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-users text-brand-700"></i>
                                <span>Daftar Siswa di Kelas</span>
                            </div>
                            <i class="fa-solid fa-arrow-right text-[11px] text-slate-400 group-hover:text-brand-700 transition-colors"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-guru-layout>

{{-- SweetAlert2 for Delete Confirmation --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Materi Ini?',
            text: 'Materi "{{ $materi->judul_materi }}" dan dokumen lampirannya akan dihapus secara permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus Sekarang',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl text-xs font-semibold px-4 py-2.5',
                cancelButton: 'rounded-xl text-xs font-semibold px-4 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-materi-form').submit();
            }
        });
    }
</script>

<x-siswa-layout>
    <div class="max-w-5xl mx-auto space-y-5">

        {{-- Header with back --}}
        <div class="flex items-start gap-3">
            <a href="{{ url()->previous() }}"
                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-xs font-semibold bg-amber-100 text-amber-700 px-2.5 py-0.5 rounded-full">Tugas</span>
                    <span class="text-xs text-slate-400">Dibuat {{ $tugas->created_at->format('d M Y') }}</span>
                </div>
                <h1 class="text-xl font-bold text-slate-900">{{ $tugas->judul }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $tugas->kelasMataPelajaran->mata_pelajaran ?? '' }}</p>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- 2-col layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Left: Detail Tugas --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Deadline Banner --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm">
                        <span class="text-amber-700 font-medium">Batas waktu: </span>
                        <span class="text-amber-800 font-semibold">{{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('l, d F Y, H:i') }} WIB</span>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Deskripsi Tugas</h2>
                    <div class="prose prose-sm max-w-none text-slate-700">
                        {!! $tugas->deskripsi !!}
                    </div>
                </div>

                {{-- Lampiran dari Guru --}}
                @if ($filetugas->count() > 0)
                    <div class="bg-white border border-slate-200 rounded-xl p-5">
                        <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-3">Lampiran Tugas</h2>
                        <div class="space-y-2">
                            @foreach ($filetugas as $file)
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                    class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-lg hover:bg-brand-50 hover:border-brand-200 transition group">
                                    <div class="w-8 h-8 bg-brand-100 text-brand-700 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-slate-700 group-hover:text-brand-800 font-medium flex-1 truncate">{{ $file->original_name }}</span>
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right: Submit Panel --}}
            <div class="space-y-4">

                {{-- Status & Submission --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-semibold text-slate-900">Pengumpulan Saya</h2>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $status_color }}">
                            {{ $status_text }}
                        </span>
                    </div>

                    {{-- Uploaded Files --}}
                    @if ($pengumpulan && $pengumpulan->pengumpulanTugasFile->count() > 0)
                        <div class="space-y-2 mb-4">
                            @foreach ($pengumpulan->pengumpulanTugasFile as $file)
                                <div class="flex items-center gap-2 p-2.5 bg-slate-50 border border-slate-200 rounded-lg">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                        class="text-xs text-slate-600 hover:text-brand-800 truncate flex-1">{{ $file->original_name }}</a>
                                    <a href="{{ route('siswa.dashboard.lms.tugas.file.delete', $file->id_pengumpulan_tugas_file) }}"
                                        class="text-slate-300 hover:text-red-500 transition shrink-0"
                                        onclick="return confirm('Hapus file ini?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Cancel or Upload Form --}}
                    @if ($pengumpulan)
                        <form action="{{ route('siswa.dashboard.lms.tugas.batal', $pengumpulan->id_pengumpulan_tugas) }}"
                            method="POST">
                            @csrf @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Batalkan penyerahan tugas ini?')"
                                class="w-full py-2 px-4 text-sm font-medium text-red-600 border border-red-200 bg-red-50 rounded-lg hover:bg-red-100 transition">
                                Batalkan Penyerahan
                            </button>
                        </form>
                    @else
                        <form action="{{ route('siswa.dashboard.lms.submit.tugas', $tugas->id_tugas) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- Upload Area --}}
                            <label for="files" class="block cursor-pointer border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-brand-400 hover:bg-brand-50 transition group mb-3">
                                <input type="file" id="files" name="files[]" class="sr-only" multiple accept=".pdf,.doc,.docx,.ppt,.pptx">
                                <svg class="w-8 h-8 text-slate-400 group-hover:text-brand-600 mx-auto mb-2 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                <p class="text-sm font-medium text-slate-600 group-hover:text-brand-700">Klik untuk unggah file</p>
                                <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, PPT, PPTX · Maks. 10MB</p>
                            </label>
                            <div id="file-list" class="space-y-2 mb-3"></div>
                            <button type="submit"
                                class="w-full py-2.5 px-4 text-sm font-semibold text-white bg-brand-800 rounded-lg hover:bg-brand-900 transition">
                                Kumpulkan Tugas
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Nilai --}}
                @if ($pengumpulan)
                    <div class="bg-white border border-slate-200 rounded-xl p-5">
                        <h2 class="text-sm font-semibold text-slate-900 mb-3">Penilaian</h2>
                        @if ($pengumpulan->nilai)
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-14 h-14 rounded-xl bg-brand-50 border border-brand-200 flex flex-col items-center justify-center">
                                    <span class="text-lg font-extrabold text-brand-800">{{ $pengumpulan->nilai }}</span>
                                    <span class="text-xs text-brand-600">/100</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-700">Nilai Tugas</p>
                                    @if ($pengumpulan->status === 'terlambat diserahkan')
                                        <span class="text-xs text-red-500 font-medium">Terlambat diserahkan</span>
                                    @else
                                        <span class="text-xs text-emerald-600 font-medium">Tepat waktu</span>
                                    @endif
                                </div>
                            </div>
                            @if ($pengumpulan->komentar)
                                <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                                    <p class="text-xs font-semibold text-slate-500 mb-1">Komentar Guru</p>
                                    <p class="text-sm text-slate-700">{{ $pengumpulan->komentar }}</p>
                                </div>
                            @endif
                        @else
                            <p class="text-sm text-slate-400 text-center py-4 border border-dashed border-slate-200 rounded-lg">Belum dinilai</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let selectedFiles = [];
            const fileInput = document.getElementById('files');
            const fileList = document.getElementById('file-list');
            if (!fileInput) return;

            const maxSize = 10 * 1024 * 1024;
            const validTypes = ['application/pdf','application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation'];

            fileInput.addEventListener('change', function () {
                const newFiles = Array.from(this.files).filter(f => {
                    if (f.size > maxSize) { alert(`${f.name}: maks 10MB`); return false; }
                    if (!validTypes.includes(f.type)) { alert(`${f.name}: format tidak didukung`); return false; }
                    return true;
                });
                selectedFiles = [...selectedFiles, ...newFiles];
                render();
            });

            function render() {
                fileList.innerHTML = '';
                selectedFiles.forEach((f, i) => {
                    fileList.insertAdjacentHTML('beforeend', `
                        <div class="flex items-center gap-2 p-2.5 bg-slate-50 border border-slate-200 rounded-lg">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-xs text-slate-600 truncate flex-1">${f.name}</span>
                            <button type="button" onclick="removeFile(${i})" class="text-slate-300 hover:text-red-500 transition shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>`);
                });
            }

            window.removeFile = function (i) { selectedFiles.splice(i, 1); render(); };
        });
    </script>
</x-siswa-layout>

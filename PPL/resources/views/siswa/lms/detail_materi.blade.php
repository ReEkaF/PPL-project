<x-siswa-layout>
    <div class="max-w-3xl mx-auto space-y-5">

        {{-- Header with back --}}
        <div class="flex items-start gap-3">
            <a href="{{ url()->previous() }}"
                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-xs font-semibold bg-brand-100 text-brand-700 px-2.5 py-0.5 rounded-full">Materi</span>
                    <span class="text-xs text-slate-400">
                        {{ $materi->kelasMataPelajaran->guru->nama_guru }} · {{ $materi->created_at->format('d M Y') }}
                    </span>
                </div>
                <h1 class="text-xl font-bold text-slate-900">{{ $materi->judul_materi }}</h1>
            </div>
        </div>

        {{-- Content Card --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6">
            <div class="prose prose-sm max-w-none text-slate-700">
                {!! $materi->deskripsi !!}
            </div>
        </div>

        {{-- Attachments --}}
        @if (count($file_materi))
            <div class="bg-white border border-slate-200 rounded-xl p-5">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-3">Lampiran Materi</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach ($file_materi as $item)
                        @php
                            $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                            $parts = explode('/', $item->file_path);
                            $rawName = end($parts);
                            $displayName = strlen($rawName) > 11 ? substr($rawName, 11) : $rawName;

                            $iconColor = match($ext) {
                                'pdf' => 'text-red-500 bg-red-50',
                                'doc', 'docx' => 'text-blue-600 bg-blue-50',
                                'ppt', 'pptx' => 'text-orange-500 bg-orange-50',
                                'xlsx', 'xls' => 'text-green-600 bg-green-50',
                                default => 'text-slate-500 bg-slate-100',
                            };
                        @endphp
                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                            class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl hover:bg-brand-50 hover:border-brand-200 transition group">
                            <div class="w-9 h-9 rounded-lg {{ $iconColor }} flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-700 group-hover:text-brand-800 truncate transition">{{ $displayName }}</p>
                                <p class="text-xs text-slate-400 uppercase">{{ $ext }}</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-brand-600 shrink-0 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-siswa-layout>

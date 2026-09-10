<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                ['label' => 'Notifikasi', 'route' => route('siswa.notifikasi')],
            ];
        @endphp

        {{-- Top Navigation & Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <x-breadcrumb :breadcrumbs="$breadcrumbs" />
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                    Pusat Notifikasi Pembelajaran
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Informasi publikasi materi baru dari guru pengajar, pembaruan kelas, dan notifikasi akademik.
                </p>
            </div>
            @if ($unreadCount > 0)
                <div class="shrink-0">
                    <form action="{{ route('siswa.notifikasi.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold shadow-sm transition">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Tandai Semua Telah Dibaca</span>
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- 3 KPI Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- Card 1: Total Notifikasi --}}
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Notifikasi</span>
                    <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $totalCount }}</span>
                    <span class="text-xs text-slate-400">pesan masuk</span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                    Semua riwayat notifikasi materi
                </p>
            </div>

            {{-- Card 2: Belum Dibaca --}}
            <div class="bg-white dark:bg-slate-800 border {{ $unreadCount > 0 ? 'border-brand-300 dark:border-brand-700 ring-2 ring-brand-500/10' : 'border-slate-200 dark:border-slate-700' }} rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <span class="text-xs font-semibold text-brand-600 dark:text-brand-400 uppercase tracking-wider">Belum Dibaca</span>
                    <div class="w-9 h-9 rounded-xl bg-brand-50 dark:bg-brand-950/50 text-brand-600 dark:text-brand-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-brand-700 dark:text-brand-300">{{ $unreadCount }}</span>
                    @if ($unreadCount > 0)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-brand-100 text-brand-800 dark:bg-brand-900/60 dark:text-brand-300">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-ping"></span>
                            Perlu Dicek
                        </span>
                    @else
                        <span class="text-xs text-slate-400">semua beres</span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                    {{ $unreadCount > 0 ? 'Materi baru yang belum kamu buka' : 'Tidak ada notifikasi yang tertunda' }}
                </p>
            </div>

            {{-- Card 3: Sudah Dibaca --}}
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Sudah Dibaca</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $readCount }}</span>
                    <span class="text-xs text-slate-400">pesan terbaca</span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                    Materi yang sudah pernah dilihat
                </p>
            </div>
        </div>

        {{-- Filter Tabs & Search Bar --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            {{-- Tabs --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                <a href="{{ route('siswa.notifikasi', array_merge(request()->except('filter', 'page'), ['filter' => 'all'])) }}"
                    class="px-4 py-2 rounded-xl text-xs font-semibold transition shrink-0 {{ $filter === 'all' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow-sm' : 'bg-slate-100 dark:bg-slate-700/60 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    Semua
                    <span class="ml-1.5 text-[10px] px-1.5 py-0.2 rounded-full {{ $filter === 'all' ? 'bg-white/20 text-white dark:bg-slate-900/20 dark:text-slate-900' : 'bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-300' }}">
                        {{ $totalCount }}
                    </span>
                </a>

                <a href="{{ route('siswa.notifikasi', array_merge(request()->except('filter', 'page'), ['filter' => 'unread'])) }}"
                    class="px-4 py-2 rounded-xl text-xs font-semibold transition shrink-0 {{ $filter === 'unread' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow-sm' : 'bg-slate-100 dark:bg-slate-700/60 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    Belum Dibaca
                    <span class="ml-1.5 text-[10px] px-1.5 py-0.2 rounded-full {{ $filter === 'unread' ? 'bg-white/20 text-white dark:bg-slate-900/20 dark:text-slate-900' : 'bg-brand-100 text-brand-800 dark:bg-brand-900/60 dark:text-brand-300' }}">
                        {{ $unreadCount }}
                    </span>
                </a>

                <a href="{{ route('siswa.notifikasi', array_merge(request()->except('filter', 'page'), ['filter' => 'read'])) }}"
                    class="px-4 py-2 rounded-xl text-xs font-semibold transition shrink-0 {{ $filter === 'read' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow-sm' : 'bg-slate-100 dark:bg-slate-700/60 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    Sudah Dibaca
                    <span class="ml-1.5 text-[10px] px-1.5 py-0.2 rounded-full {{ $filter === 'read' ? 'bg-white/20 text-white dark:bg-slate-900/20 dark:text-slate-900' : 'bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-300' }}">
                        {{ $readCount }}
                    </span>
                </a>
            </div>

            {{-- Search Form --}}
            <form action="{{ route('siswa.notifikasi') }}" method="GET" class="relative w-full md:w-80">
                @if (request('filter'))
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari materi, mapel, atau guru..."
                    class="w-full pl-9 pr-8 py-2 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                @if (request('search'))
                    <a href="{{ route('siswa.notifikasi', request()->except('search', 'page')) }}"
                        class="absolute right-2.5 top-2.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
            </form>
        </div>

        {{-- Notification Cards List --}}
        <div class="space-y-3">
            @forelse ($notifikasi as $item)
                @php
                    $isUnread = $item->status == 0;
                    $materi = $item->materi;
                    $kmp = $materi?->kelasMataPelajaran;
                    $mapelName = $kmp?->mataPelajaran?->nama_matpel ?? 'Mata Pelajaran';
                    $guruName = $kmp?->guru?->nama_guru ?? 'Guru Pengajar';
                    $kelasName = $kmp?->kelas?->nama_kelas ?? '-';
                    $topikName = $materi?->topik?->nama_topik;
                    $timeAgo = \Carbon\Carbon::parse($item->created_at)->diffForHumans();
                    $fullDate = \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('dddd, D MMMM Y • HH:mm') . ' WIB';
                @endphp
                <div class="p-5 rounded-2xl transition-all bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        {{-- Left: Icon & Content --}}
                        <div class="flex items-start gap-3.5 flex-1 min-w-0">
                            {{-- Icon Circle --}}
                            <div class="w-11 h-11 rounded-2xl {{ $isUnread ? 'bg-brand-50 text-brand-600 dark:bg-brand-950/60 dark:text-brand-300 border border-brand-200 dark:border-brand-800' : 'bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400' }} flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                {{-- Pills Header --}}
                                <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                    {{-- Mapel Pill --}}
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-brand-50 text-brand-700 border border-brand-200 dark:bg-brand-950/40 dark:text-brand-300 dark:border-brand-800">
                                        {{ $mapelName }}
                                    </span>

                                    @if ($topikName)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                            Topik: {{ $topikName }}
                                        </span>
                                    @endif

                                    <span class="text-xs text-slate-400 dark:text-slate-500">
                                        Kelas {{ $kelasName }}
                                    </span>

                                    @if ($isUnread)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300 ml-auto sm:ml-0">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            BARU
                                        </span>
                                    @endif
                                </div>

                                {{-- Title --}}
                                <h3 class="text-base font-bold text-slate-900 dark:text-white leading-snug">
                                    <a href="{{ route('siswa.notifikasi.open', $item->id_notifikasi_sistem) }}"
                                        class="hover:text-brand-600 dark:hover:text-brand-400 transition">
                                        {{ $materi->judul_materi }}
                                    </a>
                                </h3>

                                {{-- Cleaned Description Excerpt --}}
                                @if ($materi->deskripsi)
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                                        {{ Str::limit(strip_tags($materi->deskripsi), 160) }}
                                    </p>
                                @endif

                                {{-- Metadata Row (Teacher & Time) --}}
                                <div class="flex flex-wrap items-center gap-3 mt-3 pt-2.5 border-t border-slate-100 dark:border-slate-700/60 text-xs text-slate-500 dark:text-slate-400">
                                    <div class="flex items-center gap-1.5">
                                        <div class="w-5 h-5 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center font-bold text-[10px] text-slate-700 dark:text-slate-300">
                                            {{ strtoupper(substr($guruName, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ $guruName }}</span>
                                    </div>
                                    <span>•</span>
                                    <span title="{{ $fullDate }}" class="cursor-help flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $timeAgo }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Right: Actions --}}
                        <div class="flex sm:flex-col items-center sm:items-end justify-end gap-2 shrink-0 pt-2 sm:pt-0">
                            <a href="{{ route('siswa.notifikasi.open', $item->id_notifikasi_sistem) }}"
                                class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 {{ $isUnread ? 'bg-brand-600 hover:bg-brand-700 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200' }} rounded-xl text-xs font-semibold transition">
                                <span>Buka Materi</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                            @if ($isUnread)
                                <form action="{{ route('siswa.notifikasi.mark-read', $item->id_notifikasi_sistem) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        title="Tandai Sudah Dibaca"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-[11px] font-medium text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Tandai Dibaca</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-700 text-slate-400 mx-auto flex items-center justify-center mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">
                        Tidak Ada Notifikasi
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                        @if (request('search') || request('filter') !== 'all')
                            Tidak ada notifikasi yang cocok dengan kriteria filter atau pencarian kamu.
                        @else
                            Belum ada publikasi materi baru atau notifikasi pembelajaran untuk akun kamu saat ini.
                        @endif
                    </p>
                    @if (request('search') || request('filter') !== 'all')
                        <div class="mt-4">
                            <a href="{{ route('siswa.notifikasi') }}"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-xl text-xs font-semibold transition">
                                <span>Reset Filter</span>
                            </a>
                        </div>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Pagination Links --}}
        @if ($notifikasi->hasPages())
            <div class="pt-2">
                {{ $notifikasi->links() }}
            </div>
        @endif

    </div>

    {{-- SweetAlert2 Flash Notifications --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Perhatian',
                text: '{{ session('error') }}',
                confirmButtonColor: '#3b82f6',
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#10b981',
            });
        @endif

        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '{{ session('info') }}',
                confirmButtonColor: '#3b82f6',
            });
        @endif
    </script>
</x-siswa-layout>
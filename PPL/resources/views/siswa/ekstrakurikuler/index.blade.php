<x-siswa-layout>
    <div class="space-y-6">
        {{-- Hero Header --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-brand-800 to-indigo-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-brand-950/10">
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="max-w-2xl space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm text-xs font-semibold tracking-wide text-brand-100 border border-white/10">
                        <i class="fa-solid fa-users text-amber-300"></i>
                        <span>Ekstrakurikuler SMPN 2 Kamal</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Kembangkan Bakat & Minatmu</h1>
                    <p class="text-sm sm:text-base text-brand-100/90 leading-relaxed">
                        Temukan berbagai kegiatan positif di luar jam pelajaran sekolah. Asah keterampilan, kepemimpinan, dan raih prestasi membanggakan bersama teman-teman!
                    </p>
                    <div class="pt-2 flex flex-wrap gap-3">
                        <a href="{{ route('siswa.ekstrakurikuler.pendaftaran') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-400 hover:bg-amber-300 text-slate-900 font-semibold text-sm rounded-xl shadow-sm transition-all duration-200 hover:scale-105 active:scale-95">
                            <i class="fa-solid fa-user-plus"></i>
                            <span>Daftar Ekskul Sekarang</span>
                        </a>
                        <a href="{{ route('siswa.ekstrakurikuler.saya') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white font-medium text-sm rounded-xl border border-white/20 backdrop-blur-sm transition-colors">
                            <i class="fa-solid fa-address-card"></i>
                            <span>Ekskul Saya</span>
                        </a>
                    </div>
                </div>

                {{-- Metric Badges --}}
                <div class="grid grid-cols-3 md:grid-cols-1 gap-3 shrink-0">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3 sm:p-4 border border-white/10 text-center md:text-left min-w-[130px]">
                        <p class="text-xs text-brand-200">Total Ekskul</p>
                        <p class="text-xl sm:text-2xl font-black text-white">{{ $totalEkskul }}</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3 sm:p-4 border border-white/10 text-center md:text-left min-w-[130px]">
                        <p class="text-xs text-brand-200">Pendaftaran Buka</p>
                        <p class="text-xl sm:text-2xl font-black text-emerald-300">{{ $ekskulBuka }}</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3 sm:p-4 border border-white/10 text-center md:text-left min-w-[130px]">
                        <p class="text-xs text-brand-200">Ekskul Diikuti</p>
                        <p class="text-xl sm:text-2xl font-black text-amber-300">{{ $totalEkskulDiikuti }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter & Search Bar --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
                <a href="{{ route('siswa.ekstrakurikuler.index', ['search' => $search]) }}"
                    class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors {{ empty($statusFilter) ? 'bg-brand-800 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Ekskul
                </a>
                <a href="{{ route('siswa.ekstrakurikuler.index', ['status' => 'buka', 'search' => $search]) }}"
                    class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors {{ $statusFilter === 'buka' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    <i class="fa-solid fa-circle-check mr-1 text-emerald-400"></i> Pendaftaran Buka
                </a>
                <a href="{{ route('siswa.ekstrakurikuler.index', ['status' => 'tutup', 'search' => $search]) }}"
                    class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors {{ $statusFilter === 'tutup' ? 'bg-slate-700 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Pendaftaran Tutup
                </a>
            </div>

            <form method="GET" action="{{ route('siswa.ekstrakurikuler.index') }}" class="relative w-full md:w-72">
                @if($statusFilter)
                    <input type="hidden" name="status" value="{{ $statusFilter }}">
                @endif
                <input type="text" name="search" value="{{ $search }}"
                    placeholder="Cari ekstrakurikuler..."
                    class="w-full pl-10 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-700 focus:bg-white transition-all placeholder:text-slate-400">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-sm"></i>
            </form>
        </div>

        {{-- Grid Katalog Ekstrakurikuler --}}
        @if ($ekstrakurikulers->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak ada ekstrakurikuler yang ditemukan</h3>
                <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">Silakan coba kata kunci pencarian lain atau ubah filter status.</p>
                <a href="{{ route('siswa.ekstrakurikuler.index') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-brand-800 text-white text-xs font-semibold rounded-xl hover:bg-brand-900 transition-colors">
                    Reset Filter
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($ekstrakurikulers as $ekstra)
                    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 flex flex-col group">
                        {{-- Cover Image & Badges --}}
                        <div class="relative h-44 w-full bg-slate-100 overflow-hidden">
                            @if ($ekstra->gambar && file_exists(public_path('images/ekstra/' . $ekstra->gambar)))
                                <img src="{{ asset('images/ekstra/' . $ekstra->gambar) }}"
                                    alt="{{ $ekstra->nama_ekstrakurikuler }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-tr from-slate-200 to-slate-100 text-slate-400">
                                    <i class="fa-solid fa-users text-4xl mb-2 text-slate-300"></i>
                                    <span class="text-xs font-medium">Foto Ekskul</span>
                                </div>
                            @endif

                            {{-- Status Badge --}}
                            <div class="absolute top-3 right-3">
                                @php $statusDinamis = $ekstra->status_pendaftaran_dinamis; @endphp
                                @if ($statusDinamis === 'buka')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/90 text-white backdrop-blur-md shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                        Pendaftaran Buka
                                    </span>
                                @elseif ($statusDinamis === 'akan_datang')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-500/90 text-white backdrop-blur-md shadow-sm">
                                        <i class="fa-solid fa-calendar-day text-[10px]"></i>
                                        Akan Datang
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-900/70 text-slate-200 backdrop-blur-md">
                                        Tutup
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div class="space-y-3">
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-800 transition-colors line-clamp-1">
                                    {{ $ekstra->nama_ekstrakurikuler }}
                                </h3>

                                <div class="space-y-1.5 text-xs text-slate-600">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-user-tie text-slate-400 w-4 text-center"></i>
                                        <span class="font-medium text-slate-500">Pembina:</span>
                                        <span class="font-semibold text-slate-700 truncate">
                                            {{ $ekstra->pembinaEkstra->nama_guru ?? 'Belum ditentukan' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-users text-slate-400 w-4 text-center"></i>
                                        <span class="font-medium text-slate-500">Anggota Aktif:</span>
                                        <span class="font-semibold text-slate-700">
                                            {{ $ekstra->total_anggota ?? 0 }} Siswa
                                        </span>
                                    </div>
                                    @if ($ekstra->rentang_pendaftaran_formatted)
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-calendar-days text-brand-600 w-4 text-center"></i>
                                            <span class="font-medium text-slate-500">Periode:</span>
                                            <span class="font-semibold text-brand-900 truncate">
                                                {{ $ekstra->rentang_pendaftaran_formatted }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $ekstra->deskripsi ?? 'Belum ada deskripsi untuk ekstrakurikuler ini.' }}
                                </p>
                            </div>

                            {{-- Card Action Footer --}}
                            <div class="pt-5 mt-4 border-t border-slate-100 flex items-center gap-2">
                                <a href="{{ route('siswa.ekstrakurikuler.detail', $ekstra->id_ekstrakurikuler) }}"
                                    class="flex-1 text-center px-3 py-2 text-xs font-semibold text-brand-800 bg-brand-50 hover:bg-brand-100 rounded-xl transition-colors">
                                    Lihat Profil
                                </a>

                                @if ($ekstra->isPendaftaranBuka())
                                    <a href="{{ route('siswa.ekstrakurikuler.pendaftaran', ['pilih' => $ekstra->id_ekstrakurikuler]) }}"
                                        class="px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-colors shadow-sm inline-flex items-center gap-1.5">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        <span>Daftar</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Seksi Dokumentasi / Postingan Terbaru --}}
        @if ($postinganTerbaru->isNotEmpty())
            <div class="pt-6 border-t border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Dokumentasi & Kegiatan Ekskul</h2>
                        <p class="text-xs text-slate-500">Kilas aktivitas terkini dari rekan-rekan ekstrakurikuler</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($postinganTerbaru as $post)
                        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm space-y-3">
                            @if ($post->gambar && file_exists(public_path('images/ekstra/' . $post->gambar)))
                                <img src="{{ asset('images/ekstra/' . $post->gambar) }}"
                                    alt="{{ $post->judul }}"
                                    class="w-full h-36 object-cover rounded-xl">
                            @endif
                            <div class="space-y-1">
                                <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-brand-50 text-brand-800">
                                    {{ $post->ekstrakurikuler->nama_ekstrakurikuler ?? 'Ekstrakurikuler' }}
                                </span>
                                <h4 class="text-sm font-bold text-slate-800 line-clamp-1">{{ $post->judul }}</h4>
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $post->deskripsi }}</p>
                            </div>
                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400">
                                <span>{{ \Carbon\Carbon::parse($post->tgl_uploud)->translatedFormat('d M Y') }}</span>
                                <span>Oleh {{ $post->pengurus->siswa->nama_siswa ?? 'Pengurus' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-siswa-layout>

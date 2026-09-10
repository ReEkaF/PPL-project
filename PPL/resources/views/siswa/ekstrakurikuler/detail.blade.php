<x-siswa-layout>
    <div class="space-y-6">
        {{-- Breadcrumb Nav --}}
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('siswa.dashboard') }}" class="hover:text-brand-800 transition-colors">Dashboard</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <a href="{{ route('siswa.ekstrakurikuler.index') }}" class="hover:text-brand-800 transition-colors">Ekstrakurikuler</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <span class="text-slate-800 font-semibold truncate">{{ $ekstrakurikuler->nama_ekstrakurikuler }}</span>
        </div>

        {{-- Hero Profile Banner --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
            <div class="relative h-64 sm:h-72 w-full bg-slate-900">
                @if ($ekstrakurikuler->gambar && file_exists(public_path('images/ekstra/' . $ekstrakurikuler->gambar)))
                    <img src="{{ asset('images/ekstra/' . $ekstrakurikuler->gambar) }}"
                        alt="{{ $ekstrakurikuler->nama_ekstrakurikuler }}"
                        class="w-full h-full object-cover opacity-90">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-brand-900 to-indigo-900 text-white/50">
                        <i class="fa-solid fa-users text-6xl"></i>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>

                {{-- Overlay Badges & CTA --}}
                <div class="absolute top-4 right-4 flex items-center gap-2">
                    @php $statusDinamis = $ekstrakurikuler->status_pendaftaran_dinamis; @endphp
                    @if ($statusDinamis === 'buka')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-500 text-white shadow-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            Pendaftaran Terbuka
                        </span>
                    @elseif ($statusDinamis === 'akan_datang')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-sky-500 text-white shadow-md">
                            <i class="fa-solid fa-calendar-day text-[10px]"></i>
                            Akan Datang
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-slate-800/80 text-slate-200 backdrop-blur-sm">
                            Pendaftaran Tutup
                        </span>
                    @endif
                </div>

                {{-- Hero Content at bottom --}}
                <div class="absolute bottom-6 left-6 right-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4 text-white">
                    <div class="space-y-1">
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight drop-shadow-sm">
                            {{ $ekstrakurikuler->nama_ekstrakurikuler }}
                        </h1>
                        <div class="text-xs sm:text-sm text-slate-200 flex flex-wrap items-center gap-x-3 gap-y-1">
                            <span><i class="fa-solid fa-user-tie mr-1 text-amber-300"></i> Pembina: {{ $ekstrakurikuler->pembinaEkstra->nama_guru ?? 'Belum ditentukan' }}</span>
                            <span>•</span>
                            <span><i class="fa-solid fa-users mr-1 text-emerald-300"></i> {{ $ekstrakurikuler->total_anggota ?? 0 }} Anggota Aktif</span>
                            @if ($ekstrakurikuler->rentang_pendaftaran_formatted)
                                <span>•</span>
                                <span><i class="fa-solid fa-calendar-days mr-1 text-sky-300"></i> Periode: {{ $ekstrakurikuler->rentang_pendaftaran_formatted }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="shrink-0 flex items-center gap-3">
                        @if ($statusPendaftaranSiswa)
                            @if ($statusPendaftaranSiswa->status === 'diterima')
                                <span class="px-4 py-2 bg-emerald-600/90 text-white rounded-xl text-xs font-bold shadow-sm inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-check"></i> Kamu Adalah Anggota
                                </span>
                            @elseif ($statusPendaftaranSiswa->status === 'menunggu')
                                <span class="px-4 py-2 bg-amber-500/90 text-white rounded-xl text-xs font-bold shadow-sm inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-clock"></i> Pendaftaran Menunggu Verifikasi
                                </span>
                            @elseif ($statusPendaftaranSiswa->status === 'ditolak')
                                <a href="{{ route('siswa.ekstrakurikuler.pendaftaran', ['pilih' => $ekstrakurikuler->id_ekstrakurikuler]) }}"
                                    class="px-4 py-2 bg-brand-700 hover:bg-brand-600 text-white rounded-xl text-xs font-bold shadow-sm inline-flex items-center gap-1.5 transition-colors">
                                    <i class="fa-solid fa-rotate-right"></i> Ajukan Ulang
                                </a>
                            @endif
                        @elseif ($ekstrakurikuler->isPendaftaranBuka())
                            <a href="{{ route('siswa.ekstrakurikuler.pendaftaran', ['pilih' => $ekstrakurikuler->id_ekstrakurikuler]) }}"
                                class="px-5 py-2.5 bg-amber-400 hover:bg-amber-300 text-slate-900 rounded-xl text-xs sm:text-sm font-bold shadow-lg transition-transform hover:scale-105 active:scale-95 inline-flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Daftar Sekarang</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Deskripsi & Informasi Detail --}}
            <div class="p-6 sm:p-8 space-y-6">
                <div>
                    <h2 class="text-base font-bold text-slate-900 mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-brand-800"></i>
                        <span>Tentang Kegiatan Ekstrakurikuler</span>
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $ekstrakurikuler->deskripsi ?? 'Belum ada deskripsi yang ditambahkan untuk ekstrakurikuler ini.' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Daftar Prestasi Ekskul --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-trophy text-amber-500"></i>
                        <span>Prestasi & Penghargaan</span>
                    </h2>
                    <p class="text-xs text-slate-500">Rekam jejak kejuaraan dan pencapaian membanggakan yang telah diraih</p>
                </div>
            </div>

            @if ($prestasiList->isEmpty())
                <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-100">
                    <i class="fa-solid fa-award text-slate-300 text-3xl mb-2"></i>
                    <p class="text-xs text-slate-500">Belum ada data prestasi yang dicatat untuk ekstrakurikuler ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach ($prestasiList as $prestasi)
                        <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-2xl border border-slate-100 bg-slate-50/60 hover:bg-slate-50 transition-colors">
                            @if (!empty($prestasi->gambar) && file_exists(public_path('images/ekstra/' . $ekstrakurikuler->nama_ekstrakurikuler . '/' . $prestasi->gambar)))
                                <img src="{{ asset('images/ekstra/' . $ekstrakurikuler->nama_ekstrakurikuler . '/' . $prestasi->gambar) }}"
                                    alt="{{ $prestasi->judul ?? 'Prestasi' }}"
                                    class="w-full sm:w-32 h-28 object-cover rounded-xl shrink-0">
                            @else
                                <div class="w-full sm:w-28 h-28 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center shrink-0 text-amber-500">
                                    <i class="fa-solid fa-medal text-3xl"></i>
                                </div>
                            @endif

                            <div class="flex-1 space-y-1.5">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                    Penghargaan
                                </span>
                                <h3 class="text-sm font-bold text-slate-900">{{ $prestasi->judul }}</h3>
                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                    {{ $prestasi->deskripsi }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Dokumentasi Kegiatan --}}
        @if ($postingan->isNotEmpty())
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-camera text-brand-800"></i>
                        <span>Galeri & Dokumentasi Kegiatan</span>
                    </h2>
                    <p class="text-xs text-slate-500">Dokumentasi latihan, agenda, dan momen kebersamaan anggota</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($postingan as $post)
                        <div class="rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm flex flex-col">
                            @if ($post->gambar && file_exists(public_path('images/ekstra/' . $post->gambar)))
                                <img src="{{ asset('images/ekstra/' . $post->gambar) }}"
                                    alt="{{ $post->judul }}"
                                    class="w-full h-40 object-cover">
                            @endif
                            <div class="p-4 space-y-2 flex-1 flex flex-col justify-between">
                                <div class="space-y-1">
                                    <h4 class="text-sm font-bold text-slate-900">{{ $post->judul }}</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $post->deskripsi }}</p>
                                </div>
                                <span class="text-[10px] text-slate-400 pt-2 border-t border-slate-100">
                                    {{ \Carbon\Carbon::parse($post->tgl_uploud)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-siswa-layout>

<x-guest-layout>
    <!-- Header Banner (Clean Light Theme) -->
    <section class="bg-white text-slate-900 py-14 lg:py-18 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-brand-50 border border-brand-200 text-brand-800 text-xs font-semibold">
                    <span>Pengembangan Minat & Bakat</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">Ekstrakurikuler SMPN 2 Kamal</h1>
                <p class="text-base text-slate-600 leading-relaxed">
                    Wadah resmi pembinaan bakat, kepemimpinan, dan kreativitas siswa di luar jam pelajaran formal melalui program kegiatan positif dan terarah.
                </p>
                <div class="pt-2 flex flex-wrap items-center gap-3">
                    @if (session()->has('username'))
                        <x-ui.button href="{{ route('ekstrakurikuler.registrasi') }}" variant="primary" size="md">
                            <span>Daftar Ekstrakurikuler</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </x-ui.button>
                    @else
                        <x-ui.button href="{{ route('login', ['redirect' => 'ekstrakurikuler.registrasi']) }}" variant="primary" size="md">
                            <span>Masuk untuk Mendaftar</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </x-ui.button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Pilihan Ekstrakurikuler -->
    <section class="py-14 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-800">Pilihan Bidang</span>
                <h2 class="text-2xl font-bold text-slate-900 mt-1">Daftar Ekstrakurikuler Aktif</h2>
                <p class="text-sm text-slate-600 mt-1">Pilih kegiatan yang sesuai dengan minat dan potensi diri kamu.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($ekstrakurikulerList as $ekstra)
                    <a href="{{ route('ekstrakurikuler.detail', ['id' => $ekstra->id_ekstrakurikuler]) }}"
                       class="bg-white border border-slate-200 rounded-xl overflow-hidden flex flex-col justify-between hover:border-brand-700 transition group">
                        <div>
                            <div class="h-44 bg-slate-100 overflow-hidden relative">
                                <img src="{{ asset('images/ekstra/'.$ekstra->gambar) }}"
                                     alt="{{ $ekstra->nama_ekstrakurikuler }}"
                                     class="w-full h-full object-cover"
                                     loading="lazy"
                                     onerror="this.src='{{ asset('images/image-none.jpg') }}'">
                            </div>
                            <div class="p-5 space-y-2">
                                <h3 class="font-bold text-base text-slate-900 group-hover:text-brand-800 transition-colors">
                                    {{ $ekstra->nama_ekstrakurikuler }}
                                </h3>
                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                    {{ $ekstra->deskripsi }}
                                </p>
                            </div>
                        </div>

                        <div class="px-5 py-3.5 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between text-xs text-brand-800 font-semibold">
                            <span>Lihat Detail Kegiatan</span>
                            <span>→</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Postingan & Dokumentasi Kegiatan -->
    @if(isset($postingan) && $postingan->count() > 0)
    <section class="py-14 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-800">Warta Ekskul</span>
                <h2 class="text-2xl font-bold text-slate-900 mt-1">Dokumentasi & Berita Terbaru</h2>
                <p class="text-sm text-slate-600 mt-1">Catatan agenda, latihan rutin, dan kegiatan luar sekolah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($postingan as $item)
                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden flex flex-col justify-between hover:border-brand-700 transition">
                        <div>
                            @if(!empty($item->gambar))
                                <div class="h-60 bg-slate-100 overflow-hidden">
                                    <img src="{{ $item->gambar }}" alt="{{ $item->judul }}" class="w-full h-full object-cover" loading="lazy">
                                </div>
                            @endif
                            <div class="p-5 space-y-2">
                                <h3 class="font-bold text-base text-slate-900">
                                    {{ $item->judul }}
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                    {{ $item->deskripsi }}
                                </p>
                            </div>
                        </div>
                        <div class="px-5 py-3 bg-slate-50/70 border-t border-slate-100 text-xs text-slate-400">
                            Diposting oleh Pengurus Ekstrakurikuler
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-guest-layout>

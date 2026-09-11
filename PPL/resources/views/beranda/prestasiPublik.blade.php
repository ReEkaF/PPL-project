<x-guest-layout>
    <!-- Header Banner (Clean Light Theme) -->
    <section class="bg-white text-slate-900 py-14 lg:py-18 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl space-y-3">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-brand-50 border border-brand-200 text-brand-800 text-xs font-semibold">
                    <span>Apresiasi & Rekam Jejak</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">Galeri Prestasi SMPN 2 Kamal</h1>
                <p class="text-base text-slate-600 leading-relaxed">
                    Dokumentasi pencapaian, medali, dan penghargaan yang diraih oleh siswa-siswi berprestasi SMPN 2 Kamal di berbagai kompetisi akademik maupun non-akademik.
                </p>
            </div>
        </div>
    </section>

    <!-- Prestasi Grid -->
    <section class="py-14 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse ($prestasi as $item)
                    @php
                        $imageSrc = asset('images/image-none.jpg');
                        if (!empty($item->gambar)) {
                            if (str_starts_with($item->gambar, 'http')) {
                                $imageSrc = $item->gambar;
                            } elseif (file_exists(public_path('images/' . $item->gambar))) {
                                $imageSrc = asset('images/' . $item->gambar);
                            } elseif (file_exists(public_path('images/ekstra/' . $item->gambar))) {
                                $imageSrc = asset('images/ekstra/' . $item->gambar);
                            } elseif (file_exists(public_path('storage/' . $item->gambar))) {
                                $imageSrc = asset('storage/' . $item->gambar);
                            }
                        }
                    @endphp

                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden flex flex-col justify-between hover:border-brand-700 transition">
                        <div>
                            <div class="h-48 bg-slate-100 overflow-hidden relative">
                                <img src="{{ $imageSrc }}"
                                     alt="{{ $item->judul }}"
                                     class="w-full h-full object-cover"
                                     loading="lazy"
                                     onerror="this.src='{{ asset('images/image-none.jpg') }}'">
                                <div class="absolute top-3 left-3">
                                    <x-ui.badge variant="brand" size="sm">
                                        {{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? 'Prestasi Sekolah' }}
                                    </x-ui.badge>
                                </div>
                            </div>

                            <div class="p-5 space-y-2">
                                <h3 class="font-bold text-base text-slate-900 line-clamp-2">
                                    {{ $item->judul }}
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">
                                    {{ $item->deskripsi }}
                                </p>
                            </div>
                        </div>

                        <div class="px-5 py-3 bg-slate-50/70 border-t border-slate-100 text-xs text-slate-500 font-medium">
                            Terverifikasi Pembina Ekstrakurikuler
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-xl border border-slate-200">
                        <p class="text-sm text-slate-500">Belum ada dokumentasi prestasi yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-guest-layout>

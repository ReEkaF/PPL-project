<x-guest-layout>
    <!-- Header Banner (Clean Light Theme) -->
    <section class="bg-white text-slate-900 py-14 lg:py-18 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl space-y-3">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-brand-50 border border-brand-200 text-brand-800 text-xs font-semibold">
                    <span>Direktori Tenaga Pendidik</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">Dewan Guru SMPN 2 Kamal</h1>
                <p class="text-base text-slate-600 leading-relaxed">
                    Tenaga pendidik profesional dan berdedikasi tinggi yang membimbing para siswa dalam proses belajar mengajar serta pembentukan karakter budi pekerti luhur.
                </p>
            </div>
        </div>
    </section>

    <!-- Teachers Grid -->
    <section class="py-14 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse($guru as $gurus)
                    @php
                        $photoUrl = asset('images/profile-none.jpeg');
                        if (!empty($gurus->foto_guru)) {
                            if (str_starts_with($gurus->foto_guru, 'http')) {
                                $photoUrl = $gurus->foto_guru;
                            } elseif (file_exists(public_path('images/guru/' . $gurus->foto_guru))) {
                                $photoUrl = asset('images/guru/' . $gurus->foto_guru);
                            }
                        }

                        $mapelList = $gurus->gurumatapelajaran->map(function($gmp) {
                            return $gmp->mataPelajaran->nama_matpel ?? null;
                        })->filter()->unique()->values();
                    @endphp

                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden flex flex-col justify-between hover:border-brand-700 transition">
                        <div>
                            <div class="h-52 bg-slate-100 overflow-hidden relative">
                                <img src="{{ $photoUrl }}"
                                     alt="{{ $gurus->nama_guru }}"
                                     class="w-full h-full object-cover"
                                     loading="lazy"
                                     onerror="this.src='{{ asset('images/profile-none.jpeg') }}'">
                            </div>
                            <div class="p-4 space-y-1.5">
                                <h3 class="font-bold text-sm text-slate-900 line-clamp-2">
                                    {{ $gurus->nama_guru }}
                                </h3>
                                <p class="text-xs text-slate-500">
                                    NIP: {{ $gurus->nip ?: '—' }}
                                </p>
                            </div>
                        </div>

                        <div class="px-4 py-3 bg-slate-50/70 border-t border-slate-100 flex flex-wrap gap-1">
                            @if($mapelList->count() > 0)
                                @foreach($mapelList as $mapel)
                                    <x-ui.badge variant="brand" size="sm">{{ $mapel }}</x-ui.badge>
                                @endforeach
                            @else
                                <span class="text-xs text-slate-400 italic">Guru Mata Pelajaran</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-xl border border-slate-200">
                        <p class="text-sm text-slate-500">Belum ada data tenaga pengajar yang ditampilkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-guest-layout>

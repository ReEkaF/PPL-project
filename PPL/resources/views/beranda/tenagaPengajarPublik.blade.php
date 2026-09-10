<x-guest-layout>
    <!-- Header Banner -->
    <section class="bg-slate-900 text-white py-14 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl space-y-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-brand-900/80 border border-brand-700/60 text-brand-200 text-xs font-semibold">
                    Direktori Tenaga Pendidik
                </span>
                <h1 class="text-3xl font-extrabold tracking-tight">Dewan Guru SMPN 2 Kamal</h1>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Tenaga pendidik profesional dan berdedikasi tinggi yang membimbing para siswa dalam proses belajar mengajar serta pembentukan karakter budi pekerti.
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

                    <div class="bg-white border border-slate-200/80 rounded-xl overflow-hidden flex flex-col justify-between hover:shadow-md transition group">
                        <div>
                            <div class="h-52 bg-slate-100 overflow-hidden relative">
                                <img src="{{ $photoUrl }}"
                                     alt="{{ $gurus->nama_guru }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     loading="lazy"
                                     onerror="this.src='{{ asset('images/profile-none.jpeg') }}'">
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-sm text-slate-900 group-hover:text-brand-800 transition-colors line-clamp-2">
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

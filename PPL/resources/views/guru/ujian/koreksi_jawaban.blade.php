<x-app-guru-layout>
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Navigasi Kembali --}}
        <div>
            <a href="{{ route('guru.ujian.detail', $pengumpulan->ujian_id) }}"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-brand-800 transition-colors mb-3">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Rekap Ujian: {{ $pengumpulan->ujian->judul ?? 'Ujian' }}</span>
            </a>

            {{-- Student & Exam Summary Card --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-800 border border-brand-200/60">
                                Lembar Jawaban CBT
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                Kelas {{ $pengumpulan->ujian->kelasMataPelajaran->kelas->nama_kelas ?? '-' }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-sky-50 text-sky-700">
                                {{ $pengumpulan->ujian->kelasMataPelajaran->mataPelajaran->nama_matpel ?? '-' }}
                            </span>
                        </div>

                        <div>
                            <h1 class="text-xl font-bold text-slate-900">
                                {{ $pengumpulan->siswa->nama_siswa ?? 'Siswa' }}
                            </h1>
                            <p class="text-xs text-slate-500 mt-0.5">
                                NISN: <span class="font-mono font-semibold text-slate-700">{{ $pengumpulan->siswa->nisn ?? '-' }}</span> · 
                                Paket: <span class="font-semibold text-slate-700">{{ $pengumpulan->ujian->judul ?? '-' }}</span>
                            </p>
                        </div>

                        <div class="text-xs text-slate-500 flex items-center gap-2">
                            <i class="fa-regular fa-clock text-slate-400"></i>
                            <span>Waktu Submit: {{ !empty($pengumpulan->tanggal_pengumpulan) ? \Carbon\Carbon::parse($pengumpulan->tanggal_pengumpulan)->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}</span>
                        </div>
                    </div>

                    {{-- Form Nilai & Koreksi Manual --}}
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 shrink-0 w-full lg:w-72">
                        <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Perolehan Nilai Akhir
                        </div>
                        <form action="{{ route('guru.ujian.pengumpulan.nilai', $pengumpulan->id_pengumpulan_ujian) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center gap-2">
                                <div class="relative flex-1">
                                    <input type="number" name="nilai" min="0" max="100" step="0.5"
                                        value="{{ old('nilai', $pengumpulan->nilai ?? 0) }}" required
                                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-lg font-bold text-brand-900 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors bg-white pr-14 text-center">
                                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs text-slate-400 font-bold pointer-events-none">
                                        / 100
                                    </span>
                                </div>
                                <button type="submit"
                                    class="px-3.5 py-2.5 rounded-xl bg-brand-800 text-white font-semibold text-xs hover:bg-brand-900 transition-colors shrink-0 shadow-sm"
                                    title="Simpan Nilai Koreksi">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                </button>
                            </div>
                            <p class="text-[11px] text-slate-400 leading-tight">
                                Nilai otomatis dihitung oleh sistem CBT. Anda dapat mengubah nilai di atas jika diperlukan koreksi manual.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Detail Lembar Jawaban Siswa --}}
        @php
            // Map jawaban siswa berdasarkan soal_id
            $answersMap = $pengumpulan->jawabanUjian->keyBy('soal_id');
            $questions = $pengumpulan->ujian->soalUjian ?? collect();
            $totalCorrect = 0;
            $totalAnswered = 0;

            foreach ($questions as $q) {
                $chosen = strtoupper(trim($answersMap[$q->id_soal_ujian]->jawaban_dipilih ?? ''));
                $key = strtoupper(trim($q->kunci_jawaban ?? ''));
                if ($chosen !== '') {
                    $totalAnswered++;
                    if ($chosen === $key) {
                        $totalCorrect++;
                    }
                }
            }
        @endphp

        {{-- Summary Jawaban Benar / Salah --}}
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-sm font-bold shrink-0">
                    {{ $questions->count() }}
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-medium">Total Soal</span>
                    <p class="text-sm font-bold text-slate-800">{{ $questions->count() }} Butir Soal</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-sm font-bold shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-medium">Jawaban Benar</span>
                    <p class="text-sm font-bold text-emerald-700">{{ $totalCorrect }} Soal Benar</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center text-sm font-bold shrink-0">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-medium">Jawaban Salah</span>
                    <p class="text-sm font-bold text-rose-700">{{ $questions->count() - $totalCorrect }} Soal</p>
                </div>
            </div>
        </div>

        {{-- Daftar Soal & Analisis Jawaban --}}
        <div class="space-y-4">
            <h2 class="text-sm font-bold text-slate-900">Rincian Lembar Jawaban Tiap Butir Soal</h2>

            @forelse ($questions as $index => $soal)
                @php
                    $ansRecord = $answersMap[$soal->id_soal_ujian] ?? null;
                    $chosenAnswer = strtoupper(trim($ansRecord->jawaban_dipilih ?? ''));
                    $correctKey = strtoupper(trim($soal->kunci_jawaban ?? ''));
                    $isCorrect = ($chosenAnswer !== '' && $chosenAnswer === $correctKey);
                @endphp
                <div class="bg-white rounded-2xl border {{ $isCorrect ? 'border-emerald-200' : ($chosenAnswer !== '' ? 'border-rose-200' : 'border-slate-200') }} shadow-sm p-6 space-y-4">
                    {{-- Header Soal --}}
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-slate-100 text-slate-800 flex items-center justify-center text-xs font-bold">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-xs font-bold text-slate-700">Soal Nomor {{ $index + 1 }}</span>
                        </div>

                        <div>
                            @if ($chosenAnswer === '')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                    <i class="fa-solid fa-circle-minus text-[10px]"></i>
                                    <span>Tidak Dijawab</span>
                                </span>
                            @elseif ($isCorrect)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                                    <span>Jawaban Benar</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                    <i class="fa-solid fa-circle-xmark text-[10px]"></i>
                                    <span>Jawaban Salah</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Pertanyaan --}}
                    <div class="text-sm font-semibold text-slate-900 leading-relaxed">
                        {!! nl2br(e($soal->teks_soal)) !!}
                    </div>

                    {{-- Pilihan Opsi A, B, C, D --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        @foreach (['A' => $soal->opsi_a, 'B' => $soal->opsi_b, 'C' => $soal->opsi_c, 'D' => $soal->opsi_d] as $optKey => $optText)
                            @php
                                $isThisChosen = ($chosenAnswer === $optKey);
                                $isThisCorrect = ($correctKey === $optKey);
                            @endphp
                            <div class="p-3 rounded-xl border text-xs flex items-start gap-2.5 transition-colors
                                {{ $isThisCorrect ? 'bg-emerald-50/80 border-emerald-300 text-emerald-900 font-semibold' : ($isThisChosen ? 'bg-rose-50 border-rose-300 text-rose-900 font-semibold' : 'bg-slate-50/50 border-slate-200 text-slate-700') }}">
                                <span class="w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold shrink-0
                                    {{ $isThisCorrect ? 'bg-emerald-600 text-white' : ($isThisChosen ? 'bg-rose-600 text-white' : 'bg-white border border-slate-300 text-slate-600') }}">
                                    {{ $optKey }}
                                </span>
                                <div class="flex-1 pt-0.5">
                                    {{ $optText }}
                                    @if ($isThisCorrect)
                                        <span class="inline-block ml-1 text-[10px] text-emerald-700 font-bold">(Kunci Jawaban)</span>
                                    @endif
                                    @if ($isThisChosen && !$isThisCorrect)
                                        <span class="inline-block ml-1 text-[10px] text-rose-700 font-bold">(Pilihan Siswa)</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400">
                    Belum ada butir soal pada ujian ini.
                </div>
            @endforelse
        </div>

    </div>
</x-app-guru-layout>

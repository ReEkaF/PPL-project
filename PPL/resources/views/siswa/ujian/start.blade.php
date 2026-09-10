<x-siswa-layout>
    <div class="max-w-4xl mx-auto space-y-6 pb-12">

        {{-- Top Sticky Bar (Exam Info & Timer) --}}
        <div class="sticky top-20 z-30 bg-slate-900/95 backdrop-blur text-white rounded-2xl px-5 py-3.5 shadow-lg border border-slate-800 flex items-center justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold px-2 py-0.5 bg-brand-500/20 text-brand-300 rounded border border-brand-400/30">CBT Online</span>
                    <span class="text-xs text-slate-400 truncate">{{ $ujian->kelasMataPelajaran?->mataPelajaran?->nama_matpel ?? 'Ujian Siswa' }}</span>
                </div>
                <h2 class="text-sm sm:text-base font-bold text-white truncate mt-0.5">{{ $ujian->judul }}</h2>
            </div>

            {{-- Timer Box --}}
            <div class="flex items-center gap-2.5 px-3.5 py-1.5 bg-slate-800 border border-slate-700 rounded-xl shrink-0">
                <svg class="w-4 h-4 text-amber-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-right">
                    <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold leading-tight">Sisa Waktu</p>
                    <p id="timer" class="text-sm font-mono font-bold text-amber-300 leading-tight">--:--</p>
                </div>
            </div>
        </div>

        {{-- CBT Exam Form --}}
        <form action="{{ route('siswa.ujian.submit', $ujian->id_ujian) }}" method="POST" id="cbtForm" class="space-y-5">
            @csrf

            @foreach ($ujian->soalUjian as $index => $soal)
                <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm space-y-4" id="soal-{{ $index + 1 }}">
                    {{-- Question Header --}}
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg">
                            Soal Nomor {{ $index + 1 }}
                        </span>
                        <span class="text-xs text-slate-400">Pilihan Ganda</span>
                    </div>

                    {{-- Question Text --}}
                    <div class="text-sm sm:text-base text-slate-800 leading-relaxed font-medium">
                        {{ $soal->teks_soal }}
                    </div>

                    {{-- Options List --}}
                    <div class="space-y-2.5 pt-1">
                        @php
                            $options = [
                                'A' => $soal->opsi_a,
                                'B' => $soal->opsi_b,
                                'C' => $soal->opsi_c,
                                'D' => $soal->opsi_d,
                            ];
                        @endphp

                        @foreach ($options as $key => $optValue)
                            @if ($optValue)
                                <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-all has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50/70 has-[:checked]:text-brand-900 group">
                                    <input type="radio" name="jawaban_{{ $soal->id_soal_ujian }}" value="{{ $optValue }}" required
                                        class="w-4 h-4 text-brand-600 focus:ring-brand-500 border-slate-300 mt-1 shrink-0">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <span class="w-6 h-6 rounded-lg bg-slate-100 group-hover:bg-slate-200 group-has-[:checked]:bg-brand-600 group-has-[:checked]:text-white text-xs font-bold text-slate-600 flex items-center justify-center shrink-0 transition-colors">
                                            {{ $key }}
                                        </span>
                                        <span class="text-sm text-slate-700 group-has-[:checked]:font-semibold group-has-[:checked]:text-brand-900 leading-snug">
                                            {{ $optValue }}
                                        </span>
                                    </div>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Bottom Submit Card --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-slate-500">
                        Pastikan semua soal telah kamu jawab. Jawaban yang telah dikumpulkan tidak dapat diubah kembali.
                    </p>
                </div>

                <button type="submit" onclick="return confirm('Apakah kamu yakin ingin mengumpulkan ujian ini sekarang?')"
                    class="px-6 py-2.5 bg-brand-800 hover:bg-brand-900 text-white text-sm font-semibold rounded-xl transition shadow-sm shrink-0">
                    Kumpulkan Jawaban
                </button>
            </div>
        </form>

    </div>

    <script>
        const endTime = new Date("{{ $endTime }}").getTime();
        const timerEl = document.getElementById('timer');
        const form = document.getElementById('cbtForm');

        function updateTimer() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance <= 0) {
                clearInterval(countdown);
                timerEl.textContent = '00:00';
                alert('Waktu ujian telah habis! Jawaban kamu akan otomatis dikumpulkan.');
                form.submit();
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            const formattedMin = String(minutes).padStart(2, '0');
            const formattedSec = String(seconds).padStart(2, '0');
            timerEl.textContent = `${formattedMin}:${formattedSec}`;
        }

        updateTimer();
        const countdown = setInterval(updateTimer, 1000);
    </script>
</x-siswa-layout>

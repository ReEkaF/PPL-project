<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Ujian & CBT Online</h1>
                <p class="text-sm text-slate-500 mt-0.5">Daftar asesmen dan ujian berbasis komputer yang terjadwal untuk kamu.</p>
            </div>
        </div>

        {{-- Flash Alerts --}}
        @if (session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start gap-3 shadow-xs">
                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-rose-900 text-sm">Tidak Dapat Mengakses Ujian</h4>
                    <p class="text-xs text-rose-700 mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3 shadow-xs">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-emerald-900 text-sm">Berhasil</h4>
                    <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Summary Metric Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('siswa.ujian.index', ['status' => 'semua']) }}"
                class="bg-white border {{ $currentStatus === 'semua' ? 'border-brand-300 ring-2 ring-brand-100' : 'border-slate-200' }} rounded-xl p-4 flex items-center gap-3.5 shadow-sm hover:shadow-md transition-all">
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Ujian</p>
                    <p class="text-lg font-bold text-slate-900">{{ $totalCount }} Ujian</p>
                </div>
            </a>

            <a href="{{ route('siswa.ujian.index', ['status' => 'belum']) }}"
                class="bg-white border {{ $currentStatus === 'belum' ? 'border-amber-300 ring-2 ring-amber-100' : 'border-slate-200' }} rounded-xl p-4 flex items-center gap-3.5 shadow-sm hover:shadow-md transition-all">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Belum Dikerjakan</p>
                    <p class="text-lg font-bold text-amber-700">{{ $belumCount }} Ujian</p>
                </div>
            </a>

            <a href="{{ route('siswa.ujian.index', ['status' => 'selesai']) }}"
                class="bg-white border {{ $currentStatus === 'selesai' ? 'border-emerald-300 ring-2 ring-emerald-100' : 'border-slate-200' }} rounded-xl p-4 flex items-center gap-3.5 shadow-sm hover:shadow-md transition-all">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Sudah Selesai</p>
                    <p class="text-lg font-bold text-emerald-700">{{ $selesaiCount }} Ujian</p>
                </div>
            </a>
        </div>

        {{-- Status Filter Tabs --}}
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl w-fit">
            <a href="{{ route('siswa.ujian.index', ['status' => 'semua']) }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors flex items-center gap-2
                {{ $currentStatus === 'semua' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                <span>Semua Ujian</span>
                <span class="px-1.5 py-0.5 text-xs rounded-full {{ $currentStatus === 'semua' ? 'bg-slate-100 text-slate-700' : 'bg-slate-200/60 text-slate-500' }}">
                    {{ $totalCount }}
                </span>
            </a>
            <a href="{{ route('siswa.ujian.index', ['status' => 'belum']) }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors flex items-center gap-2
                {{ $currentStatus === 'belum' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                <span>Belum Dikerjakan</span>
                <span class="px-1.5 py-0.5 text-xs rounded-full {{ $currentStatus === 'belum' ? 'bg-amber-100 text-amber-700' : 'bg-slate-200/60 text-slate-500' }}">
                    {{ $belumCount }}
                </span>
            </a>
            <a href="{{ route('siswa.ujian.index', ['status' => 'selesai']) }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors flex items-center gap-2
                {{ $currentStatus === 'selesai' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                <span>Sudah Selesai</span>
                <span class="px-1.5 py-0.5 text-xs rounded-full {{ $currentStatus === 'selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200/60 text-slate-500' }}">
                    {{ $selesaiCount }}
                </span>
            </a>
        </div>

        {{-- Exam Cards List --}}
        @php
            $siswaId = auth('web-siswa')->user()->id_siswa ?? null;
        @endphp

        @if ($ujians->isEmpty())
            <div class="bg-white border border-slate-200 rounded-xl p-12 text-center">
                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">
                    @if ($currentStatus === 'belum')
                        Semua Ujian Telah Dikerjakan!
                    @elseif ($currentStatus === 'selesai')
                        Belum Ada Ujian yang Selesai
                    @else
                        Tidak Ada Ujian Tersedia
                    @endif
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    @if ($currentStatus === 'belum')
                        Hebat, tidak ada ujian aktif yang tersisa untuk dikerjakan saat ini.
                    @elseif ($currentStatus === 'selesai')
                        Kamu belum pernah menyelesaikan atau mengumpulkan ujian apapun.
                    @else
                        Saat ini belum ada jadwal ujian untuk kelas kamu.
                    @endif
                </p>

                @if ($currentStatus !== 'semua')
                    <a href="{{ route('siswa.ujian.index', ['status' => 'semua']) }}"
                        class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition">
                        Lihat Semua Ujian
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($ujians as $ujian)
                    @php
                        $sudahSubmit = $ujian->pengumpulanUjian->where('siswa_id', $siswaId)->first();
                        $mapelNama = $ujian->kelasMataPelajaran?->mataPelajaran?->nama_matpel ?? $ujian->jenis_ujian ?? 'Ujian';
                        $jumlahSoal = $ujian->soalUjian->count();
                        $durasiMenit = $ujian->durasi_menit ?: 60;
                        $hasToken = !empty($ujian->token);

                        $now = now();
                        $belumMulai = $ujian->waktu_mulai && $now->lt(\Carbon\Carbon::parse($ujian->waktu_mulai));
                        $sudahBerakhir = $ujian->waktu_selesai && $now->gt(\Carbon\Carbon::parse($ujian->waktu_selesai));
                        $isReady = !$sudahSubmit && $jumlahSoal > 0 && !$belumMulai && !$sudahBerakhir;
                    @endphp

                    {{-- Modal Validasi & Aturan per Ujian --}}
                    <div id="aturan-modal-{{ $ujian->id_ujian }}" tabindex="-1" aria-hidden="true"
                        x-data="{ agreed: false, tokenInput: '' }"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-lg max-h-full">
                            <div class="relative bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                                {{-- Header Modal --}}
                                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-bold text-slate-900 leading-none">
                                                Konfirmasi & Tata Tertib Ujian
                                            </h3>
                                            <p class="text-xs text-slate-500 mt-1">{{ $mapelNama }}</p>
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-700 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center transition"
                                        data-modal-hide="aturan-modal-{{ $ujian->id_ujian }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Body Modal --}}
                                <div class="p-6 space-y-4 text-sm text-slate-600">
                                    {{-- Ringkasan Asesmen --}}
                                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 grid grid-cols-2 gap-3 text-xs">
                                        <div>
                                            <span class="text-slate-400 block">Judul Asesmen:</span>
                                            <span class="font-bold text-slate-800">{{ $ujian->judul }}</span>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 block">Durasi Pengerjaan:</span>
                                            <span class="font-bold text-brand-700">{{ $durasiMenit }} Menit</span>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 block">Jumlah Butir Soal:</span>
                                            <span class="font-bold text-slate-800">{{ $jumlahSoal }} Soal Pilihan Ganda</span>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 block">Jadwal Akses:</span>
                                            @if ($ujian->waktu_mulai && $ujian->waktu_selesai)
                                                <span class="font-semibold text-slate-700">
                                                    {{ \Carbon\Carbon::parse($ujian->waktu_mulai)->format('d/m/Y H:i') }} - {{ \Carbon\Carbon::parse($ujian->waktu_selesai)->format('H:i') }}
                                                </span>
                                            @else
                                                <span class="font-semibold text-slate-700">Fleksibel</span>
                                            @endif
                                        </div>
                                        <div class="col-span-2 pt-1 border-t border-slate-200/60 flex items-center justify-between">
                                            <span class="text-slate-400">Status Akses:</span>
                                            @if ($sudahSubmit)
                                                <span class="font-bold text-emerald-700">Selesai (Nilai: {{ $sudahSubmit->nilai }})</span>
                                            @elseif ($jumlahSoal == 0)
                                                <span class="font-bold text-rose-600">Soal Belum Siap</span>
                                            @elseif ($sudahBerakhir)
                                                <span class="font-bold text-slate-500">Waktu Pelaksanaan Berakhir</span>
                                            @elseif ($belumMulai)
                                                <span class="font-bold text-amber-600">Belum Dibuka (Mulai: {{ \Carbon\Carbon::parse($ujian->waktu_mulai)->format('H:i') }} WIB)</span>
                                            @else
                                                <span class="font-bold text-emerald-600">Siap Dikerjakan Sekarang</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($sudahSubmit)
                                        <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs flex items-start gap-2.5">
                                            <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div>
                                                <p class="font-bold">Ujian Telah Selesai</p>
                                                <p class="mt-0.5">Kamu telah mengumpulkan ujian ini pada {{ $sudahSubmit->tanggal_pengumpulan }} dengan perolehan skor {{ $sudahSubmit->nilai }}. Ujian tidak dapat dikerjakan ulang.</p>
                                            </div>
                                        </div>
                                    @elseif ($jumlahSoal == 0)
                                        <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs flex items-start gap-2.5">
                                            <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            <div>
                                                <p class="font-bold">Soal Ujian Belum Tersedia</p>
                                                <p class="mt-0.5">Guru mata pelajaran belum mengunggah butir soal untuk asesmen ini. Silakan konfirmasi ke guru pengajar Anda.</p>
                                            </div>
                                        </div>
                                    @elseif ($sudahBerakhir)
                                        <div class="p-3.5 bg-slate-100 border border-slate-300 rounded-xl text-slate-700 text-xs flex items-start gap-2.5">
                                            <svg class="w-4 h-4 text-slate-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div>
                                                <p class="font-bold">Waktu Ujian Telah Berakhir</p>
                                                <p class="mt-0.5">Jadwal pelaksanaan ujian telah ditutup pada {{ \Carbon\Carbon::parse($ujian->waktu_selesai)->translatedFormat('d F Y, H:i') }} WIB. Kamu tidak dapat lagi memulai pengerjaan.</p>
                                            </div>
                                        </div>
                                    @elseif ($belumMulai)
                                        <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs flex items-start gap-2.5">
                                            <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div>
                                                <p class="font-bold">Ujian Belum Dimulai</p>
                                                <p class="mt-0.5">Asesmen ini baru dapat diakses pada {{ \Carbon\Carbon::parse($ujian->waktu_mulai)->translatedFormat('d F Y, H:i') }} WIB. Silakan bersiap sebelum waktu pengerjaan dibuka.</p>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Tata Tertib Pengerjaan --}}
                                        <div class="space-y-2 text-xs">
                                            <p class="font-bold text-slate-800">Tata Tertib Pengerjaan CBT:</p>
                                            <ul class="space-y-1.5 text-slate-600">
                                                <li class="flex items-start gap-2">
                                                    <span class="w-4 h-4 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 text-[10px] font-bold mt-0.5">1</span>
                                                    <span>Waktu pengerjaan <strong>{{ $durasiMenit }} menit</strong> dihitung mundur secara otomatis.</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="w-4 h-4 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 text-[10px] font-bold mt-0.5">2</span>
                                                    <span>Dilarang menutup tab, berganti aplikasi, atau menyegarkan (refresh) jendela ujian.</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <span class="w-4 h-4 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 text-[10px] font-bold mt-0.5">3</span>
                                                    <span>Ujian akan otomatis disubmit ketika batas waktu habis.</span>
                                                </li>
                                            </ul>
                                        </div>

                                        {{-- Input Token Ujian dari Pengawas (Jika Ujian Memakai Token) --}}
                                        @if ($hasToken)
                                            <div class="space-y-1.5 p-3.5 bg-brand-50/50 border border-brand-200 rounded-xl">
                                                <label class="block text-xs font-bold text-brand-900">
                                                    Token CBT (Dapatkan dari Guru/Pengawas):
                                                </label>
                                                <p class="text-[11px] text-slate-500">
                                                    Masukkan kode token yang diberikan oleh pengawas di ruang ujian.
                                                </p>
                                                <input type="text" x-model="tokenInput" maxlength="10" placeholder="Ketik token di sini"
                                                    class="w-full uppercase tracking-widest font-mono text-sm px-3 py-2 bg-white border border-brand-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-800">
                                            </div>
                                        @endif

                                        {{-- Pakta Integritas / Kejujuran Siswa --}}
                                        <label class="flex items-start gap-2.5 p-3 bg-amber-50/60 border border-amber-200 rounded-xl cursor-pointer hover:bg-amber-50 transition">
                                            <input type="checkbox" x-model="agreed"
                                                class="mt-0.5 rounded border-amber-300 text-brand-800 focus:ring-brand-700">
                                            <span class="text-xs text-amber-900 font-medium leading-relaxed select-none">
                                                <strong>Pakta Integritas:</strong> Saya menyatakan siap mengikuti ujian ini secara jujur, mandiri, dan mematuhi seluruh tata tertib CBT sekolah.
                                            </span>
                                        </label>
                                    @endif
                                </div>

                                {{-- Footer Modal --}}
                                <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
                                    <button type="button"
                                        class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold rounded-lg transition"
                                        data-modal-hide="aturan-modal-{{ $ujian->id_ujian }}">
                                        Tutup
                                    </button>

                                    @if ($isReady)
                                        @php
                                            $startUrl = route('siswa.ujian.start', $ujian->id_ujian);
                                        @endphp
                                        <a :href="(agreed {{ $hasToken ? '&& tokenInput.trim().length > 0' : '' }}) ? '{{ $startUrl }}' + (tokenInput.trim() ? '?token=' + encodeURIComponent(tokenInput.trim()) : '') : '#'"
                                            :class="(agreed {{ $hasToken ? '&& tokenInput.trim().length > 0' : '' }}) ? 'bg-brand-800 hover:bg-brand-900 text-white cursor-pointer shadow-sm' : 'bg-slate-200 text-slate-400 cursor-not-allowed pointer-events-none'"
                                            class="px-4 py-2 text-xs font-semibold rounded-lg transition inline-flex items-center gap-1.5">
                                            <span>Mulai Ujian Sekarang</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Exam Card --}}
                    <div class="bg-white border border-slate-200 rounded-xl p-5 hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between gap-3 mb-2.5">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="px-2.5 py-1 bg-brand-50 text-brand-700 text-xs font-semibold rounded-md border border-brand-200/50">
                                        {{ $mapelNama }}
                                    </span>
                                    @if ($hasToken)
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-semibold rounded border border-slate-200" title="Memerlukan Token Pengawas">
                                            Token CBT
                                        </span>
                                    @endif
                                </div>

                                @if ($sudahSubmit)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Selesai · Nilai: {{ $sudahSubmit->nilai }}
                                    </span>
                                @elseif ($jumlahSoal == 0)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Soal Belum Siap
                                    </span>
                                @elseif ($sudahBerakhir)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Sudah Berakhir
                                    </span>
                                @elseif ($belumMulai)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Mulai {{ \Carbon\Carbon::parse($ujian->waktu_mulai)->format('d M H:i') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-700 border border-brand-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                                        Siap Dikerjakan
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-base font-bold text-slate-900 leading-snug">
                                {{ $ujian->judul }}
                            </h3>

                            @if ($ujian->deskripsi)
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                    {{ $ujian->deskripsi }}
                                </p>
                            @endif

                            <div class="grid grid-cols-2 gap-2 mt-4 pt-3 border-t border-slate-100 text-xs text-slate-500">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Durasi: <strong>{{ $durasiMenit }} Menit</strong></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <span>Jumlah: <strong>{{ $jumlahSoal }} Soal</strong></span>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-2 mt-5 pt-3 border-t border-slate-100">
                            @if ($sudahSubmit)
                                <button type="button"
                                    data-modal-target="aturan-modal-{{ $ujian->id_ujian }}"
                                    data-modal-toggle="aturan-modal-{{ $ujian->id_ujian }}"
                                    class="flex-1 py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg text-center transition-colors">
                                    Rincian Nilai
                                </button>
                                <span class="flex-1 py-2 px-3 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-lg text-center border border-emerald-200/60">
                                    Sudah Selesai
                                </span>
                            @elseif ($jumlahSoal == 0)
                                <button type="button"
                                    data-modal-target="aturan-modal-{{ $ujian->id_ujian }}"
                                    data-modal-toggle="aturan-modal-{{ $ujian->id_ujian }}"
                                    class="flex-1 py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg text-center transition-colors">
                                    Informasi
                                </button>
                                <span class="flex-1 py-2 px-3 bg-slate-100 text-slate-400 text-xs font-semibold rounded-lg text-center cursor-not-allowed">
                                    Soal Belum Siap
                                </span>
                            @elseif ($sudahBerakhir)
                                <button type="button"
                                    data-modal-target="aturan-modal-{{ $ujian->id_ujian }}"
                                    data-modal-toggle="aturan-modal-{{ $ujian->id_ujian }}"
                                    class="flex-1 py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg text-center transition-colors">
                                    Informasi
                                </button>
                                <span class="flex-1 py-2 px-3 bg-slate-100 text-slate-500 text-xs font-semibold rounded-lg text-center cursor-not-allowed">
                                    Sudah Berakhir
                                </span>
                            @elseif ($belumMulai)
                                <button type="button"
                                    data-modal-target="aturan-modal-{{ $ujian->id_ujian }}"
                                    data-modal-toggle="aturan-modal-{{ $ujian->id_ujian }}"
                                    class="flex-1 py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg text-center transition-colors">
                                    Jadwal Info
                                </button>
                                <span class="flex-1 py-2 px-3 bg-amber-50 text-amber-700 text-xs font-semibold rounded-lg text-center border border-amber-200 cursor-not-allowed">
                                    Belum Dibuka
                                </span>
                            @else
                                <button type="button"
                                    data-modal-target="aturan-modal-{{ $ujian->id_ujian }}"
                                    data-modal-toggle="aturan-modal-{{ $ujian->id_ujian }}"
                                    class="flex-1 py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg text-center transition-colors">
                                    Aturan & Info
                                </button>
                                <button type="button"
                                    data-modal-target="aturan-modal-{{ $ujian->id_ujian }}"
                                    data-modal-toggle="aturan-modal-{{ $ujian->id_ujian }}"
                                    class="flex-1 py-2 px-3 bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold rounded-lg text-center transition-colors shadow-sm">
                                    Mulai Ujian
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($ujians->hasPages())
                <div class="pt-4">
                    {{ $ujians->links() }}
                </div>
            @endif
        @endif

    </div>
</x-siswa-layout>

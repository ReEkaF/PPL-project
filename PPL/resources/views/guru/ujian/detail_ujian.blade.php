<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6" x-data="{ tab: 'mengumpulkan', search: '' }">

        {{-- Navigasi Kembali & Header Halaman --}}
        <div>
            <a href="{{ route('ujian.show') }}"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-brand-800 transition-colors mb-3">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Daftar Ujian</span>
            </a>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-brand-50 text-brand-800 border border-brand-200/60">
                                {{ $ujian->jenis_ujian ?? 'Ujian' }}
                            </span>
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700">
                                Kelas {{ $ujian->kelasMataPelajaran->kelas->nama_kelas ?? '-' }}
                            </span>
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-sky-50 text-sky-700">
                                {{ $ujian->kelasMataPelajaran->mataPelajaran->nama_matpel ?? '-' }}
                            </span>
                            @if ($ujian->token)
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-mono font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    Token: {{ $ujian->token }}
                                </span>
                            @endif
                        </div>

                        <h1 class="text-xl font-bold text-slate-900 tracking-tight">
                            {{ $ujian->judul }}
                        </h1>

                        @if ($ujian->deskripsi)
                            <p class="text-xs text-slate-500 max-w-3xl leading-relaxed">
                                {{ $ujian->deskripsi }}
                            </p>
                        @endif

                        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 pt-1">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar text-slate-400 text-[11px]"></i>
                                <span>Tanggal: {{ \Carbon\Carbon::parse($ujian->tanggal_dibuat)->translatedFormat('d F Y') }}</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-slate-400 text-[11px]"></i>
                                <span>Durasi: {{ $ujian->durasi_menit ?? 60 }} Menit</span>
                            </span>
                            @if ($ujian->topik)
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-tag text-slate-400 text-[10px]"></i>
                                    <span>Topik: {{ $ujian->topik->judul_topik }}</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Quick Action Buttons --}}
                    <div class="flex flex-wrap items-center gap-2 shrink-0 self-start lg:self-center">
                        <a href="{{ route('guru.ujian.soal_ujian', $ujian->id_ujian) }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                            <i class="fa-solid fa-list-check text-slate-400 text-[11px]"></i>
                            <span>Bank Soal ({{ $ujian->soal_ujian_count ?? 0 }})</span>
                        </a>
                        <a href="{{ route('guru.ujian.add.soal', $ujian->id_ujian) }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-brand-800 text-white hover:bg-brand-900 transition-colors shadow-sm">
                            <i class="fa-solid fa-plus text-[11px]"></i>
                            <span>Tambah Butir Soal</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash Notification --}}
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Overview Metrics Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-slate-900">{{ $pengumpulan->count() }}</span>
                    <p class="text-xs text-slate-500 font-medium">Sudah Mengerjakan</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-slate-900">{{ $belumMengerjakan->count() }}</span>
                    <p class="text-xs text-slate-500 font-medium">Belum Mengerjakan</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-slate-900">{{ $rataRata }}</span>
                    <p class="text-xs text-slate-500 font-medium">Nilai Rata-rata</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-slate-900">{{ $nilaiTertinggi }}</span>
                    <p class="text-xs text-slate-500 font-medium">Nilai Tertinggi</p>
                </div>
            </div>
        </div>

        {{-- Submissions & Student Progress Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- Tabs & Search Toolbar --}}
            <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <button type="button" @click="tab = 'mengumpulkan'"
                        :class="tab === 'mengumpulkan' ? 'bg-brand-800 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3.5 py-1.5 rounded-xl font-semibold text-xs transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-check text-[11px]"></i>
                        <span>Siswa Mengumpulkan</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px]"
                            :class="tab === 'mengumpulkan' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700'">
                            {{ $pengumpulan->count() }}
                        </span>
                    </button>

                    <button type="button" @click="tab = 'belum'"
                        :class="tab === 'belum' ? 'bg-brand-800 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3.5 py-1.5 rounded-xl font-semibold text-xs transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-clock text-[11px]"></i>
                        <span>Belum Mengerjakan</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px]"
                            :class="tab === 'belum' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700'">
                            {{ $belumMengerjakan->count() }}
                        </span>
                    </button>
                </div>

                {{-- Live Search Input --}}
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" x-model="search"
                        placeholder="Cari nama atau NISN siswa..."
                        class="w-full pl-9 pr-4 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all text-slate-800 placeholder-slate-400">
                </div>
            </div>

            {{-- TAB 1: SISWA SUDAH MENGUMPULKAN --}}
            <div x-show="tab === 'mengumpulkan'" class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[11px] font-semibold">
                            <th class="py-3 px-4 w-12 text-center">No</th>
                            <th class="py-3 px-4">Nama Siswa</th>
                            <th class="py-3 px-4">Waktu Pengerjaan</th>
                            <th class="py-3 px-4 text-center">Nilai CBT</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Aksi & Koreksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengumpulan as $index => $item)
                            @php
                                $namaSiswa = $item->siswa->nama_siswa ?? 'Siswa';
                                $nisn = $item->siswa->nisn ?? '-';
                                $nilai = $item->nilai;
                                $scoreNum = is_numeric($nilai) ? (float) $nilai : 0;
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors"
                                x-show="!search || '{{ strtolower($namaSiswa . ' ' . $nisn) }}'.includes(search.toLowerCase())">
                                {{-- No --}}
                                <td class="py-3.5 px-4 text-center text-slate-400 font-medium">
                                    {{ $index + 1 }}
                                </td>

                                {{-- Siswa Info --}}
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900">{{ $namaSiswa }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">NISN: {{ $nisn }}</div>
                                </td>

                                {{-- Waktu Pengumpulan --}}
                                <td class="py-3.5 px-4 text-slate-600">
                                    @if ($item->tanggal_pengumpulan)
                                        <div class="font-medium text-slate-800">
                                            {{ \Carbon\Carbon::parse($item->tanggal_pengumpulan)->translatedFormat('d M Y, H:i') }} WIB
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic">-</span>
                                    @endif
                                </td>

                                {{-- Nilai CBT --}}
                                <td class="py-3.5 px-4 text-center">
                                    @if ($nilai !== null)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border
                                            {{ $scoreNum >= 75 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($scoreNum >= 60 ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                            {{ $nilai }} / 100
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic">Belum Dinilai</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-check text-[8px]"></i>
                                        <span>Selesai</span>
                                    </span>
                                </td>

                                {{-- Aksi & Koreksi --}}
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('guru.ujian.pengumpulan.koreksi', $item->id_pengumpulan_ujian) }}"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-brand-50 text-brand-800 hover:bg-brand-100 font-semibold transition-colors text-[11px]"
                                            title="Buka Lembar Jawaban Siswa">
                                            <i class="fa-solid fa-file-signature text-[10px]"></i>
                                            <span>Lembar Jawaban</span>
                                        </a>

                                        <form action="{{ route('guru.dashboard.pengumpulan_ujian.destroy', $item->id_pengumpulan_ujian) }}" method="POST"
                                            onsubmit="return confirm('Hapus hasil pengumpulan ujian siswa ini? Siswa dapat diperkenankan ujian ulang.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition-colors rounded-lg hover:bg-rose-50"
                                                title="Reset / Hapus Pengumpulan">
                                                <i class="fa-regular fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-slate-400">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-xl">
                                        <i class="fa-solid fa-clipboard-user"></i>
                                    </div>
                                    <p class="font-semibold text-slate-700">Belum ada siswa yang mengumpulkan ujian ini</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Hasil pengerjaan CBT siswa akan otomatis tampil di sini saat siswa menekan tombol submit.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- TAB 2: SISWA BELUM MENGERJAKAN --}}
            <div x-show="tab === 'belum'" class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[11px] font-semibold">
                            <th class="py-3 px-4 w-12 text-center">No</th>
                            <th class="py-3 px-4">Nama Siswa</th>
                            <th class="py-3 px-4">NISN</th>
                            <th class="py-3 px-4">Jenis Kelamin</th>
                            <th class="py-3 px-4 text-center">Status Pengerjaan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($belumMengerjakan as $index => $siswa)
                            @php
                                $nama = $siswa->nama_siswa ?? '-';
                                $nisn = $siswa->nisn ?? '-';
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors"
                                x-show="!search || '{{ strtolower($nama . ' ' . $nisn) }}'.includes(search.toLowerCase())">
                                <td class="py-3.5 px-4 text-center text-slate-400 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    {{ $nama }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-500">
                                    {{ $nisn }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-600">
                                    {{ $siswa->jenis_kelamin ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="fa-regular fa-clock text-[9px]"></i>
                                        <span>Belum Mengerjakan</span>
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center text-slate-400">
                                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-2 text-xl">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </div>
                                    <p class="font-semibold text-slate-800">Luar biasa! Seluruh siswa telah menyelesaikan ujian ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-guru-layout>

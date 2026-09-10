<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6" x-data="{ search: '' }">

        {{-- Page Header & Back Button --}}
        <div>
            <a href="{{ route('ujian.show') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-800 transition-colors mb-2">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Beranda Ujian</span>
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Hasil & Pengumpulan Ujian Siswa</h1>
                    <p class="text-sm text-slate-500 mt-0.5">
                        Rekap hasil pengerjaan CBT dan perolehan nilai otomatis siswa.
                    </p>
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

        {{-- Submissions Table Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-slate-900 text-base">Riwayat Pengerjaan CBT</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar siswa yang telah menyelesaikan sesi ujian</p>
                </div>

                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" x-model="search"
                        placeholder="Cari siswa atau judul ujian..."
                        class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all text-slate-800 placeholder-slate-400">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[11px] font-semibold">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Nama Siswa</th>
                            <th class="py-3.5 px-4">Paket Ujian & Kelas</th>
                            <th class="py-3.5 px-4">Waktu Selesai</th>
                            <th class="py-3.5 px-4 text-center">Nilai CBT</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengumpulanUjian as $index => $item)
                            @php
                                $namaSiswa = $item->siswa->nama_siswa ?? '-';
                                $judulUjian = $item->ujian->judul ?? '-';
                                $score = $item->nilai;
                                $scoreNum = is_numeric($score) ? floatval($score) : 0;
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors"
                                x-show="!search || '{{ strtolower($namaSiswa) }}'.includes(search.toLowerCase()) || '{{ strtolower($judulUjian) }}'.includes(search.toLowerCase())">
                                
                                {{-- No --}}
                                <td class="py-3.5 px-4 text-center text-slate-400 font-medium">
                                    {{ $index + 1 }}
                                </td>

                                {{-- Student --}}
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-900">{{ $namaSiswa }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $item->siswa->nisn ?? '-' }}</div>
                                </td>

                                {{-- Exam & Class --}}
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-800">{{ $judulUjian }}</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">
                                        Kelas {{ $item->ujian->kelasMataPelajaran->kelas->nama_kelas ?? '-' }}
                                    </div>
                                </td>

                                {{-- Submission Date --}}
                                <td class="py-3.5 px-4 text-slate-600">
                                    {{ !empty($item->tanggal_pengumpulan) ? \Carbon\Carbon::parse($item->tanggal_pengumpulan)->format('d M Y, H:i') . ' WIB' : '-' }}
                                </td>

                                {{-- Score --}}
                                <td class="py-3.5 px-4 text-center">
                                    @if ($score !== null)
                                        <span class="inline-block px-3 py-1 rounded-xl text-xs font-bold border
                                            {{ $scoreNum >= 75 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($scoreNum >= 60 ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                            {{ $score }} / 100
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic">Belum Dinilai</span>
                                    @endif
                                </td>

                                {{-- Action --}}
                                <td class="py-3.5 px-4 text-center">
                                    <form action="{{ route('guru.dashboard.pengumpulan_ujian.destroy', $item->id_pengumpulan_ujian) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengumpulan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition-colors" title="Hapus Data">
                                            <i class="fa-regular fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs">
                                    Belum ada rekaman pengumpulan ujian yang masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-guru-layout>

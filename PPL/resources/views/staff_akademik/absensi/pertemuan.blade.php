<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
        {{-- Session Flash Messages --}}
        @if(session('success'))
            <div class="flex items-center justify-between p-4 text-xs font-medium text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-sm text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-center justify-between p-4 text-xs font-medium text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-sm text-rose-600"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        {{-- Header & Breadcrumbs --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs">
                        <li class="inline-flex items-center">
                            <a href="{{ route('staff_akademik.dashboard') }}" class="text-slate-500 hover:text-brand-800 transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-house text-[11px]"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <a href="{{ route('akademik.absensi.index') }}" class="text-slate-500 hover:text-brand-800 transition-colors">Rekap Absensi</a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Kelas {{ $detail->kelas->nama_kelas }}</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Rincian Pertemuan & Presensi Kelas</h1>
                <p class="text-xs text-slate-500">
                    Daftar pertemuan tatap muka, distribusi kode QR presensi, dan rekapitulasi kehadiran siswa.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('akademik.absensi.index') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Rekap</span>
                </a>
            </div>
        </div>

        {{-- Detail Mata Pelajaran Info Card --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5 sm:p-6 shadow-sm">
            <div class="flex items-center gap-3.5 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-brand-50 border border-brand-100 text-brand-800 flex items-center justify-center font-bold text-sm font-mono shrink-0">
                    {{ substr($detail->kelas->nama_kelas ?? 'K', 0, 2) }}
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">
                        {{ $detail->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }} — Kelas {{ $detail->kelas->nama_kelas }}
                    </h2>
                    <p class="text-xs text-slate-500">Tenaga Pendidik: <strong class="text-slate-700">{{ $detail->guru->nama_guru ?? '-' }}</strong></p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 text-xs">
                <div>
                    <p class="text-[11px] text-slate-400 font-medium">Hari Pembelajaran</p>
                    <p class="font-semibold text-slate-800 mt-0.5">{{ $detail->hari->nama_hari ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[11px] text-slate-400 font-medium">Jam Pelajaran</p>
                    <p class="font-mono font-semibold text-slate-800 mt-0.5">
                        {{ substr($detail->waktu_mulai ?? '', 0, 5) }} - {{ substr($detail->waktu_selesai ?? '', 0, 5) }} WIB
                    </p>
                </div>
                <div>
                    <p class="text-[11px] text-slate-400 font-medium">Total Pertemuan</p>
                    <p class="font-mono font-semibold text-slate-800 mt-0.5">{{ $detail->pertemuan->count() }} Sesi Terdaftar</p>
                </div>
                <div>
                    <p class="text-[11px] text-slate-400 font-medium">Status Jadwal</p>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100 mt-0.5">
                        <i class="fa-solid fa-circle-check text-[9px]"></i>
                        <span>Aktif</span>
                    </span>
                </div>
            </div>
        </div>

        {{-- Form Generate Pertemuan (Jika belum ada pertemuan) --}}
        @if ($detail->pertemuan->isEmpty())
            <div class="bg-white border border-slate-200 rounded-xl p-5 sm:p-6 shadow-sm">
                <div class="mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900">Generate Pertemuan Presensi Otomatis</h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Tentukan tanggal awal dan kuota total pertemuan untuk menghasilkan QR Code dan daftar hadir secara serentak.
                    </p>
                </div>
                <form action="{{ route('akademik.absensi.generate', $detail->id_kelas_mata_pelajaran) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_week_date" class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Pertemuan Pertama</label>
                            <input type="date" id="first_week_date" name="first_week_date" required
                                class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                            @if ($errors->has('first_week_date'))
                                <p class="text-[11px] text-rose-600 mt-1">{{ $errors->first('first_week_date') }}</p>
                            @endif
                        </div>
                        <div>
                            <label for="total_meetings" class="block text-xs font-semibold text-slate-700 mb-1.5">Jumlah Total Pertemuan (Semester)</label>
                            <input type="number" id="total_meetings" name="total_meetings" min="1" max="32" placeholder="Contoh: 16" required
                                class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                            @if ($errors->has('total_meetings'))
                                <p class="text-[11px] text-rose-600 mt-1">{{ $errors->first('total_meetings') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="pt-2 flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-medium text-white bg-brand-800 hover:bg-brand-900 rounded-lg shadow-sm transition-colors">
                            <i class="fa-solid fa-wand-magic-sparkles text-[11px]"></i>
                            <span>Generate Sesi Presensi</span>
                        </button>
                    </div>
                </form>
            </div>
        @else
            {{-- Toolbar Aksi Tambahan (Reset Sesi) --}}
            <div class="flex items-center justify-between bg-slate-50/70 border border-slate-200 rounded-xl p-4">
                <div class="space-y-0.5">
                    <p class="text-xs font-semibold text-slate-800">Manajemen Sesi Presensi</p>
                    <p class="text-[11px] text-slate-500">Anda dapat mengatur ulang seluruh pertemuan jika terdapat perubahan kalender akademik.</p>
                </div>
                <form id="reset-form" action="{{ route('akademik.absensi.reset', $detail->id_kelas_mata_pelajaran) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmReset()"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg transition-colors">
                        <i class="fa-solid fa-arrow-rotate-left text-[11px]"></i>
                        <span>Reset Pertemuan</span>
                    </button>
                </form>
            </div>
        @endif

        {{-- Tabel Daftar Pertemuan --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/40 flex items-center justify-between">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Daftar Pertemuan & Rekap Kehadiran</h2>
                <span class="text-xs text-slate-500 font-mono">{{ $detail->pertemuan->count() }} Sesi Terjadwal</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-700 font-semibold uppercase text-[11px] tracking-wider">
                        <tr>
                            <th class="px-5 py-3 w-16 text-center">Sesi</th>
                            <th class="px-5 py-3 w-44">Tanggal Pertemuan</th>
                            <th class="px-5 py-3 w-28 text-center">QR Code</th>
                            <th class="px-5 py-3">Rekapitulasi Kehadiran Siswa</th>
                            <th class="px-5 py-3 text-right w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($detail->pertemuan as $pertemuan)
                            @php
                                $hadirCount = $pertemuan->absensisiswa->where('status_absensi', 'Hadir')->count();
                                $izinCount = $pertemuan->absensisiswa->where('status_absensi', 'Izin')->count();
                                $sakitCount = $pertemuan->absensisiswa->where('status_absensi', 'Sakit')->count();
                                $alpaCount = $pertemuan->absensisiswa->where('status_absensi', 'Alpa')->count();
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 py-3.5 text-center font-mono font-bold text-slate-900">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-700 text-xs">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 font-medium text-slate-800 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-regular fa-calendar text-slate-400 text-xs"></i>
                                        <span>{{ \Carbon\Carbon::parse($pertemuan->tanggal_pertemuan)->translatedFormat('d F Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if ($pertemuan->qr_code)
                                        <button type="button" onclick="openQrModal('{{ $loop->iteration }}', '{{ asset('storage/' . $pertemuan->qr_code) }}', '{{ \Carbon\Carbon::parse($pertemuan->tanggal_pertemuan)->translatedFormat('d F Y') }}')"
                                            class="inline-flex items-center justify-center p-1 rounded-lg border border-slate-200 hover:border-brand-500 hover:bg-brand-50/40 transition-colors group"
                                            title="Klik untuk memperbesar QR Code">
                                            <img src="{{ asset('storage/' . $pertemuan->qr_code) }}"
                                                 alt="QR Pertemuan {{ $loop->iteration }}"
                                                 class="w-10 h-10 rounded object-contain">
                                        </button>
                                    @else
                                        <span class="text-slate-400 italic text-[11px]">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-[#EAF6EF] text-[#1F7A46]">
                                            <span>Hadir:</span>
                                            <strong class="font-mono">{{ $hadirCount }}</strong>
                                        </span>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-[#E5F1FB] text-[#1D5D8F]">
                                            <span>Izin:</span>
                                            <strong class="font-mono">{{ $izinCount }}</strong>
                                        </span>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-[#FDF3E4] text-[#92620A]">
                                            <span>Sakit:</span>
                                            <strong class="font-mono">{{ $sakitCount }}</strong>
                                        </span>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-[#FCECEC] text-[#B4322D]">
                                            <span>Alpa:</span>
                                            <strong class="font-mono">{{ $alpaCount }}</strong>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <a href="{{ route('akademik.absensi.pertemuan.details', ['id' => $detail->id_kelas_mata_pelajaran, 'pertemuan' => $pertemuan->id_pertemuan]) }}"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-100 rounded-lg transition-colors">
                                        <span>Rincian</span>
                                        <i class="fa-solid fa-chevron-right text-[9px]"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                    <i class="fa-regular fa-calendar-xmark text-3xl mb-2 text-slate-300 block"></i>
                                    <span>Belum ada data sesi pertemuan. Silakan gunakan formulir generate di atas.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Preview QR Code Dinamis --}}
    <div id="qrModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden text-center">
            <div class="flex items-center justify-between p-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-xs font-bold text-slate-900" id="qrModalTitle">QR Code Presensi</h3>
                <button type="button" onclick="closeQrModal()"
                    class="text-slate-400 hover:text-slate-700 rounded-lg text-xs w-8 h-8 inline-flex justify-center items-center transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            <div class="p-6 space-y-3">
                <div class="p-3 bg-white border border-slate-200 rounded-xl inline-block shadow-sm">
                    <img id="qrModalImage" src="" alt="QR Code" class="w-56 h-56 mx-auto object-contain">
                </div>
                <p class="text-xs text-slate-500 font-medium" id="qrModalDate"></p>
                <p class="text-[11px] text-slate-400">Pindai kode QR melalui akun siswa untuk presensi kehadiran.</p>
            </div>
            <div class="p-3 border-t border-slate-100 bg-slate-50/40 flex items-center justify-center gap-2">
                <a id="qrModalOpenTab" href="" target="_blank"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-200 rounded-lg transition-colors">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    <span>Buka di Tab Baru</span>
                </a>
                <button type="button" onclick="closeQrModal()"
                    class="px-4 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function openQrModal(sesi, url, tanggal) {
            document.getElementById('qrModalTitle').textContent = `QR Code Pertemuan Ke-${sesi}`;
            document.getElementById('qrModalImage').src = url;
            document.getElementById('qrModalOpenTab').href = url;
            document.getElementById('qrModalDate').textContent = `Tanggal: ${tanggal}`;
            document.getElementById('qrModal').classList.remove('hidden');
        }

        function closeQrModal() {
            document.getElementById('qrModal').classList.add('hidden');
        }

        function confirmReset() {
            if (confirm('Apakah Anda yakin ingin mereset seluruh sesi pertemuan ini? Data absensi yang telah terekam akan ikut terhapus.')) {
                document.getElementById('reset-form').submit();
            }
        }

        window.onclick = function(event) {
            const modal = document.getElementById('qrModal');
            if (event.target === modal) {
                closeQrModal();
            }
        };
    </script>
</x-staffakademik-layout>

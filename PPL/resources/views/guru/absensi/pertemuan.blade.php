<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header & Back Button --}}
        <div>
            <a href="{{ route('guru.absensi.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-800 transition-colors mb-2">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Daftar Presensi</span>
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-xl font-bold text-slate-900">
                            Presensi {{ $detail->mataPelajaran->nama_matpel ?? 'Mata Pelajaran' }}
                        </h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-700 border border-brand-200/60">
                            Kelas {{ $detail->kelas->nama_kelas ?? '-' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        Jadwal: {{ $detail->hari->nama_hari ?? '-' }}, {{ date('H:i', strtotime($detail->waktu_mulai)) }} - {{ date('H:i', strtotime($detail->waktu_selesai)) }} WIB • Pendidik: {{ $detail->guru->nama_guru }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Meetings Table Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-slate-900 text-base">Daftar Pertemuan Kelas</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Aktivasi scan QR Code presensi mandiri siswa atau input rekap kehadiran manual</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600">
                    {{ $detail->pertemuan->count() }} Pertemuan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[11px] font-semibold">
                            <th class="py-3.5 px-4 w-16 text-center">Ke-</th>
                            <th class="py-3.5 px-4">Tanggal Pertemuan</th>
                            <th class="py-3.5 px-4 text-center">Status QR Scan</th>
                            <th class="py-3.5 px-4 text-center">QR Code</th>
                            <th class="py-3.5 px-4">Rekap Kehadiran</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
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
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                {{-- Pertemuan Ke- --}}
                                <td class="py-4 px-4 text-center font-bold text-slate-700">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- Tanggal --}}
                                <td class="py-4 px-4 font-semibold text-slate-900">
                                    {{ \Carbon\Carbon::parse($pertemuan->tanggal_pertemuan)->translatedFormat('l, d F Y') }}
                                </td>

                                {{-- Status QR Toggle --}}
                                <td class="py-4 px-4 text-center">
                                    <div class="flex flex-col items-center justify-center gap-1">
                                        <label class="inline-flex relative items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer status-checkbox" data-id="{{ $pertemuan->id_pertemuan }}" {{ $pertemuan->status == 'Aktif' ? 'checked' : '' }}>
                                            <div class="w-10 h-5 bg-slate-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-brand-400 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                                        </label>
                                        <span class="text-[10px] font-semibold status-label {{ $pertemuan->status == 'Aktif' ? 'text-emerald-600' : 'text-slate-400' }}">
                                            {{ $pertemuan->status == 'Aktif' ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- QR Code Preview --}}
                                <td class="py-4 px-4 text-center">
                                    @if ($pertemuan->qr_code)
                                        <button type="button" data-modal-target="qrModal-{{ $loop->iteration }}" data-modal-toggle="qrModal-{{ $loop->iteration }}"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-700 transition-colors text-[11px] font-medium">
                                            <i class="fa-solid fa-qrcode text-brand-700"></i>
                                            <span>Lihat QR</span>
                                        </button>
                                    @else
                                        <span class="text-slate-300 italic">-</span>
                                    @endif
                                </td>

                                {{-- Rekap Kehadiran Pills --}}
                                <td class="py-4 px-4">
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                            H: {{ $hadirCount }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200/60">
                                            I: {{ $izinCount }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
                                            S: {{ $sakitCount }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/60">
                                            A: {{ $alpaCount }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Action Button --}}
                                <td class="py-4 px-4 text-center">
                                    <a href="{{ route('guru.absensi.pertemuan.details', ['id' => $detail->id_kelas_mata_pelajaran, 'pertemuan' => $pertemuan->id_pertemuan]) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-50 text-brand-700 hover:bg-brand-100 font-semibold transition-colors">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        <span>Input Presensi</span>
                                    </a>
                                </td>
                            </tr>

                            {{-- QR Code Modal --}}
                            @if ($pertemuan->qr_code)
                                <div id="qrModal-{{ $loop->iteration }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full bg-slate-900/60 backdrop-blur-sm">
                                    <div class="relative w-full h-full max-w-md md:h-auto mx-auto mt-16">
                                        <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
                                            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                                                <h3 class="text-sm font-bold text-slate-800">QR Code Pertemuan Ke-{{ $loop->iteration }}</h3>
                                                <button type="button" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg" data-modal-hide="qrModal-{{ $loop->iteration }}">
                                                    <i class="fa-solid fa-xmark text-sm"></i>
                                                </button>
                                            </div>
                                            <div class="p-6 text-center space-y-3">
                                                <div class="p-4 bg-white border border-slate-200 rounded-xl inline-block shadow-inner">
                                                    <img src="{{ asset('storage/' . $pertemuan->qr_code) }}"
                                                         alt="QR Code Pertemuan {{ $loop->iteration }}"
                                                         class="w-64 h-64 mx-auto object-contain">
                                                </div>
                                                <p class="text-xs text-slate-500">
                                                    Tampilkan QR code ini di proyektor kelas agar siswa dapat melakukan scan presensi secara mandiri.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-xs">
                                    Belum ada pertemuan yang dijadwalkan untuk kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-guru-layout>

{{-- SweetAlert2 for QR Status Toggle --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.status-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const isChecked = this.checked;
            const status = isChecked ? 'Aktif' : 'Tidak Aktif';
            const pertemuanId = this.dataset.id;
            const container = this.closest('td');
            const label = container ? container.querySelector('.status-label') : null;

            // Optimistic label update
            if (label) {
                label.textContent = isChecked ? 'Aktif' : 'Nonaktif';
                label.className = `text-[10px] font-semibold status-label ${isChecked ? 'text-emerald-600' : 'text-slate-400'}`;
            }

            fetch('{{ route("guru.absensi.update-status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ id: pertemuanId, status: status })
            })
            .then(async response => {
                const data = await response.json().catch(() => null);
                if (!response.ok || !data || !data.success) {
                    throw new Error((data && data.message) ? data.message : 'Gagal mengubah status di server');
                }
                return data;
            })
            .then(data => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: isChecked ? 'QR Code sekarang Aktif' : 'QR Code sekarang Nonaktif',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
            })
            .catch(error => {
                // Revert checkbox & label on failure
                this.checked = !isChecked;
                if (label) {
                    label.textContent = !isChecked ? 'Aktif' : 'Nonaktif';
                    label.className = `text-[10px] font-semibold status-label ${!isChecked ? 'text-emerald-600' : 'text-slate-400'}`;
                }
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Gagal mengubah status QR Code',
                    text: error.message,
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                });
            });
        });
    });
</script>

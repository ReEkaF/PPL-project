<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6 pb-10">

        {{-- Header & Breadcrumbs --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs">
                        <li class="inline-flex items-center">
                            <a href="{{ route('guru.dashboard') }}" class="text-slate-500 hover:text-brand-800 transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-house text-[11px]"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <a href="{{ route('pembina.index') }}" class="text-slate-500 hover:text-brand-800 transition-colors">
                                Ekstrakurikuler
                            </a>
                        </li>
                        <li class="flex items-center text-slate-800 font-semibold">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span>Penilaian Nilai</span>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center gap-3 pt-1">
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Penilaian Ekstrakurikuler {{ $nama_ekstra }}</h1>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                        <i class="fa-solid fa-star text-[10px] text-amber-500"></i>
                        Nilai Rapor
                    </span>
                </div>
                <p class="text-xs text-slate-500">
                    Input dan evaluasi nilai predikat rapor (A, B, C, D, E) untuk seluruh anggota kegiatan ekstrakurikuler.
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('pembina.index') }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Portal</span>
                </a>
            </div>
        </div>

        @if (session()->has('success'))
            <x-alert-notification :color="'green'">
                {{ session('success') }}
            </x-alert-notification>
        @endif

        @php
            $totalAnggota = $laporan_anggota ? (is_countable($laporan_anggota) ? count($laporan_anggota) : $laporan_anggota->count()) : 0;
            $sudahDinilai = $laporan_anggota ? collect($laporan_anggota)->filter(fn($item) => !empty($item->penilaian && $item->penilaian->penilaian))->count() : 0;
            $belumDinilai = max(0, $totalAnggota - $sudahDinilai);
            $memilikiLaporan = $laporan_anggota ? collect($laporan_anggota)->filter(fn($item) => !empty($item->laporan && $item->laporan->isi_laporan))->count() : 0;
            $progressPersen = $totalAnggota > 0 ? round(($sudahDinilai / $totalAnggota) * 100) : 0;
        @endphp

        {{-- Overview & Filter Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex flex-wrap items-center gap-6 text-xs">
                    <div>
                        <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Pembina Ekstra</span>
                        <p class="font-bold text-slate-800 text-sm mt-0.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-user-tie text-brand-700 text-xs"></i>
                            {{ auth()->guard('web-guru')->user()?->nama_guru ?? 'Guru Pembina' }}
                        </p>
                    </div>
                    <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>
                    <div>
                        <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Ekstrakurikuler</span>
                        <p class="font-bold text-brand-900 text-sm mt-0.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-award text-amber-600 text-xs"></i>
                            {{ $nama_ekstra }}
                        </p>
                    </div>
                </div>

                {{-- Filter Tahun Ajaran --}}
                <div class="flex items-center gap-2.5">
                    <label for="tahun_ajaran" class="text-xs font-semibold text-slate-600 whitespace-nowrap flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar-days text-brand-700"></i>
                        <span>Tahun Ajaran:</span>
                    </label>
                    <div class="relative min-w-[240px]">
                        <select id="tahun_ajaran" name="tahun_ajaran"
                            class="w-full bg-slate-50 border border-slate-300 text-slate-800 text-xs font-semibold rounded-xl px-3 py-2 pr-8 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all cursor-pointer">
                            @foreach($tahun_ajaran as $tahun)
                                <option value="{{ $tahun->id_tahun_ajaran }}" {{ $tahun->id_tahun_ajaran == $tahun_ajaran_aktif->id_tahun_ajaran ? 'selected' : '' }}>
                                    {{ $tahun->tahun_mulai }}/{{ $tahun->tahun_selesai }} - Semester {{ $tahun->semester == 1 ? 'Ganjil' : 'Genap' }} {{ $tahun->aktif == 1 ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Total anggota</span>
                    <div class="w-9 h-9 rounded-xl bg-[#06466C]/10 text-[#06466C] flex items-center justify-center text-sm">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-2xl font-bold font-mono text-slate-900" id="stat-total">{{ $totalAnggota }}</p>
                    <p class="text-[11px] text-slate-500 mt-0.5">Siswa terdaftar aktif</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Sudah dinilai</span>
                    <div class="w-9 h-9 rounded-xl bg-[#06466C]/10 text-[#06466C] flex items-center justify-center text-sm">
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="flex items-baseline gap-1.5">
                        <p class="text-2xl font-bold font-mono text-slate-900" id="stat-dinilai">{{ $sudahDinilai }}</p>
                        <span class="text-xs font-mono text-slate-400">/ {{ $totalAnggota }}</span>
                    </div>
                    <p class="text-[11px] text-emerald-600 font-semibold mt-0.5">
                        {{ $progressPersen }}% capaian penilaian
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Belum dinilai</span>
                    <div class="w-9 h-9 rounded-xl bg-[#06466C]/10 text-[#06466C] flex items-center justify-center text-sm">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-2xl font-bold font-mono text-slate-900" id="stat-belum">{{ $belumDinilai }}</p>
                    <p class="text-[11px] text-slate-500 mt-0.5">Menunggu input nilai</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Laporan keaktifan</span>
                    <div class="w-9 h-9 rounded-xl bg-[#06466C]/10 text-[#06466C] flex items-center justify-center text-sm">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="flex items-baseline gap-1.5">
                        <p class="text-2xl font-bold font-mono text-slate-900">{{ $memilikiLaporan }}</p>
                        <span class="text-xs font-mono text-slate-400">/ {{ $totalAnggota }}</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-0.5">Catatan keaktifan terisi</p>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center text-xs font-bold">
                        <i class="fa-solid fa-file-pen"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Daftar Penilaian Anggota</h2>
                        <p class="text-xs text-slate-500">Pilih predikat nilai (A - E) untuk menyimpan secara otomatis tanpa reload.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-600">
                        <i class="fa-solid fa-bolt text-amber-500 text-[11px]"></i>
                        Auto-save Aktif
                    </span>
                </div>
            </div>

            <div class="p-5">
                <table class="w-full text-xs text-left" id="search-table">
                    <thead class="text-[11px] text-slate-500 uppercase bg-slate-50/80 border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-4 py-3 font-semibold text-center w-12">No</th>
                            <th scope="col" class="px-4 py-3 font-semibold">Nama Siswa</th>
                            <th scope="col" class="px-4 py-3 font-semibold">NISN</th>
                            <th scope="col" class="px-4 py-3 font-semibold">Laporan Keaktifan</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center w-48">Predikat Nilai</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Status & Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($laporan_anggota as $index => $item)
                            @php
                                $hasReport = !empty($item->laporan && $item->laporan->id_laporan);
                                $hasNilai = !empty($item->penilaian && $item->penilaian->penilaian);
                                $nilaiVal = $hasNilai ? strtoupper($item->penilaian->penilaian) : '';
                                $tglFormat = ($hasNilai && $item->penilaian->tgl_penilaian)
                                    ? \Carbon\Carbon::parse($item->penilaian->tgl_penilaian)->translatedFormat('d M Y, H:i')
                                    : '-';
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors" id="row-{{ $loop->iteration }}">
                                <td class="px-4 py-3.5 text-center font-bold text-slate-400">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ substr($item->siswa->nama_siswa ?? 'S', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 leading-snug">{{ $item->siswa->nama_siswa ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 font-mono text-slate-600 whitespace-nowrap">
                                    {{ $item->siswa->nisn ?: '-' }}
                                </td>
                                <td class="px-4 py-3.5">
                                    @if ($hasReport && !empty($item->laporan->isi_laporan))
                                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-700 text-xs leading-relaxed max-w-md">
                                            <div class="flex items-start gap-1.5">
                                                <i class="fa-solid fa-quote-left text-brand-600 text-[10px] mt-0.5 shrink-0"></i>
                                                <span>{{ $item->laporan->isi_laporan }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                                            Belum Ada Laporan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <div class="max-w-[170px] mx-auto space-y-1">
                                        <select
                                            name="penilaian-{{ $loop->iteration }}"
                                            class="penilaian-dropdown w-full bg-white border border-slate-300 text-slate-800 text-xs font-semibold rounded-xl px-2.5 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all cursor-pointer {{ !$hasReport ? 'opacity-60 cursor-not-allowed bg-slate-100' : '' }}"
                                            data-id="{{ $item->id_siswa }}"
                                            data-iteration="{{ $loop->iteration }}"
                                            data-laporan="{{ $hasReport ? $item->laporan->id_laporan : '' }}"
                                            {{ $hasReport ? '' : 'disabled' }}>
                                            <option value="" disabled {{ !$hasNilai ? 'selected' : '' }}>-- Pilih Nilai --</option>
                                            <option value="A" {{ $nilaiVal === 'A' ? 'selected' : '' }}>A (Sangat Baik)</option>
                                            <option value="B" {{ $nilaiVal === 'B' ? 'selected' : '' }}>B (Baik)</option>
                                            <option value="C" {{ $nilaiVal === 'C' ? 'selected' : '' }}>C (Cukup)</option>
                                            <option value="D" {{ $nilaiVal === 'D' ? 'selected' : '' }}>D (Kurang)</option>
                                            <option value="E" {{ $nilaiVal === 'E' ? 'selected' : '' }}>E (Sangat Kurang)</option>
                                        </select>
                                        <div id="status-badge-{{ $loop->iteration }}" class="text-[10px] font-medium hidden"></div>
                                        @if(!$hasReport)
                                            <span class="text-[10px] text-slate-400 block">Laporan belum tersedia</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-center whitespace-nowrap">
                                    <div class="flex flex-col items-center gap-1">
                                        <div id="status-pill-{{ $loop->iteration }}">
                                            @if ($hasNilai)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <i class="fa-solid fa-circle-check text-[8px]"></i>
                                                    Dinilai
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                                    <i class="fa-solid fa-circle-pause text-[8px]"></i>
                                                    Belum Dinilai
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-[11px] text-slate-500 font-mono" id="tgl-penilaian-{{ $loop->iteration }}">
                                            {{ $tglFormat }}
                                        </span>
                                    </div>
                                    <input type="hidden" value="{{ $hasReport ? $item->laporan->id_laporan : '' }}" id="id_laporan-{{ $loop->iteration }}">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-slate-400 text-xs">
                                    <i class="fa-solid fa-file-circle-xmark text-3xl mb-2 text-slate-300 block"></i>
                                    <p class="font-semibold text-slate-700 text-sm">Tidak ada data anggota</p>
                                    <p class="text-slate-400 mt-0.5">Belum ada data anggota atau laporan keaktifan untuk tahun ajaran yang dipilih.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Toast Notification Container --}}
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <script>
        function showToast(message, type = 'success') {
            var container = document.getElementById('toast-container');
            if (!container) return;

            var toast = document.createElement('div');
            toast.className = 'pointer-events-auto flex items-center gap-2.5 px-4 py-3 rounded-xl shadow-lg border text-xs font-semibold transform transition-all duration-300 translate-y-2 opacity-0 ' +
                (type === 'success' ? 'bg-slate-900 text-white border-slate-800' : 'bg-rose-600 text-white border-rose-700');

            var icon = type === 'success'
                ? '<i class="fa-solid fa-circle-check text-emerald-400"></i>'
                : '<i class="fa-solid fa-circle-xmark text-white"></i>';
            toast.innerHTML = icon + '<span>' + message + '</span>';

            container.appendChild(toast);

            requestAnimationFrame(function() {
                toast.classList.remove('translate-y-2', 'opacity-0');
            });

            setTimeout(function() {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(function() {
                    toast.remove();
                }, 300);
            }, 2500);
        }

        $(document).ready(function() {
            // Filter Tahun Ajaran
            $('#tahun_ajaran').on('change', function() {
                var selectedTahunAjaran = $(this).val();
                window.location.href = '{{ url('/guru/pembina/penilaian') }}/' + selectedTahunAjaran;
            });

            // AJAX Auto-Save Penilaian
            $(document).on('change', '.penilaian-dropdown', function() {
                var $select = $(this);
                var id_siswa = $select.data('id');
                var id_laporan = $select.data('laporan');
                var iteration = $select.data('iteration');
                var value = $select.val();

                var $badge = $('#status-badge-' + iteration);
                var $tgl = $('#tgl-penilaian-' + iteration);
                var $pill = $('#status-pill-' + iteration);

                $badge.removeClass('hidden').html('<span class="inline-flex items-center gap-1 text-brand-700"><i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...</span>');

                $.ajax({
                    url: '{{ url('/guru/pembina/penilaian') }}/' + id_siswa,
                    type: 'POST',
                    data: {
                        penilaian: value,
                        id_siswa: id_siswa,
                        id_laporan: id_laporan,
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            $badge.html('<span class="inline-flex items-center gap-1 text-emerald-600 font-semibold"><i class="fa-solid fa-check"></i> Tersimpan</span>');
                            if (res.tgl_penilaian) {
                                $tgl.text(res.tgl_penilaian);
                            }
                            $pill.html('<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200"><i class="fa-solid fa-circle-check text-[8px]"></i> Dinilai</span>');
                            showToast('Nilai berhasil disimpan', 'success');

                            setTimeout(function() {
                                $badge.addClass('hidden');
                            }, 2000);
                        } else {
                            $badge.html('<span class="inline-flex items-center gap-1 text-rose-600"><i class="fa-solid fa-xmark"></i> Gagal</span>');
                            showToast('Gagal menyimpan nilai', 'error');
                        }
                    },
                    error: function(err) {
                        $badge.html('<span class="inline-flex items-center gap-1 text-rose-600"><i class="fa-solid fa-xmark"></i> Error</span>');
                        showToast('Terjadi kesalahan jaringan', 'error');
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById("search-table") && typeof simpleDatatables !== 'undefined' && typeof simpleDatatables.DataTable !== 'undefined') {
                new simpleDatatables.DataTable("#search-table", {
                    searchable: true,
                    paging: false,
                    sortable: true
                });
            }
        });
    </script>
</x-app-guru-layout>

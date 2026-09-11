<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
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
                            <span class="text-slate-800 font-medium">Laporan Hasil Belajar (Rapor)</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Rapor Siswa & Evaluasi Nilai</h1>
                <p class="text-xs text-slate-500">
                    Kompilasi nilai rata-rata mata pelajaran, ekstrakurikuler, dan pencetakan lembar rapor resmi siswa.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" id="btnSyncNilai" onclick="handleSyncNilai()"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white transition-colors shadow-sm disabled:opacity-60 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-arrows-rotate text-[11px]" id="syncIcon"></i>
                    <span id="syncText">Hitung & Sinkronkan Nilai</span>
                </button>
            </div>
        </div>

        {{-- Container Notifikasi Sinkronisasi --}}
        <div id="syncNotification" class="hidden"></div>

        {{-- Main Two-Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            {{-- Kolom Kiri: Tabel Daftar Siswa --}}
            <div class="lg:col-span-6 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/40">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">Daftar Siswa & Rata-rata Nilai</h2>
                    
                    {{-- Form Pencarian & Filter Kelas --}}
                    <form method="GET" action="{{ route('staff_akademik.rapor.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                        <div class="sm:col-span-6">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama siswa..."
                                class="w-full px-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                        </div>
                        <div class="sm:col-span-4">
                            <select name="kelas"
                                class="w-full px-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                                <option value="">Semua Kelas</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id_kelas }}" {{ request('kelas') == $kelas->id_kelas ? 'selected' : '' }}>
                                        Kelas {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <button type="submit"
                                class="w-full px-3 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition-colors shadow-sm">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-700 font-semibold uppercase text-[11px] tracking-wider">
                            <tr>
                                <th class="px-4 py-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_siswa', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                       class="inline-flex items-center gap-1 hover:text-brand-800 transition-colors">
                                        <span>Nama Siswa</span>
                                        @if(request('sort') === 'nama_siswa')
                                            <i class="fa-solid fa-sort-{{ request('order') === 'asc' ? 'up' : 'down' }} text-[10px]"></i>
                                        @else
                                            <i class="fa-solid fa-sort text-[10px] text-slate-300"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-4 py-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_kelas', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                       class="inline-flex items-center gap-1 hover:text-brand-800 transition-colors">
                                        <span>Kelas</span>
                                        @if(request('sort') === 'nama_kelas')
                                            <i class="fa-solid fa-sort-{{ request('order') === 'asc' ? 'up' : 'down' }} text-[10px]"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-4 py-3 text-center">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nilai_rata_rata', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                       class="inline-flex items-center gap-1 hover:text-brand-800 transition-colors">
                                        <span>Rata-rata</span>
                                        @if(request('sort') === 'nilai_rata_rata')
                                            <i class="fa-solid fa-sort-{{ request('order') === 'asc' ? 'up' : 'down' }} text-[10px]"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($siswaList as $siswa)
                                <tr class="hover:bg-slate-50/60 transition-colors" id="row-siswa-{{ $siswa->id_siswa }}">
                                    <td class="px-4 py-3 font-semibold text-slate-800">
                                        <div class="inline-flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px] flex items-center justify-center">
                                                {{ substr($siswa->nama_siswa, 0, 1) }}
                                            </div>
                                            <span>{{ $siswa->nama_siswa }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 font-mono">
                                        {{ $siswa->nama_kelas }}
                                    </td>
                                    <td class="px-4 py-3 text-center font-mono font-bold text-slate-900">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold {{ $siswa->nilai_rata_rata >= 75 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                            {{ number_format($siswa->nilai_rata_rata, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <button type="button" onclick="showDetail('{{ $siswa->id_siswa }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-100 rounded-lg transition-colors">
                                            <span>Lihat Rapor</span>
                                            <i class="fa-solid fa-chevron-right text-[9px]"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-12 text-center text-slate-400">
                                        <i class="fa-regular fa-folder-open text-3xl mb-2 text-slate-300 block"></i>
                                        <span>Tidak ada data siswa yang ditemukan.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($siswaList->hasPages())
                    <div class="px-4 py-3 border-t border-slate-100 bg-slate-50/40">
                        {{ $siswaList->links() }}
                    </div>
                @endif
            </div>

            {{-- Kolom Kanan: Preview Dokumen Rapor --}}
            <div class="lg:col-span-6 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden sticky top-20">
                <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice text-brand-800 text-sm"></i>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Preview Dokumen Rapor</h3>
                    </div>
                    <span class="text-[11px] text-slate-400">SMPN 2 Kamal</span>
                </div>

                <div id="detailContainer" class="p-5 sm:p-6 min-h-[420px]">
                    <div id="detailContent">
                        <div class="py-16 text-center text-slate-400">
                            <i class="fa-solid fa-file-circle-check text-4xl text-slate-200 mb-3 block"></i>
                            <h4 class="text-xs font-bold text-slate-700">Belum Ada Siswa Dipilih</h4>
                            <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto">
                                Klik tombol <strong>Lihat Rapor</strong> pada tabel siswa di samping untuk menampilkan lembar nilai lengkap.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script AJAX Detail Rapor & Sinkronisasi Nilai --}}
    <script>
        let currentSelectedStudentId = null;

        function handleSyncNilai() {
            const btn = document.getElementById('btnSyncNilai');
            const icon = document.getElementById('syncIcon');
            const text = document.getElementById('syncText');
            const notification = document.getElementById('syncNotification');

            btn.disabled = true;
            icon.classList.add('fa-spin');
            text.textContent = 'Menghitung & Menyinkronkan...';

            fetch("{{ route('staff_akademik.rapor.update_nilai') }}", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan saat menyinkronkan nilai rapor');
                }
                return response.json();
            })
            .then(data => {
                notification.innerHTML = `
                    <div class="flex items-center justify-between p-4 text-xs font-medium text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-sm text-emerald-600"></i>
                            <span>${data.message || 'Nilai rapor berhasil dihitung dan disinkronkan untuk seluruh siswa!'}</span>
                        </div>
                        <button type="button" onclick="document.getElementById('syncNotification').classList.add('hidden')" class="text-emerald-500 hover:text-emerald-700">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>
                `;
                notification.classList.remove('hidden');

                if (currentSelectedStudentId) {
                    showDetail(currentSelectedStudentId);
                }
            })
            .catch(error => {
                console.error('Error saat sinkronisasi:', error);
                notification.innerHTML = `
                    <div class="flex items-center justify-between p-4 text-xs font-medium text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-sm">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-triangle-exclamation text-sm text-rose-600"></i>
                            <span>${error.message || 'Gagal menyinkronkan nilai rapor. Silakan coba kembali.'}</span>
                        </div>
                        <button type="button" onclick="document.getElementById('syncNotification').classList.add('hidden')" class="text-rose-500 hover:text-rose-700">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>
                `;
                notification.classList.remove('hidden');
            })
            .finally(() => {
                btn.disabled = false;
                icon.classList.remove('fa-spin');
                text.textContent = 'Hitung & Sinkronkan Nilai';
            });
        }

        function showDetail(id_siswa) {
            currentSelectedStudentId = id_siswa;
            const detailContent = document.getElementById('detailContent');
            let downloadUrl = "{{ route('staff_akademik.rapor.download', ':id_siswa') }}";
            downloadUrl = downloadUrl.replace(':id_siswa', id_siswa);

            detailContent.innerHTML = `
                <div class="py-16 text-center text-slate-500 space-y-3">
                    <i class="fa-solid fa-circle-notch fa-spin text-2xl text-brand-800"></i>
                    <p class="text-xs">Mengambil lembar data rapor siswa...</p>
                </div>
            `;

            fetch(`/staff_akademik/rapor/siswa/${id_siswa}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal memuat detail data rapor');
                    }
                    return response.json();
                })
                .then(data => {
                    detailContent.innerHTML = `
                        <div class="space-y-5">
                            {{-- Header Transkrip --}}
                            <div class="text-center pb-4 border-b border-slate-100 space-y-1">
                                <h4 class="text-sm font-bold text-slate-900 tracking-tight">RAPOR HASIL BELAJAR PESERTA DIDIK</h4>
                                <p class="text-xs text-slate-500">SMP Negeri 2 Kamal · Tahun Ajaran ${data.tahun_ajaran || '-'} (Semester ${data.semester || '-'})</p>
                            </div>

                            {{-- Biodata Singkat Siswa --}}
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 text-xs">
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    <div>
                                        <dt class="text-[11px] text-slate-400">Nama Siswa</dt>
                                        <dd class="font-bold text-slate-800 mt-0.5">${data.nama_siswa}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-[11px] text-slate-400">Nomor Induk Siswa Nasional (NISN)</dt>
                                        <dd class="font-mono font-semibold text-slate-800 mt-0.5">${data.nisn || '-'}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-[11px] text-slate-400">Rombongan Belajar</dt>
                                        <dd class="font-semibold text-slate-800 mt-0.5">Kelas ${data.nama_kelas}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-[11px] text-slate-400">Satuan Pendidikan</dt>
                                        <dd class="font-medium text-slate-700 mt-0.5">SMP Negeri 2 Kamal</dd>
                                    </div>
                                </dl>
                            </div>

                            {{-- Tabel Nilai Mata Pelajaran --}}
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <h5 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Capaian Nilai Akademik</h5>
                                    <span class="text-[11px] text-slate-500">${data.nilai_matpel ? data.nilai_matpel.length : 0} Mata Pelajaran</span>
                                </div>
                                <div class="border border-slate-200 rounded-xl overflow-hidden">
                                    <table class="w-full text-left text-xs text-slate-600">
                                        <thead class="bg-slate-50 text-slate-700 text-[11px] uppercase font-semibold border-b border-slate-200">
                                            <tr>
                                                <th class="px-3 py-2">Mata Pelajaran</th>
                                                <th class="px-3 py-2 text-center w-16">Nilai</th>
                                                <th class="px-3 py-2 text-center w-16">Predikat</th>
                                                <th class="px-3 py-2">Deskripsi Capaian</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            ${(data.nilai_matpel || []).map(matpel => `
                                                <tr class="hover:bg-slate-50/60">
                                                    <td class="px-3 py-2 font-medium text-slate-800">${matpel.nama_matpel}</td>
                                                    <td class="px-3 py-2 text-center font-mono font-bold text-slate-900">${matpel.nilai_rata_rata_matpel}</td>
                                                    <td class="px-3 py-2 text-center font-mono">
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">
                                                            ${matpel.predikat || '-'}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-2 text-[11px] text-slate-500">${matpel.pesan || '-'}</td>
                                                </tr>
                                            `).join('') || `
                                                <tr>
                                                    <td colspan="4" class="px-3 py-4 text-center text-slate-400">Belum ada nilai akademik yang tercatat.</td>
                                                </tr>
                                            `}
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Tabel Nilai Ekstrakurikuler --}}
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <h5 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Capaian Ekstrakurikuler</h5>
                                    <span class="text-[11px] text-slate-500">${data.nilai_ekstra ? data.nilai_ekstra.length : 0} Kegiatan</span>
                                </div>
                                <div class="border border-slate-200 rounded-xl overflow-hidden">
                                    <table class="w-full text-left text-xs text-slate-600">
                                        <thead class="bg-slate-50 text-slate-700 text-[11px] uppercase font-semibold border-b border-slate-200">
                                            <tr>
                                                <th class="px-3 py-2">Ekstrakurikuler</th>
                                                <th class="px-3 py-2 text-center w-16">Nilai</th>
                                                <th class="px-3 py-2 text-center w-16">Predikat</th>
                                                <th class="px-3 py-2">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            ${(data.nilai_ekstra || []).map(ekstra => `
                                                <tr class="hover:bg-slate-50/60">
                                                    <td class="px-3 py-2 font-medium text-slate-800">${ekstra.nama_ekstrakurikuler}</td>
                                                    <td class="px-3 py-2 text-center font-mono font-bold text-slate-900">${ekstra.nilai_rata_rata_ekstra}</td>
                                                    <td class="px-3 py-2 text-center font-mono">
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">
                                                            ${ekstra.predikat || '-'}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-2 text-[11px] text-slate-500">${ekstra.pesan || '-'}</td>
                                                </tr>
                                            `).join('') || `
                                                <tr>
                                                    <td colspan="4" class="px-3 py-4 text-center text-slate-400">Tidak ada kegiatan ekstrakurikuler yang diikuti.</td>
                                                </tr>
                                            `}
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Tombol Download Rapor --}}
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
                                <a href="${downloadUrl}"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-xs font-medium text-white bg-brand-800 hover:bg-brand-900 rounded-lg shadow-sm transition-colors">
                                    <i class="fa-solid fa-file-pdf text-[11px]"></i>
                                    <span>Unduh Lembar Rapor (PDF)</span>
                                </a>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error fetching details:', error);
                    detailContent.innerHTML = `
                        <div class="py-12 text-center text-rose-500 space-y-2">
                            <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                            <p class="text-xs font-medium">Gagal memuat rincian nilai rapor siswa. Silakan coba kembali.</p>
                        </div>
                    `;
                });
        }
    </script>
</x-staffakademik-layout>

<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
        {{-- Flash Messages --}}
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
                    <i class="fa-solid fa-circle-xmark text-sm text-rose-600"></i>
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
                            <a href="{{ route('daftarkelas') }}" class="text-slate-500 hover:text-brand-800 transition-colors">Manajemen Rombel</a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Kelas {{ $kelas->nama_kelas }}</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Daftar Siswa Kelas {{ $kelas->nama_kelas }}</h1>
                <p class="text-xs text-slate-500">
                    Kelola data keanggotaan peserta didik dan penugasan wali kelas untuk rombel ini.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('daftarkelas') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Rombel</span>
                </a>
            </div>
        </div>

        {{-- Summary Cards (Wali Kelas & Kuota Siswa) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Card Wali Kelas --}}
            <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 border border-brand-100 text-brand-800 flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Wali Kelas</div>
                        <div class="text-sm font-bold text-slate-900 mt-0.5">
                            @if ($kelas->waliKelas && $kelas->waliKelas->guru)
                                {{ $kelas->waliKelas->guru->nama_guru }}
                            @else
                                <span class="text-amber-600 font-medium">Belum Ditentukan</span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">
                            NIP: {{ ($kelas->waliKelas && $kelas->waliKelas->guru && $kelas->waliKelas->guru->nip) ? $kelas->waliKelas->guru->nip : '-' }}
                        </div>
                    </div>
                </div>
                <div>
                    <a href="{{ route('kelas.editWaliKelas', $kelas->id_kelas) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition-colors">
                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                        <span>Ubah Wali</span>
                    </a>
                </div>
            </div>

            {{-- Card Total Siswa --}}
            <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Siswa Terdaftar</div>
                        <div class="text-sm font-bold text-slate-900 mt-0.5 font-mono">
                            {{ $kelas->siswa->count() }} <span class="text-xs font-normal text-slate-500 font-sans">Peserta Didik</span>
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5">
                            Tahun Ajaran Aktif
                        </div>
                    </div>
                </div>
                <div>
                    <a href="{{ route('kelas.tambahSiswa', $kelas->id_kelas) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white transition-colors shadow-sm">
                        <i class="fa-solid fa-user-plus text-[10px]"></i>
                        <span>Tambah Siswa</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            {{-- Toolbar: Filter and Actions --}}
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="relative w-full sm:w-72">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" id="filterInput" onkeyup="filterTabelSiswa()"
                        placeholder="Cari nama siswa atau NISN..."
                        class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-lg bg-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                </div>

                <div class="flex items-center gap-2">
                    {{-- Bulk Delete Button --}}
                    <button id="hapusMassalButton" type="button" onclick="submitHapusMassal()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition-colors shadow-sm"
                        style="display: none;">
                        <i class="fa-solid fa-trash text-[10px]"></i>
                        <span>Keluarkan (<span id="checkedCount">0</span>) Siswa</span>
                    </button>

                    <a href="{{ route('kelas.tambahSiswa', $kelas->id_kelas) }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-medium text-white bg-brand-800 hover:bg-brand-900 rounded-lg transition-colors shadow-sm">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                        <span>Tambah Siswa</span>
                    </a>
                </div>
            </div>

            {{-- Form Penghapusan Massal --}}
            <form id="hapusSiswaForm" action="{{ route('kelas.hapusSiswaMassal', $kelas->id_kelas) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600" id="tableSiswa">
                        <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-700 font-semibold uppercase text-[11px] tracking-wider">
                            <tr>
                                <th class="px-5 py-3 w-10 text-center">
                                    <input type="checkbox" id="checkAll" class="rounded border-slate-300 text-brand-800 focus:ring-brand-500">
                                </th>
                                <th class="px-5 py-3 w-12 text-center">No</th>
                                <th class="px-5 py-3">Nama Siswa</th>
                                <th class="px-5 py-3 w-40">NISN</th>
                                <th class="px-5 py-3 w-32">Jenis Kelamin</th>
                                <th class="px-5 py-3 w-32 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($kelas->siswa as $index => $siswaItem)
                                <tr class="hover:bg-slate-50/60 transition-colors siswa-row">
                                    <td class="px-5 py-3.5 text-center">
                                        <input type="checkbox" name="siswa_ids[]" value="{{ $siswaItem->id_siswa }}"
                                            class="rounded border-slate-300 text-brand-800 focus:ring-brand-500 siswa-checkbox">
                                    </td>
                                    <td class="px-5 py-3.5 text-center font-mono text-slate-500">{{ $index + 1 }}</td>
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-[11px] uppercase">
                                                {{ substr($siswaItem->nama_siswa ?? 'S', 0, 1) }}
                                            </div>
                                            <span class="font-semibold text-slate-900 student-name">{{ $siswaItem->nama_siswa }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 font-mono text-slate-600 student-nisn">
                                        {{ $siswaItem->nisn ?? '-' }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if($siswaItem->jenis_kelamin == 'L' || strtolower($siswaItem->jenis_kelamin ?? '') == 'laki-laki')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                                Laki-laki
                                            </span>
                                        @elseif($siswaItem->jenis_kelamin == 'P' || strtolower($siswaItem->jenis_kelamin ?? '') == 'perempuan')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                                                Perempuan
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                        <button type="button"
                                            onclick="centangDanHapus('{{ $kelas->id_kelas }}', '{{ $siswaItem->id_siswa }}', '{{ addslashes($siswaItem->nama_siswa) }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-rose-700 bg-rose-50 border border-rose-100 rounded-lg hover:bg-rose-100 transition-colors"
                                            title="Keluarkan siswa dari kelas ini">
                                            <i class="fa-solid fa-user-minus text-[10px]"></i>
                                            <span>Keluarkan</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-12 text-center text-slate-500">
                                        <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2 block"></i>
                                        <p class="text-xs font-medium text-slate-700">Belum ada siswa terdaftar di kelas ini</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Klik tombol "Tambah Siswa" untuk memasukkan siswa ke rombel.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

    <script>
        const hapusMassalButton = document.getElementById('hapusMassalButton');
        const checkedCountSpan = document.getElementById('checkedCount');
        const checkboxes = document.querySelectorAll('.siswa-checkbox');
        const checkAll = document.getElementById('checkAll');

        function toggleHapusMassalButton() {
            const checkedBoxes = document.querySelectorAll('.siswa-checkbox:checked');
            const count = checkedBoxes.length;
            if (count > 0) {
                hapusMassalButton.style.display = 'inline-flex';
                checkedCountSpan.innerText = count;
            } else {
                hapusMassalButton.style.display = 'none';
                checkedCountSpan.innerText = 0;
            }
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', toggleHapusMassalButton);
        });

        if (checkAll) {
            checkAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    const row = checkbox.closest('.siswa-row');
                    if (row && row.style.display !== 'none') {
                        checkbox.checked = this.checked;
                    }
                });
                toggleHapusMassalButton();
            });
        }

        function filterTabelSiswa() {
            const query = document.getElementById('filterInput').value.toLowerCase();
            const rows = document.querySelectorAll('#tableSiswa .siswa-row');
            rows.forEach(row => {
                const name = row.querySelector('.student-name')?.textContent.toLowerCase() || '';
                const nisn = row.querySelector('.student-nisn')?.textContent.toLowerCase() || '';
                if (name.includes(query) || nisn.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                    const cb = row.querySelector('.siswa-checkbox');
                    if (cb) cb.checked = false;
                }
            });
            toggleHapusMassalButton();
        }

        function submitHapusMassal() {
            const checkedBoxes = document.querySelectorAll('.siswa-checkbox:checked');
            if (checkedBoxes.length === 0) return;

            if (confirm(`Apakah Anda yakin ingin mengeluarkan ${checkedBoxes.length} siswa yang dipilih dari kelas ini?`)) {
                document.getElementById('hapusSiswaForm').submit();
            }
        }

        function centangDanHapus(idKelas, idSiswa, namaSiswa) {
            if (!confirm(`Apakah Anda yakin ingin mengeluarkan siswa "${namaSiswa}" dari kelas ini?`)) {
                return;
            }

            const form = document.getElementById('hapusSiswaForm');
            // Uncheck other checkboxes to only delete this one
            checkboxes.forEach(cb => cb.checked = false);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'siswa_ids[]';
            input.value = idSiswa;
            form.appendChild(input);

            form.submit();
        }
    </script>
</x-staffakademik-layout>

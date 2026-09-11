<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
        {{-- Flash Messages --}}
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
                            <a href="{{ route('kelas.siswa', $kelas->id_kelas) }}" class="text-slate-500 hover:text-brand-800 transition-colors">Kelas {{ $kelas->nama_kelas }}</a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Tambah Siswa</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tambah Siswa ke Kelas {{ $kelas->nama_kelas }}</h1>
                <p class="text-xs text-slate-500">
                    Pilih siswa yang belum memiliki rombongan belajar untuk didaftarkan ke kelas ini.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('kelas.siswa', $kelas->id_kelas) }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Daftar Siswa</span>
                </a>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="max-w-3xl bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <form action="{{ route('kelas.simpanSiswa', $kelas->id_kelas) }}" method="POST" id="formTambahSiswa">
                @csrf

                <div class="p-5 border-b border-slate-100 bg-slate-50/40 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Daftar Siswa Tersedia</h2>
                        <p class="text-[11px] text-slate-500 mt-0.5">Menampilkan siswa aktif yang belum terdaftar di kelas manapun.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-brand-50 border border-brand-100 text-brand-800">
                            <span id="selectedCounter">0</span>&nbsp;siswa dipilih
                        </span>
                    </div>
                </div>

                {{-- Toolbar Filter --}}
                <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white">
                    <div class="relative w-full sm:w-80">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" id="searchInput" oninput="filterSiswa()"
                            placeholder="Cari berdasarkan nama atau NISN..."
                            class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-lg bg-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                    </div>

                    @if($siswa->count() > 0)
                        <label class="inline-flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer select-none">
                            <input type="checkbox" id="checkAllVisible" onchange="toggleSelectAllVisible(this)"
                                class="rounded border-slate-300 text-brand-800 focus:ring-brand-500">
                            <span>Pilih Semua yang Tampil</span>
                        </label>
                    @endif
                </div>

                {{-- List Container --}}
                <div id="siswaList" class="max-h-96 overflow-y-auto divide-y divide-slate-100">
                    @forelse($siswa as $siswaItem)
                        <label class="flex items-center justify-between p-3.5 hover:bg-slate-50/80 transition-colors cursor-pointer siswa-item" id="item-{{ $siswaItem->id_siswa }}">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="siswa_ids[]" value="{{ $siswaItem->id_siswa }}"
                                    class="rounded border-slate-300 text-brand-800 focus:ring-brand-500 siswa-cb"
                                    onchange="onCheckboxChange(this)">
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs uppercase">
                                    {{ substr($siswaItem->nama_siswa ?? 'S', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-xs font-semibold text-slate-900 student-name">{{ $siswaItem->nama_siswa }}</div>
                                    <div class="text-[11px] text-slate-500 font-mono student-nisn">NISN: {{ $siswaItem->nisn ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($siswaItem->jenis_kelamin == 'L' || strtolower($siswaItem->jenis_kelamin ?? '') == 'laki-laki')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                        Laki-laki
                                    </span>
                                @elseif($siswaItem->jenis_kelamin == 'P' || strtolower($siswaItem->jenis_kelamin ?? '') == 'perempuan')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                                        Perempuan
                                    </span>
                                @endif
                            </div>
                        </label>
                    @empty
                        <div class="p-12 text-center text-slate-500">
                            <i class="fa-regular fa-circle-check text-3xl text-emerald-500 mb-2 block"></i>
                            <h4 class="text-xs font-bold text-slate-800">Semua Siswa Telah Terdaftar</h4>
                            <p class="text-[11px] text-slate-500 mt-1 max-w-sm mx-auto">
                                Tidak ada siswa baru tanpa kelas yang siap ditambahkan. Seluruh siswa telah memiliki rombongan belajar aktif.
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- Action Footer --}}
                <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/40 flex items-center gap-2.5">
                    <button type="submit" id="btnSubmit"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white shadow-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fa-solid fa-user-plus text-[11px]"></i>
                        <span>Tambahkan Siswa Terpilih</span>
                    </button>
                    <a href="{{ route('kelas.siswa', $kelas->id_kelas) }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors">
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function filterSiswa() {
            const query = document.getElementById("searchInput").value.toLowerCase();
            const items = document.querySelectorAll("#siswaList .siswa-item");
            items.forEach(item => {
                const name = item.querySelector(".student-name")?.textContent.toLowerCase() || '';
                const nisn = item.querySelector(".student-nisn")?.textContent.toLowerCase() || '';
                if (name.includes(query) || nisn.includes(query)) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
        }

        function updateCounter() {
            const checked = document.querySelectorAll('.siswa-cb:checked').length;
            document.getElementById('selectedCounter').innerText = checked;
        }

        function onCheckboxChange(checkbox) {
            updateCounter();
            const siswaList = document.getElementById("siswaList");
            const item = checkbox.closest(".siswa-item");

            if (checkbox.checked) {
                siswaList.prepend(item);
            } else {
                siswaList.append(item);
            }
        }

        function toggleSelectAllVisible(mainCheckbox) {
            const items = document.querySelectorAll("#siswaList .siswa-item");
            items.forEach(item => {
                if (item.style.display !== "none") {
                    const cb = item.querySelector(".siswa-cb");
                    if (cb) cb.checked = mainCheckbox.checked;
                }
            });
            updateCounter();
        }

        document.getElementById('formTambahSiswa').addEventListener('submit', function(e) {
            const checked = document.querySelectorAll('.siswa-cb:checked').length;
            if (checked === 0) {
                e.preventDefault();
                alert('Silakan pilih minimal 1 siswa untuk ditambahkan ke kelas.');
            }
        });
    </script>
</x-staffakademik-layout>

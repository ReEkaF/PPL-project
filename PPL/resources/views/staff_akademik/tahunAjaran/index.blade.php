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
        @if(session('update'))
            <div class="flex items-center justify-between p-4 text-xs font-medium text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-sm text-emerald-600"></i>
                    <span>{{ session('update') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif
        @if(session('info'))
            <div class="flex items-center justify-between p-4 text-xs font-medium text-blue-800 bg-blue-50 border border-blue-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-info text-sm text-blue-600"></i>
                    <span>{{ session('info') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif
        @if(session('danger'))
            <div class="flex items-center justify-between p-4 text-xs font-medium text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-sm text-rose-600"></i>
                    <span>{{ session('danger') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif
        @if($errors->any())
            <div class="p-4 text-xs font-medium text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-sm space-y-1">
                <div class="flex items-center gap-2 font-semibold">
                    <i class="fa-solid fa-circle-exclamation text-sm text-rose-600"></i>
                    <span>Terjadi kesalahan validasi data:</span>
                </div>
                <ul class="list-disc list-inside pl-4 text-rose-700 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                            <span class="text-slate-500">Master Data</span>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Tahun Ajaran</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Master Tahun Ajaran</h1>
                <p class="text-xs text-slate-500">
                    Kelola kalender akademik, tentukan semester aktif, dan pantau relasi data pembelajaran.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="openCreateModal()"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white transition-colors shadow-sm">
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    <span>Tambah Tahun Ajaran</span>
                </button>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- Card 1: Periode Aktif --}}
            <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm flex items-start justify-between">
                <div class="space-y-1">
                    <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Tahun Ajaran Aktif</p>
                    <h3 class="text-lg font-bold text-slate-900">
                        @if($activeTahunAjaran)
                            {{ $activeTahunAjaran->tahun_mulai }}/{{ $activeTahunAjaran->tahun_selesai }}
                        @else
                            <span class="text-slate-400 italic">Belum Ditentukan</span>
                        @endif
                    </h3>
                    <div class="flex items-center gap-2 pt-0.5">
                        @if($activeTahunAjaran)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Semester {{ $activeTahunAjaran->semester == 1 ? '1 (Ganjil)' : '2 (Genap)' }}
                            </span>
                            <span class="text-[11px] text-slate-500">Periode berjalan</span>
                        @else
                            <span class="text-[11px] text-rose-500 font-medium">Harap aktifkan salah satu</span>
                        @endif
                    </div>
                </div>
                <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                    <i class="fa-regular fa-calendar-check text-base"></i>
                </div>
            </div>

            {{-- Card 2: Total Periode --}}
            <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm flex items-start justify-between">
                <div class="space-y-1">
                    <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Total Periode Terdaftar</p>
                    <h3 class="text-lg font-bold text-slate-900">{{ $totalTahunAjaran }} <span class="text-xs font-normal text-slate-500">Semester</span></h3>
                    <p class="text-[11px] text-slate-500">Riwayat dan arsip akademik sekolah</p>
                </div>
                <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                    <i class="fa-solid fa-clock-rotate-left text-base"></i>
                </div>
            </div>

            {{-- Card 3: Status Cakupan Sistem --}}
            <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm flex items-start justify-between">
                <div class="space-y-1">
                    <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Sinkronisasi Aplikasi</p>
                    <h3 class="text-lg font-bold text-emerald-700">Terkoneksi</h3>
                    <p class="text-[11px] text-slate-500">Jadwal, siswa, & rapor otomatis sinkron</p>
                </div>
                <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                    <i class="fa-solid fa-arrows-spin text-base"></i>
                </div>
            </div>
        </div>

        {{-- Card Container --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            {{-- Toolbar Filter & Pencarian --}}
            <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-slate-50/40">
                <div>
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Daftar Periode Akademik</h2>
                    <p class="text-[11px] text-slate-500 mt-0.5">Daftar tahun pelajaran dan semester yang terkonfigurasi di sistem.</p>
                </div>
                <form action="{{ route('staff_akademik.tahun-ajaran.index') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative w-full sm:w-64">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" name="search" id="search" value="{{ request()->get('search') }}"
                            placeholder="Cari tahun atau semester..."
                            class="w-full pl-9 pr-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                    </div>
                    <button type="submit"
                        class="px-3 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition-colors shadow-sm">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('staff_akademik.tahun-ajaran.index') }}"
                            class="px-2.5 py-1.5 text-xs text-slate-500 hover:text-slate-700 transition-colors" title="Reset filter">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-700 font-semibold uppercase text-[11px] tracking-wider">
                        <tr>
                            <th class="px-5 py-3 w-14 text-center">No</th>
                            <th class="px-5 py-3">Tahun Pelajaran</th>
                            <th class="px-5 py-3">Semester</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Data Terkait</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($tahunAjarans as $index => $ta)
                            <tr class="hover:bg-slate-50/60 transition-colors {{ $ta->aktif ? 'bg-brand-50/20' : '' }}">
                                <td class="px-5 py-3.5 text-center font-mono text-slate-400">
                                    {{ $index + 1 + ($tahunAjarans->currentPage() - 1) * $tahunAjarans->perPage() }}
                                </td>
                                <td class="px-5 py-3.5 font-bold text-slate-900">
                                    <div class="inline-flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg {{ $ta->aktif ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center font-bold text-xs">
                                            <i class="fa-regular fa-calendar text-[11px]"></i>
                                        </div>
                                        <span>{{ $ta->tahun_mulai }} / {{ $ta->tahun_selesai }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 font-medium text-slate-800">
                                    @if($ta->semester == 1)
                                        <span class="inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            <span>Semester 1 (Ganjil)</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            <span>Semester 2 (Genap)</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($ta->aktif)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <i class="fa-solid fa-check text-[10px]"></i>
                                            <span>Aktif</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-100 text-slate-600">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-slate-500">
                                    <div class="inline-flex flex-wrap items-center gap-1.5 text-[11px]">
                                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium" title="Jumlah jadwal mata pelajaran">
                                            {{ $ta->kelasmatapelajaran_count }} Jadwal
                                        </span>
                                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium" title="Jumlah siswa dalam kelas">
                                            {{ $ta->kelassiswa_count }} Siswa
                                        </span>
                                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium" title="Jumlah data rapor">
                                            {{ $ta->rapor_count }} Rapor
                                        </span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        @if(!$ta->aktif)
                                            <form method="POST" action="{{ route('staff_akademik.tahun-ajaran.activate', $ta->id_tahun_ajaran) }}" onsubmit="return confirm('Apakah Anda yakin ingin mengaktifkan Tahun Ajaran {{ $ta->tahun_mulai }}/{{ $ta->tahun_selesai }} Semester {{ $ta->semester == 1 ? '1 (Ganjil)' : '2 (Genap)' }}?\n\nSemua jadwal dan aktivitas pembelajaran akan merujuk ke periode ini.');" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg hover:bg-emerald-100 transition-colors shadow-sm"
                                                    title="Aktifkan Periode Ini">
                                                    <i class="fa-solid fa-power-off text-[10px]"></i>
                                                    <span>Aktifkan</span>
                                                </button>
                                            </form>
                                        @endif

                                        <button type="button" onclick="openEditModal('{{ $ta->id_tahun_ajaran }}', '{{ $ta->tahun_mulai }}', '{{ $ta->tahun_selesai }}', '{{ $ta->semester }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors shadow-sm"
                                            title="Edit Periode">
                                            <i class="fa-solid fa-pen text-[10px] text-slate-500"></i>
                                            <span>Edit</span>
                                        </button>

                                        @if(!$ta->aktif && $ta->kelasmatapelajaran_count == 0 && $ta->kelassiswa_count == 0 && $ta->rapor_count == 0)
                                            <form method="POST" action="{{ route('staff_akademik.tahun-ajaran.destroy', $ta->id_tahun_ajaran) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Tahun Ajaran {{ $ta->tahun_mulai }}/{{ $ta->tahun_selesai }} Semester {{ $ta->semester }}?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-rose-700 bg-rose-50 border border-rose-100 rounded-lg hover:bg-rose-100 transition-colors"
                                                    title="Hapus Tahun Ajaran">
                                                    <i class="fa-solid fa-trash text-[10px]"></i>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" disabled
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-slate-300 bg-slate-50 border border-slate-100 rounded-lg cursor-not-allowed"
                                                title="{{ $ta->aktif ? 'Tahun ajaran aktif tidak dapat dihapus' : 'Memiliki data relasi terikat' }}">
                                                <i class="fa-solid fa-trash text-[10px]"></i>
                                                <span>Hapus</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                    <i class="fa-regular fa-calendar-xmark text-3xl mb-2 text-slate-300 block"></i>
                                    <span>Belum ada data tahun ajaran yang terdaftar atau sesuai filter.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($tahunAjarans->hasPages())
                <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/40">
                    {{ $tahunAjarans->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Tambah Tahun Ajaran --}}
    <div id="create-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-slate-100 bg-slate-50/50">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Tambah Tahun Ajaran Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftarkan periode kalender akademik baru ke dalam sistem.</p>
                </div>
                <button type="button" onclick="closeCreateModal()"
                    class="text-slate-400 hover:text-slate-700 rounded-lg text-xs w-8 h-8 inline-flex justify-center items-center transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('staff_akademik.tahun-ajaran.store') }}" class="p-5 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="create_tahun_mulai" class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" id="create_tahun_mulai"
                            value="{{ date('Y') }}" min="2000" max="2099"
                            class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                            oninput="updateTahunSelesai('create')"
                            required>
                    </div>
                    <div>
                        <label for="create_tahun_selesai" class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" id="create_tahun_selesai"
                            value="{{ date('Y') + 1 }}" min="2000" max="2099"
                            class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                            required>
                    </div>
                </div>

                <div>
                    <label for="create_semester" class="block text-xs font-semibold text-slate-700 mb-1.5">Semester</label>
                    <select name="semester" id="create_semester"
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                        required>
                        <option value="1">Semester 1 (Ganjil)</option>
                        <option value="2">Semester 2 (Genap)</option>
                    </select>
                </div>

                <div class="pt-1">
                    <label class="flex items-start gap-2.5 cursor-pointer">
                        <input type="checkbox" name="aktif" value="1"
                            class="w-4 h-4 mt-0.5 rounded text-brand-800 border-slate-300 focus:ring-brand-500">
                        <div>
                            <span class="text-xs font-semibold text-slate-800 block">Jadikan sebagai tahun ajaran aktif</span>
                            <span class="text-[11px] text-slate-500">Jika dicentang, tahun ajaran aktif saat ini akan dinonaktifkan dan digantikan periode ini.</span>
                        </div>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-3.5 py-2 text-xs font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-medium text-white bg-brand-800 hover:bg-brand-900 rounded-lg shadow-sm transition-colors">
                        <i class="fa-solid fa-check text-[11px]"></i>
                        <span>Simpan Periode</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Tahun Ajaran --}}
    <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-slate-100 bg-slate-50/50">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Perbarui Tahun Ajaran</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Ubah rentang tahun atau semester akademik.</p>
                </div>
                <button type="button" onclick="closeEditModal()"
                    class="text-slate-400 hover:text-slate-700 rounded-lg text-xs w-8 h-8 inline-flex justify-center items-center transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            <form method="POST" id="edit-form" class="p-5 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="edit_tahun_mulai" class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" id="edit_tahun_mulai" min="2000" max="2099"
                            class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                            oninput="updateTahunSelesai('edit')"
                            required>
                    </div>
                    <div>
                        <label for="edit_tahun_selesai" class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" id="edit_tahun_selesai" min="2000" max="2099"
                            class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                            required>
                    </div>
                </div>

                <div>
                    <label for="edit_semester" class="block text-xs font-semibold text-slate-700 mb-1.5">Semester</label>
                    <select name="semester" id="edit_semester"
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                        required>
                        <option value="1">Semester 1 (Ganjil)</option>
                        <option value="2">Semester 2 (Genap)</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeEditModal()"
                        class="px-3.5 py-2 text-xs font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-medium text-white bg-brand-800 hover:bg-brand-900 rounded-lg shadow-sm transition-colors">
                        <i class="fa-solid fa-check text-[11px]"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('create-modal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('create-modal').classList.add('hidden');
        }

        function openEditModal(id, mulai, selesai, semester) {
            const editForm = document.getElementById('edit-form');
            editForm.action = `/staff_akademik/tahun-ajaran/${id}`;
            document.getElementById('edit_tahun_mulai').value = mulai;
            document.getElementById('edit_tahun_selesai').value = selesai;
            document.getElementById('edit_semester').value = semester;
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        function updateTahunSelesai(prefix) {
            const mulaiInput = document.getElementById(`${prefix}_tahun_mulai`);
            const selesaiInput = document.getElementById(`${prefix}_tahun_selesai`);
            const val = parseInt(mulaiInput.value);
            if (!isNaN(val) && val > 1900) {
                selesaiInput.value = val + 1;
            }
        }

        window.onclick = function(event) {
            const createModal = document.getElementById('create-modal');
            const editModal = document.getElementById('edit-modal');
            if (event.target === createModal) {
                closeCreateModal();
            }
            if (event.target === editModal) {
                closeEditModal();
            }
        };
    </script>
</x-staffakademik-layout>

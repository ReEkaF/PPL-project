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
                            <span class="text-slate-800 font-medium">Prestasi Siswa</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Kelola Data Prestasi Siswa</h1>
                <p class="text-xs text-slate-500">
                    Inventarisasi dan dokumentasi piagam penghargaan serta capaian prestasi siswa.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('staff_akademik.prestasi.pengajuan') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                    <i class="fa-solid fa-inbox text-[11px] text-slate-500"></i>
                    <span>Daftar Pengajuan</span>
                </a>
                <a href="{{ route('prestasi.create') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white transition-colors shadow-sm">
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    <span>Tambah Prestasi</span>
                </a>
            </div>
        </div>

        {{-- Card Container --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            {{-- Toolbar Filter & Pencarian --}}
            <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-slate-50/40">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Daftar Prestasi Siswa Terdata</h2>
                <form action="{{ route('prestasi.index') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative w-full sm:w-72">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Cari nama siswa atau prestasi..."
                            class="w-full pl-9 pr-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                    </div>
                    <button type="submit"
                        class="px-3 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition-colors shadow-sm">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('prestasi.index') }}"
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
                            <th class="px-5 py-3">Nama Siswa</th>
                            <th class="px-5 py-3">Nama Prestasi</th>
                            <th class="px-5 py-3">Bukti</th>
                            <th class="px-5 py-3">Deskripsi</th>
                            <th class="px-5 py-3 text-center">Status</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($prestasi as $row)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 py-3.5 text-center font-mono text-slate-400">
                                    {{ $loop->iteration + ($prestasi->currentPage() - 1) * $prestasi->perPage() }}
                                </td>
                                <td class="px-5 py-3.5 font-semibold text-slate-900 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center">
                                            {{ substr($row->siswa->nama_siswa ?? 'S', 0, 1) }}
                                        </div>
                                        <span>{{ $row->siswa->nama_siswa ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 font-medium text-slate-800">
                                    <div class="inline-flex items-center gap-1.5">
                                        <i class="fa-solid fa-trophy text-amber-500 text-[11px]"></i>
                                        <span>{{ $row->nama_prestasi }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if ($row->bukti_prestasi)
                                        <a href="{{ route('prestasi.show', $row->id_prestasi) }}" target="_blank"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-medium bg-brand-50 text-brand-800 hover:bg-brand-100 border border-brand-100 transition-colors">
                                            <i class="fa-solid fa-file-lines text-[10px]"></i>
                                            <span>Lihat Bukti</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic text-[11px]">Tidak ada berkas</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-slate-500 max-w-xs truncate">
                                    {{ $row->deskripsi_prestasi ?: '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                    @if($row->status_prestasi == 1)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#EAF6EF] text-[#1F7A46]">
                                            <i class="fa-solid fa-circle-check text-[9px]"></i>
                                            <span>Terverifikasi</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#FDF3E4] text-[#92620A]">
                                            <i class="fa-solid fa-clock text-[9px]"></i>
                                            <span>Menunggu</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <button type="button"
                                            onclick="openEditModal('{{ $row->id_prestasi }}', '{{ addslashes($row->nama_prestasi) }}', '{{ addslashes($row->deskripsi_prestasi) }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors shadow-sm"
                                            title="Edit Prestasi">
                                            <i class="fa-solid fa-pen text-[10px] text-slate-500"></i>
                                            <span>Edit</span>
                                        </button>
                                        <form method="POST" action="{{ route('prestasi.destroy', $row->id_prestasi) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data prestasi ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-rose-700 bg-rose-50 border border-rose-100 rounded-lg hover:bg-rose-100 transition-colors"
                                                title="Hapus Prestasi">
                                                <i class="fa-solid fa-trash text-[10px]"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                                    <i class="fa-regular fa-folder-open text-3xl mb-2 text-slate-300 block"></i>
                                    <span>Belum ada data prestasi yang terdaftar atau sesuai filter.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($prestasi->hasPages())
                <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/40">
                    {{ $prestasi->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Edit Prestasi (Dinamis) --}}
    <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-slate-100 bg-slate-50/50">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Perbarui Data Prestasi</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Edit nama dan rincian catatan prestasi siswa.</p>
                </div>
                <button type="button" onclick="closeEditModal()"
                    class="text-slate-400 hover:text-slate-700 rounded-lg text-xs w-8 h-8 inline-flex justify-center items-center transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            <form method="POST" id="edit-form" class="p-5 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit_nama_prestasi" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Prestasi</label>
                    <input type="text" name="nama_prestasi" id="edit_nama_prestasi"
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                        required>
                </div>
                <div>
                    <label for="edit_deskripsi_prestasi" class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Prestasi</label>
                    <textarea name="deskripsi_prestasi" id="edit_deskripsi_prestasi" rows="4"
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                        required></textarea>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
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
        function openEditModal(id, nama, deskripsi) {
            const form = document.getElementById('edit-form');
            form.action = `/staff_akademik/prestasi/${id}`;
            document.getElementById('edit_nama_prestasi').value = nama;
            document.getElementById('edit_deskripsi_prestasi').value = deskripsi;
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('edit-modal');
            if (event.target === modal) {
                closeEditModal();
            }
        };
    </script>
</x-staffakademik-layout>
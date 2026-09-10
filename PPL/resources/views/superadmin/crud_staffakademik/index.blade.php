<x-admin-layout>
    <div class="space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('superadmin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-700 font-medium">Staff Akademik</span>
                </nav>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Akun Staff Akademik</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('superadmin.kelola_staff_akademik.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-indigo-700 hover:bg-indigo-800 text-white text-sm font-medium shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Staff Baru</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div id="success-alert" class="flex items-center justify-between p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('success-alert').remove()" class="text-emerald-700 hover:text-emerald-900 text-lg leading-none">&times;</button>
            </div>
        @endif

        <!-- Card Container -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="text-sm text-slate-500">
                    Total terdaftar: <span class="font-semibold text-slate-800">{{ $staffakademik->count() }} Petugas</span>
                </div>
            </div>

            <!-- Table Responsive Wrapper -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-200/80">
                        <tr>
                            <th class="py-3.5 px-4 sm:px-6">Nama & Username</th>
                            <th class="py-3.5 px-4">Email</th>
                            <th class="py-3.5 px-4">Kontak WA</th>
                            <th class="py-3.5 px-4 hidden md:table-cell">Alamat</th>
                            <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($staffakademik as $staff)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-800 font-bold flex items-center justify-center text-xs flex-shrink-0">
                                            {{ strtoupper(substr($staff->nama_staff_akademik ?? $staff->username, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-900">{{ $staff->nama_staff_akademik }}</div>
                                            <div class="text-xs text-slate-400 font-mono">@<span>{{ $staff->username }}</span></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-700">
                                    {{ $staff->email }}
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-600">
                                    {{ $staff->wa_staff_akademik ?: '-' }}
                                </td>
                                <td class="py-3.5 px-4 hidden md:table-cell text-xs text-slate-500 max-w-xs truncate">
                                    {{ $staff->alamat_staff_akademik ?: '-' }}
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 text-right">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <a href="{{ route('superadmin.kelola_staff_akademik.edit', $staff->id_staff_akademik) }}" class="px-2.5 py-1 text-xs font-medium rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('superadmin.kelola_staff_akademik.reset', $staff->id_staff_akademik) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset password staf ini ke username-nya?')" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded-md bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/60 transition-colors">
                                                Reset Sandi
                                            </button>
                                        </form>
                                        <form action="{{ route('superadmin.kelola_staff_akademik.destroy', $staff->id_staff_akademik) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data staf akademik ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded-md bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/60 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-sm text-slate-400">
                                    Tidak ada data staff akademik.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
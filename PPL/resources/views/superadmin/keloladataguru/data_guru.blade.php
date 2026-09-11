<x-admin-layout>
    <div class="space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('superadmin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-700 font-medium">Kelola Guru</span>
                </nav>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Direktori Guru & Tenaga Pendidik</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('data.guru.tambah') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[#06466C] hover:bg-[#053a5a] text-white text-sm font-medium shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Guru Baru</span>
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
            <!-- Filter & Search Bar -->
            <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="text-sm text-slate-500">
                    Total terdaftar: <span class="font-semibold text-slate-800">{{ $guruData->total() }} Guru</span>
                </div>
                <form action="{{ route('superadmin.searchGuru') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                    <div class="relative w-full sm:w-72">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" placeholder="Cari NIP guru..." value="{{ request('search') }}"
                            class="w-full pl-9 pr-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-[#06466C] focus:ring-1 focus:ring-[#06466C]/20 focus:outline-none transition-colors">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors flex-shrink-0">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('superadmin.keloladataguru') }}" class="px-3 py-2 text-sm text-slate-500 hover:text-slate-800 transition-colors">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Table Responsive Wrapper -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-200/80">
                        <tr>
                            <th class="py-3.5 px-4 sm:px-6">Profil Guru</th>
                            <th class="py-3.5 px-4">NIP</th>
                            <th class="py-3.5 px-4 hidden md:table-cell">Kontak & Email</th>
                            <th class="py-3.5 px-4 hidden lg:table-cell">Alamat</th>
                            <th class="py-3.5 px-4">Peran</th>
                            <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($guruData as $guru)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $guru->foto_guru ? asset('images/guru/' . $guru->foto_guru) : 'https://cdn.pixabay.com/photo/2018/11/13/21/43/avatar-3814049_640.png' }}"
                                            alt="{{ $guru->nama_guru }}"
                                            class="w-10 h-10 rounded-full object-cover border border-slate-200 flex-shrink-0">
                                        <div>
                                            <div class="font-semibold text-slate-900">{{ $guru->nama_guru }}</div>
                                            <div class="text-xs text-slate-400 sm:hidden">NIP: {{ $guru->nip }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs text-slate-700">
                                    {{ $guru->nip }}
                                </td>
                                <td class="py-3.5 px-4 hidden md:table-cell text-xs">
                                    <div class="text-slate-700">{{ $guru->email }}</div>
                                    <div class="text-slate-400 mt-0.5">{{ $guru->nomor_wa_guru ?: '-' }}</div>
                                </td>
                                <td class="py-3.5 px-4 hidden lg:table-cell text-xs text-slate-500 max-w-xs truncate">
                                    {{ $guru->alamat_guru ?: '-' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($guru->role_guru === 'pembina')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200/60">
                                            Pembina Ekskul
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#06466C]/10 text-[#06466C] border border-[#06466C]/20">
                                            Guru Pengajar
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 text-right">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <a href="{{ route('guru.edit', $guru->id_guru) }}" class="px-2.5 py-1 text-xs font-medium rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('guru.destroy', $guru->id_guru) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru ini?')" class="inline">
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
                                <td colspan="6" class="py-8 text-center text-sm text-slate-400">
                                    Tidak ada data guru yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if($guruData->hasPages())
                <div class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <div>
                        Menampilkan <span class="font-semibold text-slate-700">{{ $guruData->firstItem() }}</span> s/d <span class="font-semibold text-slate-700">{{ $guruData->lastItem() }}</span> dari total <span class="font-semibold text-slate-700">{{ $guruData->total() }}</span> guru
                    </div>
                    <div>
                        {{ $guruData->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
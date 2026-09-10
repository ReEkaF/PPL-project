<x-admin-layout>
    <div class="space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('superadmin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-700 font-medium">Pembina Ekstrakurikuler</span>
                </nav>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Pembina Ekstrakurikuler</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('kelola_pembina_ekstrakurikuler.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-purple-700 hover:bg-purple-800 text-white text-sm font-medium shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tetapkan Pembina Baru</span>
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
                    Total pembina: <span class="font-semibold text-slate-800">{{ $pembinas->total() }} Guru</span>
                </div>
            </div>

            <!-- Table Responsive Wrapper -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-200/80">
                        <tr>
                            <th class="py-3.5 px-4 sm:px-6">Profil Pembina</th>
                            <th class="py-3.5 px-4">NIP</th>
                            <th class="py-3.5 px-4">Ekstrakurikuler</th>
                            <th class="py-3.5 px-4 hidden md:table-cell">Kontak & Email</th>
                            <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pembinas as $pembina)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $pembina->foto_guru ? asset('images/guru/' . $pembina->foto_guru) : 'https://cdn.pixabay.com/photo/2018/11/13/21/43/avatar-3814049_640.png' }}"
                                            alt="{{ $pembina->nama_guru }}"
                                            class="w-10 h-10 rounded-full object-cover border border-slate-200 flex-shrink-0">
                                        <div>
                                            <div class="font-semibold text-slate-900">{{ $pembina->nama_guru }}</div>
                                            <div class="text-xs text-slate-400 sm:hidden">NIP: {{ $pembina->nip }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs text-slate-700">
                                    {{ $pembina->nip }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @forelse ($pembina->ekstrakurikuler as $ekstra)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200/60 mr-1 mb-1">
                                            {{ $ekstra->nama_ekstrakurikuler }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">Belum dipetakan</span>
                                    @endforelse
                                </td>
                                <td class="py-3.5 px-4 hidden md:table-cell text-xs">
                                    <div class="text-slate-700">{{ $pembina->email }}</div>
                                    <div class="text-slate-400 mt-0.5">{{ $pembina->nomor_wa_guru ?: '-' }}</div>
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 text-right">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <a href="{{ route('kelola_pembina_ekstrakurikuler.edit', $pembina->id_guru) }}" class="px-2.5 py-1 text-xs font-medium rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('kelola_pembina_ekstrakurikuler.destroy', $pembina->id_guru) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mencabut role pembina dari guru ini?')" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded-md bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/60 transition-colors">
                                                Cabut Peran
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-sm text-slate-400">
                                    Tidak ada data pembina ekstrakurikuler.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if($pembinas->hasPages())
                <div class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <div>
                        Menampilkan <span class="font-semibold text-slate-700">{{ $pembinas->firstItem() }}</span> s/d <span class="font-semibold text-slate-700">{{ $pembinas->lastItem() }}</span> dari total <span class="font-semibold text-slate-700">{{ $pembinas->total() }}</span> pembina
                    </div>
                    <div>
                        {{ $pembinas->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
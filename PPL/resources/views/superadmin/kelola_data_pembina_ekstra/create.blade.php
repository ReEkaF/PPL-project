<x-admin-layout>
    <div class="space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('superadmin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('superadmin.kelola_pembina_ekstrakurikuler') }}" class="hover:text-slate-900 transition-colors">Pembina Ekstrakurikuler</a>
                    <span>/</span>
                    <span class="text-slate-700 font-medium">Tetapkan Pembina</span>
                </nav>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Pilih Guru Sebagai Pembina Ekstrakurikuler</h1>
                <p class="text-sm text-slate-500 mt-1">Pilih guru dari daftar berikut untuk ditetapkan sebagai pembina kegiatan ekstrakurikuler</p>
            </div>
            <div>
                <a href="{{ route('superadmin.kelola_pembina_ekstrakurikuler') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium transition-colors">
                    Kembali
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

        <!-- Card Table -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="text-sm text-slate-500">
                    Total guru tersedia: <span class="font-semibold text-slate-800">{{ $gurus->total() }} Guru</span>
                </div>
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
                            <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($gurus as $guru)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $guru->foto_guru ? asset('images/guru/' . $guru->foto_guru) : 'https://ui-avatars.com/api/?name='.urlencode($guru->nama_guru).'&background=06466C&color=ffffff' }}"
                                            alt="{{ $guru->nama_guru }}"
                                            class="w-10 h-10 rounded-full object-cover border border-slate-200 flex-shrink-0">
                                        <div>
                                            <div class="font-semibold text-slate-900">{{ $guru->nama_guru }}</div>
                                            <div class="text-xs text-slate-400 font-mono">NIP: {{ $guru->nip }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs text-slate-700">
                                    {{ $guru->nip }}
                                </td>
                                <td class="py-3.5 px-4 hidden md:table-cell text-xs">
                                    <div class="text-slate-700">{{ $guru->email }}</div>
                                    <div class="text-slate-400 font-mono mt-0.5">{{ $guru->nomor_wa_guru ?: '-' }}</div>
                                </td>
                                <td class="py-3.5 px-4 hidden lg:table-cell text-xs text-slate-500 max-w-xs truncate">
                                    {{ $guru->alamat_guru ?: '-' }}
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 text-right">
                                    <form action="{{ route('kelola_pembina_ekstrakurikuler.store', $guru->id_guru) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menetapkan guru ini sebagai pembina ekstrakurikuler?')" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-[#06466C] hover:bg-[#053a5a] text-white shadow-sm transition-colors">
                                            Tetapkan Pembina
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-sm text-slate-400">
                                    Tidak ada data guru yang tersedia untuk ditetapkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($gurus->hasPages())
                <div class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <div>
                        Menampilkan <span class="font-semibold text-slate-700">{{ $gurus->firstItem() }}</span> s/d <span class="font-semibold text-slate-700">{{ $gurus->lastItem() }}</span> dari total <span class="font-semibold text-slate-700">{{ $gurus->total() }}</span> guru
                    </div>
                    <div>
                        {{ $gurus->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

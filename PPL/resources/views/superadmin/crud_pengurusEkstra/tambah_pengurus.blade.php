<x-admin-layout>
    <div class="space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('superadmin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('superadmin.keloladatapengurus') }}" class="hover:text-slate-900 transition-colors">Pengurus Ekstrakurikuler</a>
                    <span>/</span>
                    <span class="text-slate-700 font-medium">Tambah Pengurus</span>
                </nav>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Pilih Siswa Sebagai Pengurus Ekstrakurikuler</h1>
                <p class="text-sm text-slate-500 mt-1">Pilih siswa dari daftar berikut dan tentukan ekstrakurikuler serta status perannya</p>
            </div>
            <div>
                <a href="{{ route('superadmin.keloladatapengurus') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium transition-colors">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Card Container -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="text-sm text-slate-500">
                    Daftar Siswa Tersedia
                </div>
                <div class="relative w-full sm:w-64">
                    <input type="text" id="search-input" placeholder="Cari nama atau NISN..."
                        class="w-full text-xs rounded-lg border border-slate-300 pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors">
                    <svg class="absolute left-2.5 top-2.5 w-3.5 h-3.5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 10-14 0 7 7 0 0014 0z" />
                    </svg>
                </div>
            </div>

            <!-- Table Responsive Wrapper -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600" id="search-table">
                    <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-200/80">
                        <tr>
                            <th class="py-3.5 px-4 sm:px-6">Profil Siswa</th>
                            <th class="py-3.5 px-4">NISN</th>
                            <th class="py-3.5 px-4 hidden md:table-cell">Kontak & Email</th>
                            <th class="py-3.5 px-4">Ekstrakurikuler & Role</th>
                            <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100" id="table-body">
                        @foreach ($siswa as $sis)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $sis->foto_siswa ? asset('images/siswa/' . $sis->foto_siswa) : 'https://ui-avatars.com/api/?name='.urlencode($sis->nama_siswa).'&background=06466C&color=ffffff' }}"
                                            alt="{{ $sis->nama_siswa }}"
                                            class="w-10 h-10 rounded-full object-cover border border-slate-200 flex-shrink-0">
                                        <div>
                                            <div class="font-semibold text-slate-900">{{ $sis->nama_siswa }}</div>
                                            <div class="text-xs text-slate-400 font-mono sm:hidden">NISN: {{ $sis->nisn }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs text-slate-700">
                                    {{ $sis->nisn }}
                                </td>
                                <td class="py-3.5 px-4 hidden md:table-cell text-xs">
                                    <div class="text-slate-700">{{ $sis->email }}</div>
                                    <div class="text-slate-400 font-mono mt-0.5">{{ $sis->nomor_wa_siswa ?: '-' }}</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <form id="form-pengurus-{{ $sis->id_siswa }}" action="{{ route('pengurus.store', $sis->id_siswa) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-2">
                                        @csrf
                                        <select name="ekstrakurikuler" class="text-xs rounded-lg border border-slate-300 px-2.5 py-1.5 bg-white focus:outline-none focus:ring-1 focus:ring-[#06466C] focus:border-[#06466C] transition-colors" required>
                                            @foreach($ekstrakurikuler as $ekstrakurikulerItem)
                                                <option value="{{ $ekstrakurikulerItem->id_ekstrakurikuler }}">{{ $ekstrakurikulerItem->nama_ekstrakurikuler }}</option>
                                            @endforeach
                                        </select>
                                        <select id="role_siswa" name="role_siswa" class="text-xs rounded-lg border border-slate-300 px-2.5 py-1.5 bg-white focus:outline-none focus:ring-1 focus:ring-[#06466C] focus:border-[#06466C] transition-colors" required>
                                            <option value="pengurus" {{ old('role_siswa', $sis->role_siswa) == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                                            <option value="siswa" {{ old('role_siswa', $sis->role_siswa) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 text-right">
                                    <button type="submit" form="form-pengurus-{{ $sis->id_siswa }}"
                                        class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-[#06466C] hover:bg-[#053a5a] text-white shadow-sm transition-colors">
                                        Tetapkan
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const tableBody = document.getElementById('table-body');
            const rows = tableBody.getElementsByTagName('tr');

            searchInput.addEventListener('input', function () {
                const searchValue = searchInput.value.toLowerCase();
                Array.from(rows).forEach(row => {
                    const cells = row.getElementsByTagName('td');
                    const match = Array.from(cells).some(cell => 
                        cell.textContent.toLowerCase().includes(searchValue)
                    );
                    row.style.display = match ? '' : 'none';
                });
            });
        });
    </script>
</x-admin-layout>

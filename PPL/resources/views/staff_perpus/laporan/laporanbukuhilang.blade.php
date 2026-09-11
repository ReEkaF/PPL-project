<x-staffperpustakaan-layout>
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Laporan Buku Hilang</h1>
            <p class="text-sm text-slate-500 mt-1">Rekapitulasi data buku hilang berdasarkan rentang periode peminjaman</p>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 mb-6">
            <form action="{{ route('staff_perpus.laporan.laporanbukuhilang') }}" method="GET" id="filter-form">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                    <!-- Filter Bulan Awal -->
                    <div>
                        <label for="bulan_awal" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Bulan Awal</label>
                        <select name="bulan_awal" id="bulan_awal" class="w-full text-sm rounded-lg border border-slate-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors">
                            @foreach([1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'] as $num => $month)
                                <option value="{{ $num }}" {{ $bulan_awal == $num ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Tahun Awal -->
                    <div>
                        <label for="tahun_awal" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Awal</label>
                        <input type="number" name="tahun_awal" id="tahun_awal"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3 py-2 font-mono focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ $tahun_awal }}">
                    </div>

                    <!-- Filter Bulan Akhir -->
                    <div>
                        <label for="bulan_akhir" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Bulan Akhir</label>
                        <select name="bulan_akhir" id="bulan_akhir" class="w-full text-sm rounded-lg border border-slate-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors">
                            @foreach([1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'] as $num => $month)
                                <option value="{{ $num }}" {{ $bulan_akhir == $num ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Tahun Akhir -->
                    <div>
                        <label for="tahun_akhir" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Akhir</label>
                        <input type="number" name="tahun_akhir" id="tahun_akhir"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3 py-2 font-mono focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ $tahun_akhir }}">
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-[#06466C] hover:bg-[#053a5a] rounded-lg shadow-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Metric Summary Card -->
        <div class="mb-6">
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm inline-block min-w-[240px]">
                <div class="text-xs font-medium text-slate-500">Total Buku Hilang Periode Ini</div>
                <div class="text-2xl font-bold font-mono text-rose-600 mt-1">{{ $jumlah_buku_hilang }} <span class="text-xs font-sans text-slate-500 font-normal">buku</span></div>
            </div>
        </div>

        <!-- Tabel Daftar Buku Hilang -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Judul Buku</th>
                            <th class="px-6 py-3.5">Kode Peminjam</th>
                            <th class="px-6 py-3.5">Tanggal Peminjaman</th>
                            <th class="px-6 py-3.5">Tanggal Pengembalian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($buku_hilang as $transaksi)
                            <tr class="hover:bg-slate-50/75 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $transaksi->buku->judul_buku }}</td>
                                <td class="px-6 py-4 font-mono text-slate-600">{{ $transaksi->kode_peminjam }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($transaksi->tgl_awal_peminjaman)->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($transaksi->tgl_pengembalian)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-slate-500">
                                    Tidak ada data buku hilang pada periode yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Menampilkan tombol pagination -->
            @if($buku_hilang->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-white">
                    {{ $buku_hilang->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('filter-form')?.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                this.submit();
            }
        });
    </script>
</x-staffperpustakaan-layout>

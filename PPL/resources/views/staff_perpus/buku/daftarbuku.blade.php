<x-staffperpustakaan-layout>
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Daftar Buku</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola katalog dan ketersediaan buku perpustakaan sekolah</p>
            </div>
            <!-- Tombol Tambah Buku -->
            <div>
                <a href="{{ route('staff_perpus.buku.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-[#06466C] hover:bg-[#053a5a] rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Buku
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Card Container -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <!-- Filter & Search Bar -->
            <div class="p-4 border-b border-slate-200 bg-slate-50/50">
                <form action="{{ route('staff_perpus.buku.daftarbuku') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" placeholder="Cari judul buku atau penulis..."
                            class="w-full pl-9 pr-4 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('search', request('search')) }}" />
                    </div>
                    <select name="kategori_buku" class="text-sm rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] bg-white text-slate-700 transition-colors"
                        onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriBuku as $cat)
                            <option value="{{ $cat->id_kategori_buku }}"
                                {{ old('kategori_buku', request('kategori_buku')) == $cat->id_kategori_buku ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Tabel Buku -->
            <div id="admin-daftarbuku-table" class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Gambar</th>
                            <th class="px-6 py-3.5">Nama Buku</th>
                            <th class="px-6 py-3.5">Author</th>
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5">Jenis</th>
                            <th class="px-6 py-3.5">Stok</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($buku as $item)
                            <tr class="hover:bg-slate-50/75 transition-colors">
                                <td class="px-6 py-3.5">
                                    <img src="{{ asset($item->foto_buku) }}" alt="{{ $item->judul_buku }}"
                                        class="w-12 h-16 rounded-md object-cover border border-slate-200 shadow-sm bg-slate-100">
                                </td>
                                <td class="px-6 py-3.5 font-medium text-slate-900 max-w-xs truncate">{{ $item->judul_buku }}</td>
                                <td class="px-6 py-3.5 text-slate-600">{{ $item->author_buku }}</td>
                                <td class="px-6 py-3.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $item->kategoriBuku->nama_kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-slate-600">{{ $item->jenisBuku->nama_jenis_buku }}</td>
                                <td class="px-6 py-3.5">
                                    <span class="font-mono text-sm font-semibold {{ $item->stok_buku > 0 ? 'text-slate-900' : 'text-rose-600' }}">
                                        {{ $item->stok_buku }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-3 text-xs">
                                        <a href="{{ route('staff_perpus.buku.detail', $item->id_buku) }}"
                                            class="font-medium text-[#06466C] hover:text-[#053a5a] transition-colors">Detail</a>
                                        <a href="{{ route('staff_perpus.buku.edit', $item->id_buku) }}"
                                            class="font-medium text-slate-600 hover:text-slate-900 transition-colors">Edit</a>
                                        <form action="{{ route('staff_perpus.buku.destroy', $item->id_buku) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-rose-600 hover:text-rose-800 transition-colors"
                                                onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-sm text-slate-500">
                                    Tidak ada data buku yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination controls -->
            <div id="pagination-controls" class="px-6 py-4 border-t border-slate-200 flex items-center justify-between bg-white">
                <button id="prev-btn"
                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-md hover:bg-slate-50 transition-colors disabled:opacity-50">Previous</button>
                <div id="page-numbers" class="flex items-center gap-1"></div>
                <button id="next-btn"
                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-md hover:bg-slate-50 transition-colors disabled:opacity-50">Next</button>
            </div>
        </div>
    </div>
</x-staffperpustakaan-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rowsPerPage = 10; // Ganti Disini Berapa Biji per-Halamannya
        let currentPage = 1;
        const rows = Array.from(document.querySelectorAll('#admin-daftarbuku-table tbody tr'));
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const pageNumbersContainer = document.getElementById('page-numbers'); // Container for page numbers
        let filteredRows = rows;

        function showPage(page) {
            const startIdx = (page - 1) * rowsPerPage;
            const endIdx = startIdx + rowsPerPage;

            filteredRows.forEach((row, index) => {
                if (index >= startIdx && index < endIdx) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Disable/Enable buttons
            if (currentPage == 1) {
                prevBtn.classList.add('invisible');
            } else {
                prevBtn.classList.remove('invisible')
            }
            if (currentPage * rowsPerPage >= filteredRows.length) {
                nextBtn.classList.add('invisible');
            } else {
                nextBtn.classList.remove('invisible');
            }

            // Update the page numbers
            updatePageNumbers();
        }

        function updatePageNumbers() {
            // Clear the page numbers container
            pageNumbersContainer.innerHTML = '';

            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

            // Create page number buttons
            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                if (i === currentPage) {
                    pageButton.className = 'w-8 h-8 flex items-center justify-center rounded-md text-xs font-semibold bg-[#06466C] text-white shadow-sm';
                } else {
                    pageButton.className = 'w-8 h-8 flex items-center justify-center rounded-md text-xs font-medium text-slate-700 hover:bg-slate-100 transition-colors';
                }
                pageButton.addEventListener('click', () => {
                    currentPage = i;
                    showPage(currentPage);
                });
                pageNumbersContainer.appendChild(pageButton);
            }
        }

        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentPage * rowsPerPage < filteredRows.length) {
                currentPage++;
                showPage(currentPage);
            }
        });

        // Initial page load
        showPage(currentPage);
    });
</script>

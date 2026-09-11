<x-staffperpustakaan-layout>
    @include('staff_perpus/modal/addCategory_Modal')
    @include('staff_perpus/modal/deleteCategory_Modal')
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kategori Buku</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola klasifikasi dan kategori koleksi buku perpustakaan</p>
            </div>
            <div class="flex items-center gap-2">
                <button data-modal-target="delete-modal" data-modal-toggle="delete-modal" type="button"
                    class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-medium text-rose-700 bg-white border border-rose-200 hover:bg-rose-50 rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4 text-rose-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Pilihan
                </button>
                <button data-modal-target="create-modal" data-modal-toggle="create-modal" type="button"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-[#06466C] hover:bg-[#053a5a] rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kategori
                </button>
            </div>
        </div>

        <!-- Card Container -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <!-- Search Bar -->
            <div class="p-4 border-b border-slate-200 bg-slate-50/50">
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search"
                        class="w-full pl-9 pr-4 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                        placeholder="Cari kategori buku...">
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table id="categories-table" class="w-full text-sm text-left">
                    <thead class="text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th scope="col" class="w-12 px-6 py-3.5">
                                <input id="checkbox-all-search" type="checkbox"
                                    class="w-4 h-4 text-[#06466C] bg-white border-slate-300 rounded focus:ring-[#06466C]">
                            </th>
                            <th scope="col" class="px-6 py-3.5">
                                Nama Kategori
                            </th>
                            <th scope="col" class="px-6 py-3.5 text-right">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($arrayCategory as $AC)
                            @include('staff_perpus/modal/editCategory_Modal')
                            <tr class="hover:bg-slate-50/75 transition-colors">
                                <td class="w-12 px-6 py-4">
                                    <input type="checkbox" class="category-checkbox w-4 h-4 text-[#06466C] bg-white border-slate-300 rounded focus:ring-[#06466C]"
                                        data-id="{{ $AC->id_kategori_buku }}">
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    {{ $AC->nama_kategori }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button data-modal-target="update-modal-{{ $AC->nama_kategori }}"
                                        data-modal-toggle="update-modal-{{ $AC->nama_kategori }}" type="button"
                                        class="inline-flex items-center gap-1.5 text-xs font-medium text-[#06466C] hover:text-[#053a5a] transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
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
        const rowsPerPage = 5;
        let currentPage = 1;
        const rows = Array.from(document.querySelectorAll('#categories-table tbody tr'));
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

        // Get the search input element
        const searchInput = document.getElementById('table-search');

        // Add an event listener to detect input changes
        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value
                .toLowerCase(); // Get the value and convert to lowercase
            const tableRows = document.querySelectorAll(
                'table tbody tr'); // Select all rows in the table body

            // Loop through each table row
            tableRows.forEach(function(row) {
                const categoryNameCell = row.querySelector(
                    'th'); // Get the category name cell (assuming it's in <th>)
                const categoryName = categoryNameCell.textContent
                    .toLowerCase(); // Get the text content and convert to lowercase

                // Check if the category name contains the search term
                if (categoryName.includes(searchTerm)) {
                    row.style.display = ''; // Show the row if it matches
                } else {
                    row.style.display = 'none'; // Hide the row if it doesn't match
                }
            });
        });
    });
</script>

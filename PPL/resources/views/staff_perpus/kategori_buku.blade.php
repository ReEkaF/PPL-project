<x-staffperpustakaan-layout>
    @include('staff_perpus/modal/addCategory_Modal')
    @include('staff_perpus/modal/deleteCategory_Modal')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-16 py-8 bg-white m-4">
        <div class="pb-4 bg-white dark:bg-gray-900">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search"
                    class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search for items">
            </div>
        </div>
        <button data-modal-target="delete-modal" data-modal-toggle="delete-modal" type="button"
            class="text-white bg-red-700 hover:bg-red-800 mb-5 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
            </svg>
            Hapus
        </button>
        <button data-modal-target="create-modal" data-modal-toggle="create-modal" type="button"
            class="text-white bg-green-700 hover:bg-green-800 mb-5 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z"
                    clip-rule="evenodd" />
            </svg>
            Tambah
        </button>
        <table id="categories-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input id="checkbox-all-search" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Category name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($arrayCategory as $AC)
                    @include('staff_perpus/modal/editCategory_Modal')
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input type="checkbox" class="category-checkbox" data-id="{{ $AC->id_kategori_buku }}"
                                    id="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $AC->nama_kategori }}
                        </th>
                        <td class="px-6 py-4">
                            <button data-modal-target="update-modal-{{ $AC->nama_kategori }}"
                                data-modal-toggle="update-modal-{{ $AC->nama_kategori }}" type="button" class="flex">
                                <span>Edit</span>
                                <svg class="w-5 h-5 ml-2 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Pagination controls -->
    <div id="pagination-controls" class="mt-6 mx-4 py-4 px-16 flex w-min-[96] bg-white rounded-lg">
        <button id="prev-btn"
            class="px-4 bg-[#D9D9D9] text-black font-semibold h-[2rem] font-['Poppins'] mx-[0.3rem]">Previous</button>
        <div id="page-numbers"></div>
        <button id="next-btn"
            class="px-4 bg-[#D9D9D9] text-black font-semibold h-[2rem] font-['Poppins'] mx-[0.3rem]">Next</button>
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
                pageButton.classList.add('page-btn');
                if (i === currentPage) {
                    pageButton.classList.add('active'); // Optional: Add a class to highlight the current page
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

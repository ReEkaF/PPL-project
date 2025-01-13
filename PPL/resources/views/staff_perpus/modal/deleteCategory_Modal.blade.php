<div id="delete-modal" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button"
                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="delete-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <form action="{{ route('bookcategories.delete') }}" method="POST" class="p-4 md:p-5 text-center">
                @csrf
                <input type="hidden" id="selected_categories" name="selected_categories">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete
                    this categories?</h3>
                <button data-modal-hide="delete-modal" type="submit"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Yes, I'm sure
                </button>
                <button data-modal-hide="delete-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                    cancel</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Seleksi semua checkbox dengan class 'category-checkbox'
        const checkboxes = document.querySelectorAll('.category-checkbox');
        const checkboxAllSearch = document.getElementById('checkbox-all-search');
        const hiddenInput = document.getElementById('selected_categories');

        // Fungsi untuk update input hidden dengan id kategori yang dicentang
        function updateHiddenInput() {
            const selectedIds = [];

            // Iterasi checkbox dan kumpulkan id yang dicentang
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedIds.push(checkbox.getAttribute('data-id'));
                }
            });

            // Masukkan ID kategori yang dicentang ke input hidden, dipisahkan dengan koma
            hiddenInput.value = selectedIds.join(',');
        }

        // Event listener untuk setiap checkbox individual
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Jika checkbox individual dicentang, update 'checkbox-all-search' state
                if (checkbox.checked === false) {
                    checkboxAllSearch.checked =
                        false; // Uncheck 'checkbox-all-search' if any checkbox is unchecked
                } else if (Array.from(checkboxes).every(cb => cb.checked)) {
                    checkboxAllSearch.checked =
                        true; // Check 'checkbox-all-search' if all are checked
                }
                updateHiddenInput();
            });
        });

        // Event listener untuk checkbox 'checkbox-all-search'
        checkboxAllSearch.addEventListener('change', function() {
            const isChecked = checkboxAllSearch.checked;

            // Set all checkboxes to match the 'checkbox-all-search' state
            checkboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });

            // Update hidden input after changing the state
            updateHiddenInput();
        });
    });
</script>

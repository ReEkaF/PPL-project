<!-- Main modal -->
<div id="update-modal-{{ $transaction->id_transaksi_peminjaman }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-[50vw] max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Pengembalian
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="update-modal-{{ $transaction->id_transaksi_peminjaman }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form action="{{ route('updateStatus', $transaction->id_transaksi_peminjaman) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <ul
                        class="max-w-[48vw] text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        <li class="flex pb-3 justify-between">
                            <span>{{ $transaction->buku->judul_buku }}</span>
                            <select name="status_pengembalian" class="form-select">
                                <option value="0" {{ $transaction->status_pengembalian == 0 ? 'selected' : '' }}>
                                    Telat</option>
                                <option value="1" {{ $transaction->status_pengembalian == 1 ? 'selected' : '' }}>
                                    Aman</option>
                                <option value="2" {{ $transaction->status_pengembalian == 2 ? 'selected' : '' }}>
                                    Hilang</option>
                            </select>
                        </li>
                    </ul>

                    <div class="flex items-center space-x-4 mb-5">
                        @if ($transaction->status_denda == 0)
                            <div class="flex items-center mb-4">
                                <input id="default-checkbox" type="checkbox" value="1" name="status_denda"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-checkbox"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Sudah
                                    Dibayar</label>
                            </div>
                        @else
                            <div class="flex items-center mb-4">
                                <input disabled checked id="disabled-checked-checkbox" type="checkbox" value="1"
                                    name="status_denda"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="disabled-checked-checkbox"
                                    class="ms-2 text-sm font-medium text-gray-400 dark:text-gray-500">Sudah
                                    Dibayar</label>
                            </div>
                        @endif
                    </div>

                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Konfirmasi
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

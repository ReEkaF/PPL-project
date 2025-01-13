<x-app-guru-layout>
    <div class="pt-6">
        <div class="lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Breadcrumb --}}
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex space-x-2">
                            <li class="flex">
                                <a href="{{ route('pengurus_ekstra.dashboard') }}"
                                    class="text-gray-400 hover:text-gray-700">
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <div class="flex justify-center py-1">
                                <svg class="flex w-4 h-4 text-gray-800" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m9 5 7 7-7 7" />
                                </svg>
                            </div>
                            <li class="flex">
                                <p class="font-semibold text-gray-700">
                                    <span>Perlengkapan</span>
                                </p>
                            </li>
                        </ol>
                    </nav>
                    <div class="flex justify-between items-center space-y-4">
                        <h2 class="text-2xl font-semibold text-gray-800">Perlengkapan Ekstrakurikuler
                            {{ $nama_ekstrakurikuler }}</h2>
                    </div>

                    @if (session()->has('success'))
                        <x-alert-notification :color="'green'">
                            {{ session('success') }}
                        </x-alert-notification>
                    @endif

                    <div class="pt-4">
                        <table class="min-w-full divide-y divide-gray-200" id="search-table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Barang</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stok</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Histori Peminjaman</th>
                                </tr>
                            </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($perlengkapan_ekstras as $index => $item)
                                        <tr class="{{ $loop->even ? 'bg-gray-100' : '' }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $item->nama_barang }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->stok }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <a href="{{ route('pembina.histori', $item->id_inventaris) }}"
                                                    class="inline-flex items-center px-2 py-1 border border-gray-500 rounded-md font-semibold text-xs text-gray-500 uppercase tracking-widest hover:bg-gray-500 hover:text-white active:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900 text-center"
                                                colspan="4">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                        </table>
                        @if (count($perlengkapan_ekstras) != 0)
                            <div class="mt-4">
                                {{ $perlengkapan_ekstras->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                paging: false,
                sortable: true
            });
        }
    </script>
</x-app-guru-layout>

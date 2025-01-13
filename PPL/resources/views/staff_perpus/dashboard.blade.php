<x-staffperpustakaan-layout>
    @php
        $ColorPack = [
            'lg:bg-blue-300 text-blue-950',
            'lg:bg-green-300 text-green-950',
            'lg:bg-red-300 text-red-950',
            'lg:bg-indigo-300 text-indigo-950',
            'lg:bg-amber-300 text-amber-950',
        ];
    @endphp
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <div class="overview_staffperpustakaan font-[Poppins] px-16 py-4 bg-white m-4 drop-shadow-sm rounded-md">
        @include('staff_perpus/komponen/chart_transaction')

        <div class="w-full py-6 md:block xl:flex">
            <div class="mr-1 xl:w-[40%] md:w-full">@include('staff_perpus/komponen/chart_statbuku')</div>
            <div class="flex xl:w-[60%] md:w-full">
                <div class="w-1/2 mx-3 md:w-full" style="width: 50% !important">@include('staff_perpus/komponen/overviewtabelbuku')</div>
                <div class="w-1/2 ml-2 md:w-full" style="width: 50% !important">@include('staff_perpus/komponen/overviewtabelkategori')</div>
            </div>
        </div>

        <h1 class="font-bold text-xl leading-8">Transaksi Peminjaman</h1>
        <span class="text-[#6B7280] text-lg leading-8 mb-10">Last 7 Transaction</span>


        <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Aktivitas
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tanggal Peminjam
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tanggal Kembali
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Judul Buku
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $tp)
                        @php
                            $Nama_Peminjam = isset($tp->nama_guru) ? $tp->nama_guru : $tp->nama_siswa;
                        @endphp
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $tp->nama_kategori ?? 'Buku' }} dipinjam oleh
                                <b>{{ $Nama_Peminjam ?? 'nama peminjam' }}</b>
                            </th>
                            <td class="px-6 py-4">
                                {{ date_format(date_create($tp->tgl_awal_peminjaman), 'M d, Y') ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ date_format(date_create($tp->tgl_pengembalian), 'M d, Y') ?? 'Tidak ada batas kembali' }}
                                {{-- <a href="#">Edit</a> --}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $tp->judul_buku ?? 'Judul Buku' }}
                            </td>
                            <td class="px-6 py-4 text-lg text-black">
                                {{ $tp->nama_kategori ?? 'Tidak Memiliki Kategori' }}
                            </td>
                            @php
                                if ($tp->status_pengembalian == 0) {
                                    $BgStatus = $ColorPack[0];
                                    $status = 'Sedang di Pinjam';
                                } elseif ($tp->status_pengembalian == 1) {
                                    $BgStatus = $ColorPack[1];
                                    $status = 'Sudah di Kembalikan';
                                } elseif ($tp->status_pengembalian == 2) {
                                    $BgStatus = $ColorPack[2];
                                    $status = 'Buku Hilang';
                                } else {
                                    $BgStatus = $ColorPack[2];
                                    $status = 'Belum Bayar Denda';
                                }
                            @endphp
                            <td class="px-6 py-4">
                                <span class="bold py-1 px-4 rounded-full {{ $BgStatus }}">
                                    {{ $status ?? 'None' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-end py-5 px-6">
                <a href="{{ route('staff_perpus.transaksi.daftartransaksi') }}"
                    class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                    More...
                    <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </a>
            </div>
        </div>

    </div>
</x-staffperpustakaan-layout>

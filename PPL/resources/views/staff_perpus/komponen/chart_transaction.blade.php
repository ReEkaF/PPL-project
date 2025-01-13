@php

    $dates = [];
    $borrowersOnThatDate = [];
    $jumlah_peminjam = 0;

    // Mendapatkan tanggal hari ini dan 7 hari yang lalu
    $today = time(); // Use time() to get the current timestamp
    $sevenDaysAgo = strtotime('-7 days', $today);

    // Membuat array untuk nama hari dari 7 hari yang lalu hingga hari ini
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    for ($i = 0; $i <= 6; $i++) {
        // Mendapatkan timestamp untuk tanggal yang dimaksud
        $date = strtotime("+$i days", $sevenDaysAgo);

        // Mendapatkan nama hari dari timestamp
        $day_name = $hari[date('w', $date)]; // Menggunakan date('w') untuk mendapatkan indeks hari (0-6)

        // Menyimpan nama hari ke dalam array
        $dates[] = $day_name;
        $borrowersOnThatDate[] = 0; // Inisialisasi dengan 0 peminjam
    }

    // Loop untuk menghitung jumlah peminjam berdasarkan tanggal transaksi
    foreach ($transactionsevendays as $trans) {
        // Mendapatkan tanggal dari transaksi
        $datetime = $trans->tgl_awal_peminjaman;
        $timestamp = strtotime($datetime); // Mengubah string tanggal ke timestamp

        // Mendapatkan nama hari dari tanggal transaksi
        $day_name = $hari[date('w', $timestamp)]; // Menggunakan 'w' untuk mendapatkan indeks hari (0-6)

        // Jika nama hari transaksi ada dalam array $dates, tambahkan peminjam
        if (in_array($day_name, $dates)) {
            $index = array_search($day_name, $dates); // Mencari index dari nama hari di $dates
            $borrowersOnThatDate[$index] += 1; // Increment jumlah peminjam pada hari tersebut
        }

        // Increment jumlah peminjam total
        $jumlah_peminjam += 1;
    }
@endphp

<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="flex justify-between">
        <div>
            <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">Transaction Overview</h5>
            <p class="text-base font-normal text-gray-500 dark:text-gray-400">book borrowers in the last 7 days</p>
        </div>
        {{-- <div
            class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
            12%
            <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 10 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 13V1m0 0L1 5m4-4 4 4" />
            </svg>
        </div> --}}
    </div>
    <div class="w-full"> <canvas id="trov-chart" width="100%" height="30vh"></canvas> </div>
    <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
        <div class="flex justify-between items-center pt-5">
            <!-- Button -->
            {{-- <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown" data-dropdown-placement="bottom"
                class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                type="button">
                Last 7 days
                <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button> --}}
            <!-- Dropdown menu -->
            {{-- <div id="lastDaysdropdown"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                            7 days</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                            30 days</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                            90 days</a>
                    </li>
                </ul>
            </div> --}}
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
@php
    $maxval = max($borrowersOnThatDate) + 100;
@endphp
<script>
    new Chart(document.getElementById("trov-chart"), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [{
                data: <?php echo json_encode($borrowersOnThatDate); ?>,
                label: "Peminjam Buku",
                borderColor: "#3e95cd",
                fill: false
            }],
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Grafik Peminjam Buku Dalam 7 Hari Terakhir'
            },
            layout: {
                padding: {
                    top: 1
                }
            },
        }
    });
</script>

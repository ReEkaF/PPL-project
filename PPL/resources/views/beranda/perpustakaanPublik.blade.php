<x-guest-layout>
    <section class="relative h-96 flex items-center justify-center text-center bg-cover bg-center" style="background-image: url({{ asset('images/beranda/perpustakaan/buku.jpg') }});">
        <div class="absolute inset-0 bg-black opacity-70"></div>
        <div class="relative z-10 text-white">
            <h1 class="text-4xl sm:text-5xl font-bold">Selamat Datang Di</h1>
            <h2 class="text-4xl sm:text-6xl font-bold mt-2 text-blue-400">Perpustakaan SMPN 2 Kamal</h2>
            <p class="text-lg mt-4 max-w-3xl mx-auto">Temukan dunia pengetahuan yang luas di Perpustakaan SMPN 2 Kamal. Kami menyediakan berbagai sumber belajar dan ruang yang tenang untuk membantu siswa belajar dan berkembang</p>
            <a href="{{ route('login') }}" class="mt-8 inline-block bg-blue-600 text-white font-semibold py-2 px-6 rounded-md hover:bg-blue-800 transition duration-300">
                Mulai Meminjam →
            </a>
        </div>
    </section>

    <section class="py-40 px-24">
        <div class="flex items-center justify-center gap-8">
            <div id="controls-carousel" class="relative w-full" data-carousel="static">
                <!-- Carousel wrapper -->
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    <!-- Item 1 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('images/beranda/perpustakaan/perpus-dalam1.jpg') }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                    </div>
                    <!-- Item 2 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                        <img src="{{ asset('images/beranda/perpustakaan/perpus-dalam2.jpg') }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                    </div>
                    <!-- Item 3 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('images/beranda/perpustakaan/perpus-dalam3.jpg') }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                    </div>
                </div>

                <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>

            <div class="text-gray-900 max-w-3xl mx-auto">
                <h1 class="text-4xl font-bold pb-8 text-blue-700">Tentang Perpustakaan</h1>
                <p>Perpustakaan kami terletak di belakang Laboratorium IPA dan menyediakan lingkungan yang tenang dan kaya sumber daya bagi siswa dan staf. Di sini, tersedia beragam buku, majalah, dan bahan referensi lainnya untuk mendukung perjalanan akademik para siswa. Perpustakaan menjadi bagian penting dari SMPN 2 Kamal, yang berperan dalam menumbuhkan minat baca dan penelitian di kalangan pelajar muda kami.</p>
                <p class="font-bold italic pt-6">"Membaca adalah jendela dunia, di mana kita bisa melihat lebih luas tanpa harus melangkahkan kaki"</p>
                <p class="italic">— René Descartes</p>
            </div>
        </div>
    </section>


    <section class="py-16">
        <h1 class="text-4xl font-bold mb-4 text-blue-700 text-center">Buku Terbaru</h1>
        <p class="text-gray-600 max-w-2xl mx-auto mb-8 text-center">Beberapa Buku terbaru yang kami sediakan</p>
        <div class="grid grid-cols-4 gap-8 md:px-8">
            @foreach ($buku as $item)
                <div class="flex bg-white p-4 rounded-lg shadow-lg gap-4">
                    <img src="{{ $item->foto_buku }}" alt="Category Image" class="w-48 h-64 object-cover rounded-md mb-4 border-black border-2">
                    <div class="py-2 flex flex-col gap-4">
                        <h3 class="text-lg font-semibold">{{ $item->judul_buku }}</h3>
                        <p class="text-sm">{{ $item->publisher_buku }}, {{ $item->tahun_terbit }}</p>
                        <p class="text-sm">{{ $item->author_buku }}</p>
                        <a href="{{ route('login') }}" class="bg-white text-blue-600 text-sm font-semibold py-2 px-4 w-[120px] rounded-md border border-blue-600 hover:bg-blue-600 hover:text-white transition duration-300">
                            Mulai Baca →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</x-guest-layout>

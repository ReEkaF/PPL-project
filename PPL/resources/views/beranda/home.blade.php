<x-guest-layout>
    <section class="bg-gray-200 py-16 scroll-smooth">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Selamat Datang di <span class="text-blue-600">SMPN 2 Kamal</span></h2>
            <p class="text-lg text-gray-600 mb-6 p-5">SMPN 2 Kamal adalah lembaga pendidikan yang tidak hanya berfokus pada pencapaian akademik, tetapi juga pada pembentukan karakter siswa yang kuat dan berintegritas. Dengan kurikulum yang didesain khusus untuk mempersiapkan siswa menghadapi tantangan masa depan, kami mengajarkan nilai-nilai moral, etika, dan empati yang menjadi dasar kehidupan bermasyarakat. Di SMPN 2 Kamal, siswa tidak hanya diajak untuk belajar secara intelektual, tetapi juga didorong untuk mengembangkan potensi kreatif dan sosial mereka dalam lingkungan yang penuh dukungan.</p>
            <p class="text-lg text-gray-600 mb-6 font-bold">Jl. Raya Telang No.3, Perumahan Telang Inda, Telang, Kec. Kamal, Kabupaten Bangkalan, Jawa Timur 69162</p>
            <a href="#main-banner" class="inline-block px-6 py-3 bg-blue-600 text-white text-lg font-semibold rounded-md hover:bg-blue-800 transition">Lihat Selengkapnya →</a>
        </div>
    </section>

    <section id="main-banner" class="relative bg-cover bg-center py-16" style="background-image: url({{ asset('images/beranda/sekolah2.jpg') }});">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative container mx-auto px-4 flex flex-col md:flex-row items-center text-white">
            <div class="w-full md:w-1/2 text-center md:text-left mb-8 md:mb-0">
                <h1 class="text-4xl font-bold">SMPN 2 Kamal</h1>
                <p class="text-lg mt-4 pr-12">Tempat kami membentuk generasi berprestasi dengan dedikasi dan bimbingan dari tenaga pengajar berpengalaman, fasilitas lengkap, dan lingkungan yang mendukung perkembangan siswa.</p>
            </div>

            <div class="w-full md:w-1/2 grid grid-cols-1 sm:grid-cols-2 gap-8">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ asset('images/beranda/perpus.jpg') }}" alt="Perpustakaan" class="w-full h-32 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Perpustakaan</h3>
                        <p class="text-gray-600 text-sm mt-2">Koleksi buku lengkap dan nyaman untuk mendukung kegiatan belajar siswa.</p>
                        <a href="{{ route('beranda.perpustakaanPublik') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-full font-semibold text-sm hover:bg-blue-800 transition">Lihat Selengkapnya →</a>
                    </div>
                </div>

                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ asset('images/beranda/tenaga-kerja.jpg') }}" alt="Tenaga Pengajar" class="w-full h-32 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Tenaga Pengajar</h3>
                        <p class="text-gray-600 text-sm mt-2">Guru-guru berpengalaman yang berdedikasi dalam mendidik siswa dengan sepenuh hati.</p>
                        <a href="{{ route('beranda.tenagaPengajarPublik') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-full font-semibold text-sm hover:bg-blue-800 transition">Lihat Selengkapnya →</a>
                    </div>
                </div>

                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ asset('images/beranda/prestasi.jpg') }}" alt="Prestasi" class="w-full h-32 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Prestasi</h3>
                        <p class="text-gray-600 text-sm mt-2">Berbagai pencapaian siswa di bidang akademik dan non-akademik.</p>
                        <a href="{{ route('beranda.prestasiPublik') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-full font-semibold text-sm hover:bg-blue-800 transition">Lihat Selengkapnya →</a>
                    </div>
                </div>

                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ asset('images/beranda/ekstra.jpg') }}" alt="Ekstrakulikuler" class="w-full h-32 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Ekstrakurikuler</h3>
                        <p class="text-gray-600 text-sm mt-2">Pilihan kegiatan ekstrakurikuler untuk mengembangkan minat dan bakat siswa.</p>
                        <a href="{{ route('ekstrakurikuler.dashboardEkstra') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-full font-semibold text-sm hover:bg-blue-800 transition">Lihat Selengkapnya →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang-kami" class="py-16 bg-gray-200">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">Tentang Kami</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white shadow-lg rounded-lg p-8">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Visi & Misi</h3>
                    <p class="text-gray-600 text-center text-base">Visi kami adalah menjadi lembaga pendidikan unggulan yang menghasilkan generasi yang tidak hanya berprestasi akademik, tetapi juga memiliki karakter yang baik. Misi kami adalah untuk menyediakan pendidikan berkualitas tinggi yang relevan dengan kebutuhan zaman, memfasilitasi pembelajaran yang aktif dan kreatif, serta membangun lingkungan yang mendukung perkembangan sosial dan emosional siswa.</p>
                </div>

                <div class="bg-white shadow-lg rounded-lg p-8">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Tujuan</h3>
                    <p class="text-gray-600 text-center text-base">Tujuan utama kami adalah untuk menciptakan sistem pendidikan yang dapat memenuhi kebutuhan dan harapan siswa, orang tua, serta masyarakat. Kami berkomitmen untuk memberikan akses pendidikan yang adil dan berkualitas, membekali siswa dengan pengetahuan dan keterampilan yang dibutuhkan di masa depan, serta mengembangkan potensi individu mereka melalui berbagai kegiatan ekstrakurikuler.</p>
                </div>

                <div class="bg-white shadow-lg rounded-lg p-8">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Sejarah</h3>
                    <p class="text-gray-600 text-center text-base">SMPN 2 Kamal didirikan pada tahun 2005 sebagai bagian dari upaya pemerintah untuk meningkatkan akses pendidikan di wilayah Kamal. Sejak awal, kami telah berkomitmen untuk memberikan pendidikan yang berkualitas, dengan fokus pada pengembangan karakter dan kemampuan akademik siswa. Dalam perjalanan kami, kami telah mencapai berbagai prestasi yang membanggakan di tingkat lokal dan nasional, serta terus berinovasi untuk memenuhi tuntutan zaman.</p>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>

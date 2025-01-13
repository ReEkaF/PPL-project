<x-staffakademik-layout>
    <div class="p-4 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Tambah Siswa ke Kelas {{ $kelas->nama_kelas }}</h1>
    </div>

    <form action="{{ route('kelas.simpanSiswa', $kelas->id_kelas) }}" method="POST" class="p-4">
        @csrf
        <div class="mb-4">
            <input type="text" id="searchInput" class="w-full p-2 border border-gray-300 rounded mb-4" placeholder="Cari siswa berdasarkan nama atau NISN" oninput="filterSiswa()">
        </div>
    
        <div id="siswaList" class="max-h-60 overflow-y-auto">
            @foreach($siswa as $siswaItem)
                <div class="flex items-center p-2 border-b siswa-item">
                    <input type="checkbox" name="siswa_ids[]" value="{{ $siswaItem->id_siswa }}" class="mr-2" onchange="moveCheckedToTop(this)">
                    <label>{{ $siswaItem->nama_siswa }} ({{ $siswaItem->nisn }})</label>
                </div>
            @endforeach
        </div>
    
        <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
        <a href="{{ route('kelas.siswa', $kelas->id_kelas) }}" class="ml-2 text-gray-500">Batal</a>
    </form>
    

    <script>
        function filterSiswa() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const siswaItems = document.querySelectorAll("#siswaList .siswa-item");
            siswaItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(input) ? "" : "none";
            });
        }

        function moveCheckedToTop(checkbox) {
            const siswaList = document.getElementById("siswaList");
            const siswaItem = checkbox.closest(".siswa-item");

            // Jika checkbox dicentang, pindahkan ke atas, jika tidak, tetap di posisi semula
            if (checkbox.checked) {
                siswaList.prepend(siswaItem);
            } else {
                // Masukkan item kembali ke akhir jika tidak dicentang
                siswaList.append(siswaItem);
            }
        }
    </script>
</x-staffakademik-layout>

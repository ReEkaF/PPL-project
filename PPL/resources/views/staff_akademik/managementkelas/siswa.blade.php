<x-staffakademik-layout>
    <div class="p-4 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Daftar Siswa {{ $kelas->nama_kelas }}</h1>

        <!-- Menampilkan nama wali kelas dan tombol edit -->
        <div class="mt-4">
            <p class="text-lg font-medium text-gray-700 dark:text-gray-300">
                @if ($kelas->waliKelas && $kelas->waliKelas->guru)
                    <strong>Wali Kelas: </strong>{{ $kelas->waliKelas->guru->nama_guru }}
                @else
                    <strong>Wali Kelas: </strong>Belum ada wali kelas
                @endif
            </p>
            <a href="{{ route('kelas.editWaliKelas', $kelas->id_kelas) }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">Edit</a>
        </div>
    </div>

    <div class="p-4 overflow-x-auto">
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <!-- Form utama untuk daftar siswa dan penghapusan massal -->
        <form id="hapusSiswaForm" action="{{ route('kelas.hapusSiswaMassal', $kelas->id_kelas) }}" method="POST">
            @csrf
            @method('DELETE')

            <!-- Wrapper untuk tombol Tambah Siswa dan Hapus Siswa Terpilih -->
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('kelas.tambahSiswa', $kelas->id_kelas) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Tambah Siswa</a>

                <!-- Tombol Hapus Siswa Terpilih -->
                <button id="hapusMassalButton" type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg" style="display: none;" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa yang dipilih?')">
                    Hapus Siswa Terpilih
                </button>
            </div>

            <!-- Daftar Siswa -->
            <table class="min-w-full bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700 mt-4">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="p-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                            <input type="checkbox" id="checkAll" class="form-checkbox text-blue-600">
                        </th>
                        <th class="p-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                        <th class="p-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Siswa</th>
                        <th class="p-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y">
                    @forelse($kelas->siswa as $index => $siswaItem)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="p-4 text-sm text-gray-500 dark:text-gray-400">
                                <input type="checkbox" name="siswa_ids[]" value="{{ $siswaItem->id_siswa }}" class="form-checkbox text-blue-600 siswa-checkbox">
                            </td>
                            <td class="p-4 text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                            <td class="p-4 text-sm text-gray-900 dark:text-white">{{ $siswaItem->nama_siswa }}</td>
                            <td class="p-4 text-sm text-gray-500 dark:text-gray-400">
                                <!-- Tombol Hapus untuk Siswa Individu -->
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="centangDanHapus('{{ $kelas->id_kelas }}', '{{ $siswaItem->id_siswa }}')">Hapus</button>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada siswa di kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
    </div>

    <script>
        const hapusMassalButton = document.getElementById('hapusMassalButton');
        const checkboxes = document.querySelectorAll('input[name="siswa_ids[]"]');
        const checkAll = document.getElementById('checkAll');

        // Fungsi untuk mengatur visibilitas tombol hapus massal
        function toggleHapusMassalButton() {
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            hapusMassalButton.style.display = anyChecked ? 'inline-block' : 'none';
        }

        // Menambahkan event listener pada semua checkbox siswa
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', toggleHapusMassalButton);
        });

        // Menandai semua checkbox dengan ID checkAll
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            toggleHapusMassalButton(); // Update visibilitas tombol saat checkAll berubah
        });

        // Fungsi untuk menandai checkbox dan submit form hapus massal
        function centangDanHapus(idKelas, idSiswa) {
            // Menampilkan konfirmasi kepada pengguna
            const konfirmasi = confirm('Apakah Anda yakin ingin menghapus siswa yang dipilih?');
            if (!konfirmasi) {
                return; // Jika pengguna membatalkan, hentikan eksekusi fungsi
            }

            // Dapatkan form hapusSiswaForm
            const form = document.getElementById('hapusSiswaForm');

            // Tambahkan ID siswa yang dipilih ke form
            const siswaIdsInput = document.createElement('input');
            siswaIdsInput.type = 'hidden';
            siswaIdsInput.name = 'siswa_ids[]'; // Memastikan ini adalah array
            siswaIdsInput.value = idSiswa; // Set nilai dengan ID siswa yang dipilih
            form.appendChild(siswaIdsInput);

            // Submit form
            form.submit();
        }

    </script>
</x-staffakademik-layout>

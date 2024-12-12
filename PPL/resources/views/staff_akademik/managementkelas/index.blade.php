<x-staffakademik-layout>
    <div class="p-4 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <div class="mb-4">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Daftar Kelas</h1>
        </div>
    </div>

    <!-- Tabel Daftar Kelas -->
    <div class="p-4 overflow-x-auto">
        <table class="min-w-full bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="p-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                    <th class="p-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Kelas</th>
                    <th class="p-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Jumlah Siswa</th>
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800 divide-y">
                @forelse($kelas as $index => $class)
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="p-4 text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                    <td class="p-4 text-sm text-gray-900 dark:text-white">
                        <a href="{{ route('kelas.siswa', $class->id_kelas) }}" class="text-blue-600 hover:underline">{{ $class->nama_kelas }}</a>
                    </td>
                    <td class="text-blue-600 ">{{ $class->siswa_count }}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-staffakademik-layout>

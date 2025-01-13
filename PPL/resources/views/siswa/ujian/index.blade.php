<x-siswa-layout>
    <div class="p-2 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        {{-- @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                ['label' => 'UJIAN', 'route' => route('siswa.dashboard.ujian')],
            ];
        @endphp --}}

        {{-- <x-breadcrumb :breadcrumbs="$breadcrumbs" /> --}}
    </div>

    {{-- Main Content --}}
    <div class="p-6 bg-white rounded shadow">
        <h2 class="text-lg font-bold text-gray-800">Daftar Ujian</h2>
        <table class="w-full mt-4 border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border border-gray-300">Judul</th>
                    <th class="p-2 border border-gray-300">Deskripsi</th>
                    <th class="p-2 border border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ujians as $ujian)
                <tr>
                    <td class="p-2 border border-gray-300">{{ $ujian->judul }}</td>
                    <td class="p-2 border border-gray-300">{{ $ujian->deskripsi }}</td>
                    <td class="p-2 border border-gray-300">
                        <button onclick="openModal()" class="text-yellow-500">Baca Aturan</button>
                        <a href="{{ route('siswa.ujian.start', $ujian->id_ujian) }}" class="text-blue-500">Mulai Ujian</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-2 text-center border border-gray-300">Tidak ada ujian tersedia</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-75">
        <div class="p-6 bg-white rounded shadow-md w-96">
            <h2 class="text-lg font-bold text-gray-800">Aturan Ujian</h2>
            <ul class="mt-4 text-sm text-gray-600 list-disc list-inside">
                <li>Pastikan koneksi internet stabil.</li>
                <li>Jangan menutup jendela browser selama ujian berlangsung.</li>
                <li>Kerjakan soal sesuai dengan waktu yang diberikan.</li>
                <li>Jangan melakukan kecurangan dalam bentuk apapun.</li>
            </ul>
            <div class="flex justify-end mt-6">
                <button onclick="closeModal()" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</x-siswa-layout>

<x-siswa-layout>
    <div class="p-6 bg-white rounded shadow text-center">
        <h2 class="text-2xl font-bold text-gray-800">Ujian Selesai</h2>
        <p class="mt-4 text-lg text-gray-600">Terima kasih telah mengikuti ujian.</p>

        <div class="mt-6">
            <h3 class="text-xl font-semibold text-gray-800">Rincian Ujian</h3>
            <p class="text-gray-600">Judul Ujian: <span class="font-medium">{{ $ujian->judul }}</span></p>
            <p class="text-gray-600">Waktu Selesai: <span class="font-medium">{{ now()->format('d M Y H:i') }}</span></p>
        </div>

        <div class="mt-6">
            <h3 class="text-xl font-semibold text-gray-800">Hasil Ujian</h3>
            <p class="text-gray-600">Jumlah Soal: <span class="font-medium">{{ $jumlahSoal }}</span></p>
            <p class="text-gray-600">Jawaban Benar: <span class="font-medium">{{ $jawabanBenar }}</span></p>
            <p class="text-gray-600">Skor Akhir: <span class="font-medium">{{ $nilai }}</span></p>
        </div>

        <a href="{{ route('siswa.dashboard') }}" class="inline-block px-6 py-2 mt-8 text-white bg-blue-500 rounded hover:bg-blue-600">Kembali ke Dashboard</a>
    </div>
</x-siswa-layout>

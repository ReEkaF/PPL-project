<x-siswa-layout>
    <div class="p-6 bg-white rounded shadow">
        <h2 class="text-lg font-bold text-gray-800">{{ $ujian->judul }}</h2>
        <p class="text-sm text-gray-600">Waktu Berakhir: <span id="timer"></span></p>

        <form action="{{ route('siswa.ujian.submit', $ujian->id_ujian) }}" method="POST">
            @csrf
            @foreach ($ujian->soalUjian->where('judul',$ujian->judul_ujian) as $index => $soal)
                <div class="mt-4">
                    <p class="font-medium">{{ $index + 1 }}. {{ $soal->teks_soal }}</p>
                    <div>
                        <label><input type="radio" name="jawaban_{{ $soal->id_soal_ujian }}" value="{{ $soal->opsi_a }}" required> {{ $soal->opsi_a }}</label><br>
                        <label><input type="radio" name="jawaban_{{ $soal->id_soal_ujian }}" value="{{ $soal->opsi_b }}"> {{ $soal->opsi_b }}</label><br>
                        <label><input type="radio" name="jawaban_{{ $soal->id_soal_ujian }}" value="{{ $soal->opsi_c }}"> {{ $soal->opsi_c }}</label><br>
                        <label><input type="radio" name="jawaban_{{ $soal->id_soal_ujian }}" value="{{ $soal->opsi_d }}"> {{ $soal->opsi_d }}</label>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded">Kumpulkan Jawaban</button>
        </form>
    </div>

    <script>
        const endTime = new Date("{{ $endTime }}").getTime();
        const timer = document.getElementById('timer');

        const countdown = setInterval(() => {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                clearInterval(countdown);
                alert("Waktu ujian telah habis!");
                document.querySelector('form').submit();
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            timer.textContent = `${minutes} menit ${seconds} detik`;
        }, 1000);
    </script>
</x-siswa-layout>

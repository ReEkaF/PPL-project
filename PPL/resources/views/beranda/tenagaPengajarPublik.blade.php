<x-guest-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-8">Daftar Guru Pengajar SMPN 2 Kamal</h1>

        <!-- Section Daftar Guru -->
        <section id="daftar-guru" class="mb-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach($guru as $gurus)
                <div class="border w-64 bg-white p-4 rounded-lg shadow-lg">
                    <img src="{{ $gurus->foto_guru ?? asset('images/profile-none.jpeg') }}" alt="{{ $gurus->nama_guru }}" class="w-64 h-56 object-cover rounded-lg mb-4">
                    <h3 class="text-center text-lg font-medium text-gray-800">{{ $gurus->nama_guru }}</h3>
                    <p class="text-center text-gray-600">{{ $gurus->gurumatapelajaran->first()->mataPelajaran->nama_matpel ?? " "}}</p>
                </div>
                @endforeach
            </div>
        </section>

    </div>
</x-guest-layout>

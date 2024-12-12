<x-siswa-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold">Beranda Perpustakaan</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <!-- Search and Filter -->
                    <div class="flex items-center justify-between mb-6">
                        <form action="{{ route('dashboard.perpustakaan') }}" method="GET" class="flex w-full gap-4">
                            @csrf
                            <input type="text" name="search" placeholder="Cari Judul Buku"
                                class="border border-gray-300 rounded-lg px-4 py-2 w-300"
                                value="{{ old('search', request('search')) }}" />
                            <select name="kategori_buku" class="border border-gray-300 rounded-lg px-4 py-2 w-200"
                                onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id_kategori_buku }}"
                                        {{ old('kategori_buku', request('kategori_buku')) == $cat->id_kategori_buku ? 'selected' : '' }}>
                                        {{ $cat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <!-- Book List -->
                    @if ($pages->isEmpty())
                        <h3 class="text-center text-lg font-semibold">Buku yang anda cari tidak ada well</h3>
                    @else
                        <div class="flex flex-wrap gap-4">
                            @foreach ($pages as $buku)
                                <div
                                    class="w-[200px] h-[500px] bg-white p-4 rounded-lg shadow-md flex flex-col justify-between">
                                    <div>
                                        <img src="{{ asset($buku->foto_buku) }}" alt="{{ $buku->judul_buku }}"
                                            class="w-full h-[250px] rounded-md object-cover mb-4">
                                        <h3 class="text-lg font-semibold overflow-hidden text-ellipsis"
                                            style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                            {{ $buku->judul_buku }}
                                        </h3>
                                        <p class="text-gray-600 mt-2">Stok: {{ $buku->stok_buku }}</p>
                                    </div>
                                    <a href="{{ route('siswa.dashboard.perpustakaan.detail', $buku->id_buku) }}"
                                        class="mt-auto bg-blue-500 text-white rounded-full px-4 py-2 text-center">
                                        Detail
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @php
        $paginator = $pages;
        $marginX = 'mx-52';
    @endphp
    @include('staff_perpus/komponen/pagination')
</x-siswa-layout>

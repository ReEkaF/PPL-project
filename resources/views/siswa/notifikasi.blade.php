<x-siswa-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                ['label' => 'Notifikasi'],
            ];
        @endphp

        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2">
            {{-- Materi --}}
            <div>
            <h3 class="text-lg font-semibold leading-tight text-gray-800">Materi</h3>
            <ul class="mt-4 space-y-4">

                @foreach ($materi as $item)

                <li class="p-4 rounded-lg shadow {{ $item->status == 0 ? 'bg-gray-100' : 'bg-white' }}">
                    <div class="flex justify-between">
                    <div>
                        <a href="{{ route('siswa.dashboard.lms.detail.materi', ['id' => $item->materi->id_materi]) }}" class="text-sm font-medium text-blue-600 hover:underline">{{ $item->materi->judul_materi }}</a>
                        <p class="text-sm text-gray-500">{{ Str::limit($item->materi->deskripsi, 50) }}</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $item->created_at->diffForHumans() }}
                    </div>
                    </div>
                </li>
                @endforeach
            </ul>
            </div>

            {{-- Tugas --}}
            <div>
            <h3 class="text-lg font-semibold leading-tight text-gray-800">Tugas</h3>
            <ul class="mt-4 space-y-4">
                @php
                $tugas = [
                    (object)[
                    'judul' => 'Tugas 1',
                    'deskripsi' => 'Matematika 7A',
                    'created_at' => now()->subDays(1)
                    ],
                    (object)[
                    'judul' => 'Tugas 2',
                    'deskripsi' => 'Bahasa Indonesia 7A',
                    'created_at' => now()->subDays(4)
                    ],
                ];
                @endphp

                @foreach ($tugas as $item)
                <li class="p-4 bg-gray-100 rounded-lg shadow">
                    <div class="flex justify-between">
                    <div>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:underline">{{ $item->judul }}</a>
                        <p class="text-sm text-gray-500">{{ $item->deskripsi }}</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $item->created_at->diffForHumans() }}
                    </div>
                    </div>
                </li>
                @endforeach
            </ul>
            </div>
        </div>
    </div>
</x-siswa-layout>

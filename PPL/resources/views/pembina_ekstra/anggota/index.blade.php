<x-app-guru-layout>
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header & Breadcrumbs --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs">
                        <li class="inline-flex items-center">
                            <a href="{{ route('guru.dashboard') }}" class="text-slate-500 hover:text-brand-800 transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-house text-[11px]"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-500">Ekstrakurikuler</span>
                        </li>
                        <li class="flex items-center text-slate-800 font-semibold">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span>Data Anggota</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Anggota Ekstrakurikuler {{ $ekstrakurikuler }}</h1>
                <p class="text-xs text-slate-500">
                    Daftar siswa yang terdaftar dan aktif dalam kegiatan ekstrakurikuler binaan Anda.
                </p>
            </div>
        </div>

        {{-- Overview Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div>
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Pembina Ekstra</span>
                    <p class="font-bold text-slate-800 text-sm mt-0.5">{{ auth()->guard('web-guru')->user()->nama_guru }}</p>
                </div>
                <div>
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Nama Ekstrakurikuler</span>
                    <p class="font-bold text-brand-900 text-sm mt-0.5">{{ $ekstrakurikuler }}</p>
                </div>
                <div>
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Total Anggota Terdaftar</span>
                    <p class="font-bold text-emerald-700 text-sm mt-0.5">
                        <i class="fa-solid fa-users text-xs mr-1"></i>{{ $totalItems }} Siswa
                    </p>
                </div>
            </div>
        </div>

        {{-- Tabel Data Anggota --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center text-xs font-bold">
                        <i class="fa-solid fa-id-card"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Daftar Anggota</h2>
                        <p class="text-xs text-slate-500">Seluruh siswa yang mengikuti ekstrakurikuler</p>
                    </div>
                </div>
            </div>

            <div class="p-5">
                <table class="w-full text-xs text-left" id="search-table">
                    <thead class="text-[11px] text-slate-500 uppercase bg-slate-50/80 border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-4 py-3 font-semibold text-center w-12">No</th>
                            <th scope="col" class="px-4 py-3 font-semibold">Nama Siswa</th>
                            <th scope="col" class="px-4 py-3 font-semibold">NISN</th>
                            <th scope="col" class="px-4 py-3 font-semibold">Alamat</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($members as $index => $member)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-4 py-3 text-center font-bold text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-900">{{ $member->name }}</td>
                                <td class="px-4 py-3 font-mono text-slate-600">{{ $member->nisn ?: '-' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $member->address ?: '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ strtolower($member->status) === 'diterima' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                        {{ $member->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-400 text-xs">
                                    <i class="fa-solid fa-users-slash text-xl mb-1 text-slate-300 block"></i>
                                    Belum ada data anggota yang terdaftar untuk ekstrakurikuler ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById("search-table") && typeof simpleDatatables !== 'undefined' && typeof simpleDatatables.DataTable !== 'undefined') {
                new simpleDatatables.DataTable("#search-table", {
                    searchable: true,
                    paging: false,
                    sortable: true
                });
            }
        });
    </script>
</x-app-guru-layout>

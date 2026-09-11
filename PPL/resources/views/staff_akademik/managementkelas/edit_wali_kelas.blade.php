<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
        {{-- Flash Messages --}}
        @if(session('error'))
            <div class="flex items-center justify-between p-4 text-xs font-medium text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-xmark text-sm text-rose-600"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        {{-- Header & Breadcrumbs --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs">
                        <li class="inline-flex items-center">
                            <a href="{{ route('staff_akademik.dashboard') }}" class="text-slate-500 hover:text-brand-800 transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-house text-[11px]"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <a href="{{ route('daftarkelas') }}" class="text-slate-500 hover:text-brand-800 transition-colors">Manajemen Rombel</a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <a href="{{ route('kelas.siswa', $kelas->id_kelas) }}" class="text-slate-500 hover:text-brand-800 transition-colors">Kelas {{ $kelas->nama_kelas }}</a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Edit Wali Kelas</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tetapkan Wali Kelas {{ $kelas->nama_kelas }}</h1>
                <p class="text-xs text-slate-500">
                    Pilih tenaga pendidik yang akan ditugaskan membimbing rombongan belajar ini.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('kelas.siswa', $kelas->id_kelas) }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Kelas</span>
                </a>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="max-w-xl bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/40 flex items-center justify-between">
                <div>
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Formulir Penugasan Wali Kelas</h2>
                    <p class="text-[11px] text-slate-500 mt-0.5">Penugasan ini akan berlaku untuk seluruh siswa di kelas {{ $kelas->nama_kelas }}.</p>
                </div>
                <div class="w-8 h-8 rounded-lg bg-brand-50 border border-brand-100 text-brand-800 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
            </div>

            <form action="{{ route('kelas.updateWaliKelas', $kelas->id_kelas) }}" method="POST" class="p-5 sm:p-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Status Wali Kelas Saat Ini --}}
                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200/80 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-white border border-slate-200 text-slate-600 flex items-center justify-center font-bold text-xs">
                        <i class="fa-solid fa-id-badge text-slate-400"></i>
                    </div>
                    <div>
                        <div class="text-[11px] text-slate-500 font-medium">Wali Kelas Saat Ini</div>
                        <div class="text-xs font-bold text-slate-900 mt-0.5">
                            @if ($kelas->waliKelas && $kelas->waliKelas->guru)
                                {{ $kelas->waliKelas->guru->nama_guru }}
                                <span class="text-slate-500 font-normal font-mono">(NIP: {{ $kelas->waliKelas->guru->nip ?? '-' }})</span>
                            @else
                                <span class="text-amber-600">Belum ada wali kelas yang ditugaskan</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Dropdown Pilih Guru --}}
                <div>
                    <label for="wali_kelas" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Pilih Guru Wali Kelas Baru
                    </label>
                    <select name="wali_kelas" id="wali_kelas" required
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                        <option value="">-- Pilih Tenaga Pendidik --</option>
                        @foreach($gurus as $guru)
                            @php
                                $isCurrent = $kelas->waliKelas && $kelas->waliKelas->wali_kelas == $guru->id_guru;
                            @endphp
                            <option value="{{ $guru->id_guru }}" {{ $isCurrent ? 'selected' : '' }}>
                                {{ $guru->nama_guru }} (NIP: {{ $guru->nip ?? '-' }}) {{ $isCurrent ? '— (Saat Ini)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-slate-500 mt-1.5">
                        Hanya menampilkan guru yang belum menjadi wali kelas di rombel lain serta wali kelas saat ini.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 border-t border-slate-100 flex items-center gap-2.5">
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white shadow-sm transition-colors">
                        <i class="fa-solid fa-check text-[11px]"></i>
                        <span>Simpan Wali Kelas</span>
                    </button>
                    <a href="{{ route('kelas.siswa', $kelas->id_kelas) }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-xs font-medium bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-staffakademik-layout>

<x-staffakademik-layout>
    <div class="space-y-6 pb-10">
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
                            <a href="{{ route('prestasi.index') }}" class="text-slate-500 hover:text-brand-800 transition-colors">Prestasi Siswa</a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Tambah Prestasi</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tambah Rekam Prestasi Siswa</h1>
                <p class="text-xs text-slate-500">
                    Dokumentasikan piagam kejuaraan, sertifikat penghargaan, atau prestasi akademik/non-akademik siswa.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('prestasi.index') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Daftar</span>
                </a>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="max-w-2xl bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/40">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Formulir Rekam Prestasi</h2>
            </div>
            <form action="{{ route('prestasi.store') }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-6 space-y-4">
                @csrf
                <div>
                    <label for="siswa_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Siswa Penerima Prestasi</label>
                    <select id="siswa_id" name="siswa_id" required
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id_siswa }}" {{ old('siswa_id') == $s->id_siswa ? 'selected' : '' }}>
                                {{ $s->nama_siswa }} (NISN: {{ $s->nisn ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                    @error('siswa_id')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_prestasi" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Prestasi / Kejuaraan</label>
                    <input type="text" id="nama_prestasi" name="nama_prestasi" value="{{ old('nama_prestasi') }}" required
                        placeholder="Contoh: Juara 1 Olimpiade Sains Nasional Tingkat Kabupaten"
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                    @error('nama_prestasi')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bukti_prestasi" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Berkas Piagam / Sertifikat Bukti
                        <span class="text-slate-400 font-normal">(Opsional, JPG/PNG/PDF max 2MB)</span>
                    </label>
                    <input type="file" id="bukti_prestasi" name="bukti_prestasi" accept="image/*,.pdf"
                        class="block w-full text-xs text-slate-600 bg-white border border-slate-200 rounded-lg file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                    @error('bukti_prestasi')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi_prestasi" class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Lengkap Prestasi</label>
                    <textarea id="deskripsi_prestasi" name="deskripsi_prestasi" rows="4" required
                        placeholder="Uraikan rincian capaian, penyelenggara, tingkatan lomba, serta tanggal perolehan prestasi..."
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors">{{ old('deskripsi_prestasi') }}</textarea>
                    @error('deskripsi_prestasi')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                    <a href="{{ route('prestasi.index') }}"
                        class="px-4 py-2 text-xs font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-medium text-white bg-brand-800 hover:bg-brand-900 rounded-lg shadow-sm transition-colors">
                        <i class="fa-solid fa-check text-[11px]"></i>
                        <span>Simpan Prestasi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-staffakademik-layout>
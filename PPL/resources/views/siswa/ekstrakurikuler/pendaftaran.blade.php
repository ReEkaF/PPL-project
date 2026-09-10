<x-siswa-layout>
    <div class="space-y-6 max-w-4xl mx-auto">
        {{-- Breadcrumb Nav --}}
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('siswa.dashboard') }}" class="hover:text-brand-800 transition-colors">Dashboard</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <a href="{{ route('siswa.ekstrakurikuler.index') }}" class="hover:text-brand-800 transition-colors">Ekstrakurikuler</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <span class="text-slate-800 font-semibold">Formulir Pendaftaran</span>
        </div>

        {{-- Header Card --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-800 flex items-center justify-center shrink-0 text-xl border border-brand-100">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <div class="space-y-1">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900">Pendaftaran Ekstrakurikuler</h1>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Lengkapi formulir berikut untuk mendaftarkan diri pada kegiatan ekstrakurikuler pilihanmu. Pastikan data yang dimasukkan benar dan lengkap.
                    </p>
                </div>
            </div>

            @if (isset($errors) && $errors->any())
                <div class="mt-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                    <p class="font-bold flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>Mohon periksa kembali formulir Anda:</span>
                    </p>
                    <ul class="list-disc list-inside space-y-0.5 text-rose-700 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- Form Card --}}
        <form method="POST" action="{{ route('siswa.ekstrakurikuler.pendaftaran.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Seksi 1: Data Pribadi Siswa --}}
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-800 text-white flex items-center justify-center text-xs">1</span>
                        <span>Data Diri Siswa</span>
                    </h2>
                    <span class="text-xs text-slate-400">Otomatis Terisi dari Data Akun</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" value="{{ $siswa->nama_siswa }}" readonly
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-600 font-medium cursor-not-allowed">
                    </div>

                    {{-- NISN --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">NISN</label>
                        <input type="text" value="{{ $siswa->nisn }}" readonly
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-600 font-medium cursor-not-allowed">
                    </div>

                    {{-- Kelas --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kelas</label>
                        <input type="text" value="{{ $siswa->kelas->first()->nama_kelas ?? 'Kelas Siswa' }}" readonly
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-600 font-medium cursor-not-allowed">
                    </div>

                    {{-- No HP Siswa --}}
                    <div>
                        <label for="no_hp" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Telepon / WhatsApp Siswa</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                            placeholder="Contoh: 081234567890"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-brand-700 focus:border-brand-700 transition">
                    </div>

                    {{-- No HP Orang Tua --}}
                    <div>
                        <label for="no_hp_orangtua" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Telepon / WhatsApp Orang Tua / Wali</label>
                        <input type="text" name="no_hp_orangtua" id="no_hp_orangtua" value="{{ old('no_hp_orangtua') }}"
                            placeholder="Contoh: 081987654321"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-brand-700 focus:border-brand-700 transition">
                    </div>

                    {{-- Riwayat Penyakit --}}
                    <div>
                        <label for="riwayat_penyakit" class="block text-xs font-semibold text-slate-700 mb-1.5">Riwayat Penyakit (Bila Ada)</label>
                        <input type="text" name="riwayat_penyakit" id="riwayat_penyakit" value="{{ old('riwayat_penyakit') }}"
                            placeholder="Tuliskan jika ada (misal: Asma, Alergi, dsb.) atau kosongkan"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-brand-700 focus:border-brand-700 transition">
                    </div>
                </div>

                {{-- Alasan Memilih Ekskul --}}
                <div>
                    <label for="alasan_ekskul" class="block text-xs font-semibold text-slate-700 mb-1.5">Alasan / Motivasi Mengikuti Ekstrakurikuler</label>
                    <textarea name="alasan_ekskul" id="alasan_ekskul" rows="2"
                        placeholder="Ceritakan minat atau motivasi kamu mengikuti kegiatan ini..."
                        class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-brand-700 focus:border-brand-700 transition">{{ old('alasan_ekskul') }}</textarea>
                </div>
            </div>

            {{-- Seksi 2: Pemilihan Ekstrakurikuler --}}
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-800 text-white flex items-center justify-center text-xs">2</span>
                        <span>Pilih Ekstrakurikuler</span>
                    </h2>
                    <span class="text-xs text-brand-800 font-semibold">Maksimal 3 Pilihan</span>
                </div>

                @if ($ekstrakurikulerList->isEmpty())
                    <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl text-center">
                        <i class="fa-solid fa-door-closed text-slate-400 text-3xl mb-2"></i>
                        <p class="text-xs sm:text-sm font-semibold text-slate-700">Saat ini belum ada ekstrakurikuler yang membuka pendaftaran.</p>
                        <p class="text-xs text-slate-400 mt-1">Silakan pantau kembali berkala atau tanyakan pada pembina.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach ($ekstrakurikulerList as $ekstra)
                            @php
                                $isRegistered = in_array($ekstra->id_ekstrakurikuler, $registeredEkstraIds);
                                $isChecked = (is_array(old('pilih_ekskul')) && in_array($ekstra->id_ekstrakurikuler, old('pilih_ekskul'))) || ($selectedId === $ekstra->id_ekstrakurikuler);
                            @endphp
                            <label class="relative flex flex-col p-4 rounded-2xl border transition-all cursor-pointer select-none {{ $isRegistered ? 'bg-slate-100/70 border-slate-200 opacity-60 cursor-not-allowed' : ($isChecked ? 'bg-brand-50/50 border-brand-700 shadow-sm' : 'bg-white border-slate-200 hover:border-slate-300 hover:bg-slate-50/50') }}">
                                <div class="flex items-start justify-between gap-2">
                                    <span class="text-sm font-bold text-slate-900">{{ $ekstra->nama_ekstrakurikuler }}</span>
                                    <input type="checkbox" name="pilih_ekskul[]" value="{{ $ekstra->id_ekstrakurikuler }}"
                                        {{ $isChecked ? 'checked' : '' }}
                                        {{ $isRegistered ? 'disabled' : '' }}
                                        class="w-4 h-4 rounded text-brand-800 focus:ring-brand-700 border-slate-300">
                                </div>
                                <span class="text-[11px] text-slate-500 mt-2 line-clamp-2">
                                    {{ $ekstra->deskripsi }}
                                </span>
                                @if ($ekstra->rentang_pendaftaran_formatted)
                                    <span class="mt-2 inline-flex items-center gap-1.5 text-[10px] font-medium text-brand-800 bg-brand-50 px-2 py-0.5 rounded-md self-start">
                                        <i class="fa-solid fa-calendar-days text-[9px]"></i>
                                        <span>{{ $ekstra->rentang_pendaftaran_formatted }}</span>
                                    </span>
                                @endif
                                @if ($isRegistered)
                                    <span class="mt-3 inline-flex items-center gap-1 text-[10px] font-bold text-amber-600">
                                        <i class="fa-solid fa-circle-info"></i> Sudah Terdaftar
                                    </span>
                                @endif
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Seksi 3: Berkas Pendukung (Opsional) --}}
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-800 text-white flex items-center justify-center text-xs">3</span>
                        <span>Berkas Pendukung</span>
                    </h2>
                    <span class="text-xs text-slate-400">Opsional (Format PDF / JPG / PNG, Maks 25MB)</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Surat Izin Orang Tua --}}
                    <div>
                        <label for="surat_izin_orang_tua" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Surat Izin Orang Tua / Wali
                        </label>
                        <input type="file" name="surat_izin_orang_tua" id="surat_izin_orang_tua"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-800 hover:file:bg-brand-100 cursor-pointer border border-slate-200 rounded-xl">
                        <p class="text-[10px] text-slate-400 mt-1">Unggah scan/foto formulir izin orang tua bila ada.</p>
                    </div>

                    {{-- Surat Keterangan Dokter --}}
                    <div>
                        <label for="surat_keterangan_dokter" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Surat Keterangan Sehat / Dokter
                        </label>
                        <input type="file" name="surat_keterangan_dokter" id="surat_keterangan_dokter"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-800 hover:file:bg-brand-100 cursor-pointer border border-slate-200 rounded-xl">
                        <p class="text-[10px] text-slate-400 mt-1">Unggah surat sehat khusus ekskul fisik/olahraga.</p>
                    </div>
                </div>
            </div>

            {{-- Submit Bar --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('siswa.ekstrakurikuler.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-brand-800 hover:bg-brand-900 text-white rounded-xl text-xs sm:text-sm font-bold shadow-md shadow-brand-950/10 transition-all duration-200 hover:scale-105 active:scale-95 inline-flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Pendaftaran</span>
                </button>
            </div>
        </form>
    </div>
</x-siswa-layout>

<x-app-guru-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('guru.daftarSiswaWali') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-800 transition-colors mb-2">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Daftar Siswa</span>
                </a>
                <h1 class="text-xl font-bold text-slate-900">Profil Siswa</h1>
                <p class="text-sm text-slate-500 mt-0.5">Informasi biodata siswa di kelas perwalian Anda</p>
            </div>
        </div>

        {{-- Profile Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            
            {{-- Banner Header --}}
            <div class="h-28 bg-gradient-to-r from-brand-800 to-brand-950 relative"></div>

            {{-- Avatar & Identity --}}
            <div class="px-6 pb-6 pt-0 relative">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 -mt-12 mb-6">
                    <div class="flex items-end gap-4">
                        <div class="w-24 h-24 rounded-2xl bg-white p-1 shadow-md shrink-0">
                            <div class="w-full h-full rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center">
                                @if (!empty($siswa->foto_siswa))
                                    <img src="{{ asset('images/siswa/' . $siswa->foto_siswa) }}" alt="{{ $siswa->nama_siswa }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-user text-slate-400 text-3xl"></i>
                                @endif
                            </div>
                        </div>
                        <div class="pb-1">
                            <div class="flex items-center gap-2">
                                <h2 class="text-xl font-bold text-slate-900">{{ $siswa->nama_siswa }}</h2>
                                @if (strtolower($siswa->jenis_kelamin_siswa ?? '') === 'laki-laki')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/60">
                                        <i class="fa-solid fa-mars text-[10px]"></i> Laki-laki
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/60">
                                        <i class="fa-solid fa-venus text-[10px]"></i> Perempuan
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 font-mono mt-0.5">NISN: {{ $siswa->nisn ?? '-' }}</p>
                        </div>
                    </div>

                    @if (!empty($siswa->nomor_wa_siswa))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siswa->nomor_wa_siswa) }}" target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-colors shadow-sm self-start sm:self-auto">
                            <i class="fa-brands fa-whatsapp text-sm text-emerald-600"></i>
                            <span>Hubungi Orang Tua/Siswa</span>
                        </a>
                    @endif
                </div>

                {{-- Detail Fields Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100 text-xs">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Nomor Induk Siswa Nasional (NISN)</span>
                        <p class="font-mono font-bold text-slate-800 text-sm">{{ $siswa->nisn ?? '-' }}</p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Tanggal Lahir</span>
                        <p class="font-semibold text-slate-800 text-sm">
                            {{ !empty($siswa->tgl_lahir_siswa) ? \Carbon\Carbon::parse($siswa->tgl_lahir_siswa)->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Nomor Kontak / WhatsApp</span>
                        <p class="font-semibold text-slate-800 text-sm">{{ $siswa->nomor_wa_siswa ?? '-' }}</p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Email Siswa</span>
                        <p class="font-semibold text-slate-800 text-sm">{{ $siswa->email ?? 'Belum ada email terdaftar' }}</p>
                    </div>

                    <div class="sm:col-span-2 p-3.5 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Alamat Lengkap</span>
                        <p class="font-semibold text-slate-800 text-sm leading-relaxed">{{ $siswa->alamat_siswa ?? 'Belum ada alamat' }}</p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-guru-layout>

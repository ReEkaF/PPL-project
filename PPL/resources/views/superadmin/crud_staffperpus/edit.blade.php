<x-admin-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Breadcrumbs & Header -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                <a href="{{ route('superadmin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="{{ route('superadmin.kelola_staff_perpus') }}" class="hover:text-slate-900 transition-colors">Staff Perpustakaan</a>
                <span>/</span>
                <span class="text-slate-700 font-medium">Edit Data Staff</span>
            </nav>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Akun Staff Perpustakaan</h1>
            <p class="text-sm text-slate-500 mt-1">Perbarui data profil petugas perpustakaan yang bersangkutan</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <form action="{{ route('superadmin.kelola_staff_perpus.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" id="id_staff_perpustakaan" name="id_staff_perpustakaan" value="{{ $staffperpustakaan->id_staff_perpustakaan }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Username <span class="text-rose-500">*</span></label>
                        <input type="text" id="username" name="username" value="{{ old('username', $staffperpustakaan->username) }}"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="Username akun petugas" required>
                        @error('username')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $staffperpustakaan->email) }}"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="petugas@sekolah.sch.id" required>
                        @error('email')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Staff Perpustakaan -->
                    <div>
                        <label for="nama_staff_perpustakaan" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" id="nama_staff_perpustakaan" name="nama_staff_perpustakaan" value="{{ old('nama_staff_perpustakaan', $staffperpustakaan->nama_staff_perpustakaan) }}"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="Nama lengkap petugas perpus" required>
                        @error('nama_staff_perpustakaan')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor WA -->
                    <div>
                        <label for="wa_staff_perpustakaan" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp</label>
                        <input type="text" id="wa_staff_perpustakaan" name="wa_staff_perpustakaan" value="{{ old('wa_staff_perpustakaan', $staffperpustakaan->wa_staff_perpustakaan) }}"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 font-mono focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="08xxxxxxxxxx">
                        @error('wa_staff_perpustakaan')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-2">
                        <label for="alamat_staff_perpustakaan" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                        <textarea id="alamat_staff_perpustakaan" name="alamat_staff_perpustakaan" rows="3"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="Alamat domisili petugas">{{ old('alamat_staff_perpustakaan', $staffperpustakaan->alamat_staff_perpustakaan) }}</textarea>
                        @error('alamat_staff_perpustakaan')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit & Cancel Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('superadmin.kelola_staff_perpus') }}"
                        class="px-4 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-[#06466C] hover:bg-[#053a5a] rounded-lg shadow-sm transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

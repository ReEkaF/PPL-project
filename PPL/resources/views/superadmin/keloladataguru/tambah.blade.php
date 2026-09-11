<x-admin-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Breadcrumbs & Header -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                <a href="{{ route('superadmin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="{{ route('superadmin.keloladataguru') }}" class="hover:text-slate-900 transition-colors">Kelola Data Guru</a>
                <span>/</span>
                <span class="text-slate-700 font-medium">Tambah Data</span>
            </nav>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Tambah Data Guru Baru</h1>
            <p class="text-sm text-slate-500 mt-1">Lengkapi formulir untuk menambahkan akun dan data tenaga pendidik</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Username <span class="text-rose-500">*</span></label>
                        <input type="text" name="username" id="username"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('username') }}" placeholder="Username akun guru" required>
                        @error('username')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Password <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" id="password"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="Minimal 6 karakter" required>
                        @error('password')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Guru -->
                    <div>
                        <label for="nama_guru" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_guru" id="nama_guru"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('nama_guru') }}" placeholder="Nama beserta gelar" required>
                        @error('nama_guru')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIP -->
                    <div>
                        <label for="nip" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">NIP <span class="text-rose-500">*</span></label>
                        <input type="text" name="nip" id="nip"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 font-mono focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('nip') }}" placeholder="18 digit NIP" required>
                        @error('nip')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Guru -->
                    <div>
                        <label for="role_guru" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Peran Guru <span class="text-rose-500">*</span></label>
                        <select name="role_guru" id="role_guru"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors" required>
                            <option value="">Pilih Role</option>
                            <option value="guru" {{ old('role_guru') == 'guru' ? 'selected' : '' }}>Guru Pengajar</option>
                            <option value="pembina" {{ old('role_guru') == 'pembina' ? 'selected' : '' }}>Pembina Ekstrakurikuler</option>
                            <option value="wali_kelas" {{ old('role_guru') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                        </select>
                        @error('role_guru')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" id="email"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('email') }}" placeholder="email@sekolah.sch.id" required>
                        @error('email')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No. WA -->
                    <div>
                        <label for="nomor_wa_guru" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">No. WhatsApp</label>
                        <input type="text" name="nomor_wa_guru" id="nomor_wa_guru"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 font-mono focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('nomor_wa_guru') }}" placeholder="08xxxxxxxxxx">
                        @error('nomor_wa_guru')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto Guru Upload -->
                    <div>
                        <label for="foto_guru" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Foto Profil</label>
                        <input type="file" name="foto_guru" id="foto_guru"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3 py-2 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#06466C]/10 file:text-[#06466C] hover:file:bg-[#06466C]/20 cursor-pointer focus:outline-none"
                            accept="image/*">
                        @error('foto_guru')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-2">
                        <label for="alamat_guru" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                        <textarea name="alamat_guru" id="alamat_guru" rows="3"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="Alamat domisili guru">{{ old('alamat_guru') }}</textarea>
                        @error('alamat_guru')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit & Cancel Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('superadmin.keloladataguru') }}"
                        class="px-4 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-[#06466C] hover:bg-[#053a5a] rounded-lg shadow-sm transition-colors">
                        Simpan Data Guru
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

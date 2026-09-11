<x-admin-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Breadcrumbs & Header -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                <a href="{{ route('superadmin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="{{ route('superadmin.keloladataguru') }}" class="hover:text-slate-900 transition-colors">Kelola Data Guru</a>
                <span>/</span>
                <span class="text-slate-700 font-medium">Edit Data</span>
            </nav>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Data Guru</h1>
            <p class="text-sm text-slate-500 mt-1">Perbarui akun dan profil pengajar "{{ $guru->nama_guru }}"</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <form action="{{ route('guru.update', $guru->id_guru) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Photo Thumbnail -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-lg bg-slate-50 border border-slate-200">
                    <img src="{{ $guru->foto_guru ? asset('images/guru/' . $guru->foto_guru) : 'https://cdn.pixabay.com/photo/2018/11/13/21/43/avatar-3814049_640.png' }}"
                        alt="{{ $guru->nama_guru }}"
                        class="w-16 h-16 rounded-full object-cover border border-slate-200 shadow-sm">
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Perbarui Foto Profil</label>
                        <p class="text-xs text-slate-500 mb-2">Biarkan kosong jika tidak ingin mengubah foto saat ini.</p>
                        <input type="file" name="foto_guru" id="foto_guru"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3 py-1.5 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#06466C]/10 file:text-[#06466C] hover:file:bg-[#06466C]/20 cursor-pointer focus:outline-none bg-white"
                            accept="image/*">
                        @error('foto_guru')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Username <span class="text-rose-500">*</span></label>
                        <input type="text" name="username" id="username"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('username', $guru->username) }}" required>
                        @error('username')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            placeholder="Kosongkan jika tidak diubah">
                        @error('password')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Guru -->
                    <div>
                        <label for="nama_guru" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_guru" id="nama_guru"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('nama_guru', $guru->nama_guru) }}" required>
                        @error('nama_guru')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIP -->
                    <div>
                        <label for="nip" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">NIP <span class="text-rose-500">*</span></label>
                        <input type="text" name="nip" id="nip"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 font-mono focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('nip', $guru->nip) }}" required>
                        @error('nip')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Guru -->
                    <div>
                        <label for="role_guru" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Peran Guru <span class="text-rose-500">*</span></label>
                        <select name="role_guru" id="role_guru"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors" required>
                            <option value="guru" {{ old('role_guru', $guru->role_guru) == 'guru' ? 'selected' : '' }}>Guru Pengajar</option>
                            <option value="pembina" {{ old('role_guru', $guru->role_guru) == 'pembina' ? 'selected' : '' }}>Pembina Ekstrakurikuler</option>
                            <option value="wali_kelas" {{ old('role_guru', $guru->role_guru) == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
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
                            value="{{ old('email', $guru->email) }}" required>
                        @error('email')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No. WA -->
                    <div>
                        <label for="nomor_wa_guru" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">No. WhatsApp</label>
                        <input type="text" name="nomor_wa_guru" id="nomor_wa_guru"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 font-mono focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors"
                            value="{{ old('nomor_wa_guru', $guru->nomor_wa_guru) }}">
                        @error('nomor_wa_guru')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-2">
                        <label for="alamat_guru" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                        <textarea name="alamat_guru" id="alamat_guru" rows="3"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors">{{ old('alamat_guru', $guru->alamat_guru) }}</textarea>
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
                        Perbarui Data Guru
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

<x-admin-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Breadcrumbs & Header -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                <a href="{{ route('superadmin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="{{ route('superadmin.keloladatapengurus') }}" class="hover:text-slate-900 transition-colors">Pengurus Ekstrakurikuler</a>
                <span>/</span>
                <span class="text-slate-700 font-medium">Edit Pengurus</span>
            </nav>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Data Pengurus Ekstrakurikuler</h1>
            <p class="text-sm text-slate-500 mt-1">Perbarui penetapan ekstrakurikuler atau status peran siswa yang bersangkutan</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <form action="{{ route('data.pengurus.update', $pengurus->id_siswa) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <!-- Nama Pengurus -->
                    <div>
                        <label for="nama_siswa" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nama Siswa <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_siswa" id="nama_siswa" value="{{ old('nama_siswa', $pengurus->nama_siswa) }}"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors" required>
                        @error('nama_siswa')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role_siswa" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Peran Siswa <span class="text-rose-500">*</span></label>
                        <select id="role_siswa" name="role_siswa"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors" required>
                            <option value="pengurus" {{ old('role_siswa', $pengurus->role_siswa) == 'pengurus' ? 'selected' : '' }}>Pengurus Ekstrakurikuler</option>
                            <option value="siswa" {{ old('role_siswa', $pengurus->role_siswa) == 'siswa' ? 'selected' : '' }}>Siswa Reguler</option>
                        </select>
                        @error('role_siswa')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ekstrakurikuler -->
                    <div>
                        <label for="ekstrakurikuler" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Penugasan Ekstrakurikuler <span class="text-rose-500">*</span></label>
                        <select name="ekstrakurikuler" id="ekstrakurikuler"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#06466C]/20 focus:border-[#06466C] transition-colors" required>
                            @foreach($ekstrakurikuler as $ekstrakurikulerItem)
                                <option value="{{ $ekstrakurikulerItem->id_ekstrakurikuler }}" {{ $pengurus->id_ekstrakurikuler == $ekstrakurikulerItem->id_ekstrakurikuler ? 'selected' : '' }}>
                                    {{ $ekstrakurikulerItem->nama_ekstrakurikuler }}
                                </option>
                            @endforeach
                        </select>
                        @error('ekstrakurikuler')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit & Cancel Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('superadmin.keloladatapengurus') }}"
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

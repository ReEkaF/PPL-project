<x-siswa-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Page Header & Status Registrasi --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-brand-50 border border-brand-200 text-xs font-semibold text-brand-800 mb-1">
                        <span>Portal Pengurus Ekstrakurikuler</span>
                    </div>
                    @if ($ekstra && $ekstra->ekstrakurikuler)
                        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                            {{ $ekstra->ekstrakurikuler->nama_ekstrakurikuler }}
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500">
                            Kelola publikasi warta kegiatan dan status pendaftaran anggota ekstrakurikuler.
                        </p>
                    @else
                        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                            Dashboard Pengurus Ekstrakurikuler
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500">
                            Akun Anda belum terhubung dengan ekstrakurikuler aktif.
                        </p>
                    @endif
                </div>

                @if ($ekstra && $ekstra->ekstrakurikuler)
                    <div class="flex flex-wrap items-center gap-3">
                        <form id="statusForm" method="post" action="{{ route('dashboard.status') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" id="statusInput"
                                value="{{ $rilStatus == 'tidak buka' ? 'buka' : 'tidak buka' }}">
                            <button type="button" id="toggleButton" onclick="handleToggle(event)"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-semibold transition-colors {{ $rilStatus == 'tidak buka' ? 'bg-brand-800 hover:bg-brand-900 text-white' : 'bg-white hover:bg-rose-50 text-rose-700 border border-rose-300' }}">
                                {{ $rilStatus == 'tidak buka' ? 'Buka Registrasi' : 'Tutup Registrasi' }}
                            </button>
                        </form>

                        <button onclick="toggleCreateModal()"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-brand-800 hover:bg-brand-900 text-white rounded-lg text-xs font-semibold transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Buat Postingan</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Confirmation Modal --}}
        <div id="confirmationModal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4">
            <div class="bg-white rounded-xl border border-slate-200 p-6 w-full max-w-md space-y-4">
                <h3 class="text-base font-bold text-slate-900">Konfirmasi Status Registrasi</h3>
                <p class="text-sm text-slate-600">
                    Apakah Anda yakin ingin mengubah status pendaftaran ekstrakurikuler ini?
                </p>
                <div class="flex justify-end gap-2.5 pt-2">
                    <button onclick="closeModal()"
                        class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-lg text-xs font-semibold transition-colors">
                        Batal
                    </button>
                    <button onclick="confirmAction()"
                        class="px-4 py-2 bg-brand-800 hover:bg-brand-900 text-white rounded-lg text-xs font-semibold transition-colors">
                        Ya, Ubah
                    </button>
                </div>
            </div>
        </div>

        @if ($ekstra && $ekstra->ekstrakurikuler)
            {{-- Notifications --}}
            @if (session('success'))
                <div class="p-3.5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Modal Create Postingan --}}
            <div id="createModal"
                class="hidden fixed inset-0 z-50 bg-slate-900/40 flex justify-center items-center p-4">
                <div class="bg-white rounded-xl border border-slate-200 p-6 w-full max-w-lg space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <h3 class="text-base font-bold text-slate-900">Buat Postingan Baru</h3>
                        <button type="button" onclick="toggleCreateModal()" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
                    </div>
                    <form action="{{ route('dashboard.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="space-y-1">
                            <label for="judul" class="block text-xs font-semibold text-slate-700">Judul Postingan</label>
                            <input type="text" name="judul" id="judul" required
                                placeholder="Masukkan judul kegiatan"
                                class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:border-brand-800 focus:ring-1 focus:ring-brand-800 outline-none">
                        </div>
                        <div class="space-y-1">
                            <label for="gambar" class="block text-xs font-semibold text-slate-700">Foto Dokumentasi</label>
                            <input type="file" name="gambar" id="gambar" accept="image/*" required
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-800 hover:file:bg-brand-100">
                        </div>
                        <div class="space-y-1">
                            <label for="deskripsi" class="block text-xs font-semibold text-slate-700">Deskripsi Kegiatan</label>
                            <input id="deskripsi" type="hidden" name="deskripsi">
                            <trix-editor input="deskripsi"
                                class="border border-slate-300 rounded-lg min-h-[120px] focus:border-brand-800 focus:ring-1 focus:ring-brand-800 text-sm"></trix-editor>
                        </div>
                        <div class="flex justify-end gap-2.5 pt-3 border-t border-slate-100">
                            <button type="button" onclick="toggleCreateModal()"
                                class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-lg text-xs font-semibold transition-colors">
                                Tutup
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-brand-800 hover:bg-brand-900 text-white rounded-lg text-xs font-semibold transition-colors">
                                Simpan Postingan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Daftar Postingan Section --}}
            <div class="bg-white border border-slate-200 rounded-xl p-6">
                <div class="mb-5">
                    <h2 class="text-base font-bold text-slate-900">Daftar Warta Postingan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Postingan yang tampil di portal ekstrakurikuler publik.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($postings as $index => $posting)
                        <div class="border border-slate-200 rounded-xl p-4 bg-white flex flex-col justify-between hover:border-brand-700 transition">
                            <div class="space-y-2">
                                <h3 class="text-sm font-bold text-slate-900 line-clamp-2">
                                    {{ Str::limit($posting->judul, 60) }}
                                </h3>
                                <p class="text-xs text-slate-500">
                                    Diupload: {{ \Carbon\Carbon::parse($posting->tgl_uploud)->format('d M Y H:i') }}
                                </p>
                                <p class="text-xs text-slate-500">
                                    Pengurus: <span class="font-medium text-slate-700">{{ $uplouders[$index]->nama_siswa ?? 'Siswa' }}</span>
                                </p>
                            </div>

                            <div class="flex items-center justify-between pt-3 mt-3 border-t border-slate-100 text-xs font-medium">
                                <button data-modal-target="edit-{{ $index }}" data-modal-toggle="edit-{{ $index }}"
                                    class="text-brand-800 hover:text-brand-900 font-semibold">
                                    Edit
                                </button>
                                <form action="{{ route('dashboard.destroy', $posting->id_posting) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus postingan ini?')"
                                        class="text-rose-600 hover:text-rose-800 font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Edit Modal per Posting --}}
                        <div id="edit-{{ $index }}" tabindex="-1" aria-hidden="true"
                            class="hidden fixed inset-0 z-50 flex justify-center items-center bg-slate-900/40 p-4">
                            <div class="relative bg-white rounded-xl border border-slate-200 w-full max-w-lg p-6 space-y-4">
                                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                    <h3 class="text-base font-bold text-slate-900">
                                        Edit Postingan Ekstrakurikuler
                                    </h3>
                                    <button type="button" class="text-slate-400 hover:text-slate-600 text-sm" data-modal-hide="edit-{{ $index }}">✕</button>
                                </div>
                                <form action="{{ route('dashboard.update', ['id_posting' => $posting->id_posting]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-1">
                                        <label class="block text-xs font-semibold text-slate-700">Judul Postingan</label>
                                        <input type="text" name="judul" value="{{ $posting->judul }}" required
                                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:border-brand-800 focus:ring-1 focus:ring-brand-800 outline-none">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-semibold text-slate-700">Ganti Gambar (Opsional)</label>
                                        <input type="file" name="gambar" accept="image/*"
                                            class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-800">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-semibold text-slate-700">Deskripsi</label>
                                        <input id="editDeskripsi-{{ $index }}" type="hidden" name="deskripsi" value="{{ $posting->deskripsi }}">
                                        <trix-editor input="editDeskripsi-{{ $index }}"
                                            class="border border-slate-300 rounded-lg min-h-[120px] focus:border-brand-800 focus:ring-1 focus:ring-brand-800 text-sm"></trix-editor>
                                    </div>
                                    <div class="flex justify-end gap-2.5 pt-3 border-t border-slate-100">
                                        <button type="button" data-modal-hide="edit-{{ $index }}"
                                            class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-lg text-xs font-semibold transition-colors">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-brand-800 hover:bg-brand-900 text-white rounded-lg text-xs font-semibold transition-colors">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10 bg-slate-50 rounded-xl border border-slate-200">
                            <p class="text-sm text-slate-500">Belum ada postingan warta kegiatan untuk ekstrakurikuler ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

    </div>

    <script>
        function toggleCreateModal() {
            const modal = document.getElementById('createModal');
            if (modal) modal.classList.toggle('hidden');
        }

        function handleToggle(event) {
            event.preventDefault();
            const modal = document.getElementById('confirmationModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('confirmationModal');
            if (modal) modal.classList.add('hidden');
        }

        function confirmAction() {
            const form = document.getElementById('statusForm');
            if (form) form.submit();
            closeModal();
        }
    </script>
</x-siswa-layout>

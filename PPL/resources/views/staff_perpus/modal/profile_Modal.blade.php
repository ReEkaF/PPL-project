<!-- Main modal -->
<div id="edit-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/50 backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-slate-100 bg-slate-50/50">
                <div>
                    <h3 class="text-base font-bold text-slate-900">
                        Edit Profil Petugas
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi identitas staf perpustakaan.</p>
                </div>
                <button type="button"
                    class="text-slate-400 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-lg text-xs w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors"
                    data-modal-toggle="edit-modal">
                    <i class="fa-solid fa-xmark text-sm"></i>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('staff_perpus.editprofile') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label for="edit_nama" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="nama" id="edit_nama"
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                        value="{{ $staff_account->nama_staff_perpustakaan }}" required />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_user" class="block text-xs font-semibold text-slate-700 mb-1.5">Username</label>
                        <input type="text" name="user" id="edit_user"
                            class="block w-full text-xs font-mono text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                            value="{{ $staff_account->username }}" required />
                    </div>
                    <div>
                        <label for="edit_email" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                        <input type="email" name="email" id="edit_email"
                            class="block w-full text-xs font-mono text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                            value="{{ $staff_account->email }}" required />
                    </div>
                </div>
                <div>
                    <label for="edit_alamat" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Rumah</label>
                    <textarea name="alamat" id="edit_alamat" rows="2"
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                        required>{{ $staff_account->alamat_staff_perpustakaan }}</textarea>
                </div>
                <div>
                    <label for="edit_no_wa" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor WhatsApp</label>
                    <input type="text" name="no_wa" id="edit_no_wa"
                        class="block w-full text-xs font-mono text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                        value="{{ $staff_account->wa_staff_perpustakaan }}" required />
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" data-modal-toggle="edit-modal"
                        class="px-3.5 py-2 text-xs font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-medium text-white bg-brand-800 hover:bg-brand-900 rounded-lg shadow-sm transition-colors">
                        <i class="fa-solid fa-check text-[11px]"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

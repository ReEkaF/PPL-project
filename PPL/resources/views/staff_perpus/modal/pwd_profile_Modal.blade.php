<!-- Main modal -->
<div id="pwd-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/50 backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-slate-100 bg-slate-50/50">
                <div>
                    <h3 class="text-base font-bold text-slate-900">
                        Ubah Kata Sandi
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pastikan kata sandi baru minimal 8 karakter.</p>
                </div>
                <button type="button"
                    class="text-slate-400 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-lg text-xs w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors"
                    data-modal-toggle="pwd-modal">
                    <i class="fa-solid fa-xmark text-sm"></i>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('staff_perpus.editpwdprofile') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label for="pwd_opwd" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Lama</label>
                    <input type="password" name="opwd" id="pwd_opwd"
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                        placeholder="Masukkan kata sandi lama" required />
                </div>
                <div>
                    <label for="pwd_npwd" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                    <input type="password" name="npwd" id="pwd_npwd"
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                        placeholder="Minimal 8 karakter" required />
                </div>
                <div>
                    <label for="pwd_rpwd" class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="rpwd" id="pwd_rpwd"
                        class="block w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-colors"
                        placeholder="Ulangi kata sandi baru" required />
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" data-modal-toggle="pwd-modal"
                        class="px-3.5 py-2 text-xs font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-medium text-white bg-brand-800 hover:bg-brand-900 rounded-lg shadow-sm transition-colors">
                        <i class="fa-solid fa-key text-[11px]"></i>
                        <span>Perbarui Kata Sandi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

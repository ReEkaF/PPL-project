<x-staffperpustakaan-layout>
    @include('staff_perpus/modal/profile_Modal')
    @include('staff_perpus/modal/pwd_profile_Modal')

    <div class="space-y-6 pb-10">
        {{-- Header & Breadcrumbs --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs">
                        <li class="inline-flex items-center">
                            <a href="{{ route('staff_perpus.dashboard') }}" class="text-slate-500 hover:text-brand-800 transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-house text-[11px]"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-right text-[10px] mx-1"></i>
                            <span class="text-slate-800 font-medium">Profil Petugas</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Profil Akun Perpustakaan</h1>
                <p class="text-xs text-slate-500">
                    Informasi identitas akun petugas sirkulasi dan kredensial akses perpustakaan.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button data-modal-target="edit-modal" data-modal-toggle="edit-modal" type="button"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium bg-brand-800 hover:bg-brand-900 text-white transition-colors shadow-sm">
                    <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                    <span>Edit Profil</span>
                </button>
            </div>
        </div>

        {{-- Detail Card --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
                <div class="w-14 h-14 rounded-xl bg-brand-50 text-brand-800 border border-brand-100/60 flex items-center justify-center text-xl font-bold font-mono shrink-0">
                    {{ substr($staff_account->nama_staff_perpustakaan ?? 'P', 0, 1) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">{{ $staff_account->nama_staff_perpustakaan }}</h2>
                    <p class="text-xs text-slate-500 font-mono">{{ $staff_account->email }}</p>
                </div>
            </div>

            <dl class="divide-y divide-slate-100 text-xs">
                <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <dt class="font-medium text-slate-500">Nama Lengkap</dt>
                    <dd class="sm:col-span-2 font-semibold text-slate-800">{{ $staff_account->nama_staff_perpustakaan }}</dd>
                </div>
                <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <dt class="font-medium text-slate-500">Username</dt>
                    <dd class="sm:col-span-2 font-mono text-slate-800">{{ $staff_account->username }}</dd>
                </div>
                <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <dt class="font-medium text-slate-500">Alamat Email</dt>
                    <dd class="sm:col-span-2 font-mono text-slate-800">{{ $staff_account->email }}</dd>
                </div>
                <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <dt class="font-medium text-slate-500">Alamat Rumah</dt>
                    <dd class="sm:col-span-2 text-slate-800">{{ $staff_account->alamat_staff_perpustakaan ?: '-' }}</dd>
                </div>
                <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <dt class="font-medium text-slate-500">Nomor Telepon / WhatsApp</dt>
                    <dd class="sm:col-span-2 font-mono text-slate-800">{{ $staff_account->wa_staff_perpustakaan ?: '-' }}</dd>
                </div>
                <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                    <dt class="font-medium text-slate-500">Kata Sandi</dt>
                    <dd class="sm:col-span-2 flex items-center justify-between">
                        <span class="font-mono text-slate-400">••••••••••••</span>
                        <button data-modal-target="pwd-modal" data-modal-toggle="pwd-modal" id="pwd-modal-trigger"
                            type="button"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors shadow-sm">
                            <i class="fa-solid fa-key text-[10px]"></i>
                            <span>Ubah Kata Sandi</span>
                        </button>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</x-staffperpustakaan-layout>

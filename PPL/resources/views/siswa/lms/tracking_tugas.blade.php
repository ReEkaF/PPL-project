<x-siswa-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                ['label' => 'LMS', 'route' => route('siswa.dashboard.lms')],
                ['label' => 'Tracking Tugas'],
            ];
        @endphp

        <x-breadcrumb :breadcrumbs="$breadcrumbs" />


        {{-- Main Content --}}
        <div class="px-3">
            {{-- Tabs --}}
            <div class="flex gap-2 mb-4 mt-6">
                <x-nav-button-lms route="siswa.dashboard.lms.tracking.tugas.ditugaskan" label="Ditugaskan" />

                <x-nav-button-lms route="siswa.dashboard.lms.tracking.tugas.belum_diserahkan" label="Belum Diserahkan" />

                <x-nav-button-lms route="siswa.dashboard.lms.tracking.tugas.diserahkan" label="Selesai" />

            </div>
        </div>
    </div>


</x-siswa-layout>

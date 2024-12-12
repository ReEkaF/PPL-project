<x-staffakademik-layout>
    <div class="p-4 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Wali Kelas untuk {{ $kelas->nama_kelas }}</h1>
    </div>

    <div class="p-4">
        
        <form action="{{ route('kelas.updateWaliKelas', $kelas->id_kelas) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="wali_kelas" class="block text-sm font-medium text-gray-700">Pilih Wali Kelas</label>
                <select name="wali_kelas" id="wali_kelas" class="form-select mt-1 block w-full">
                    
                    @foreach($gurus as $guru)

                        <option value="{{ $guru->id_guru }}" {{ $kelas->waliKelas && $kelas->waliKelas->id == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama_guru }}
                        </option>
                        
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Simpan Wali Kelas
            </button>
        </form>
    </div>
</x-staffakademik-layout>

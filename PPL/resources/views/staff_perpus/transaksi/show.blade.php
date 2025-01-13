<x-staffperpustakaan-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Detail Transaksi</h1>

        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold mb-4">Peminjam: {{ $transaction->kode_peminjam }}</h2>

            <form action="{{ route('staff.transactions.confirm', $transaction->id) }}" method="POST">
                @csrf
                <table class="w-full border text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Judul Buku</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalDenda = 0; @endphp
                        @foreach($transaction->books as $book)
                            @php $totalDenda += $book->pivot->denda; @endphp
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $book->title }}</td>
                                <td class="px-4 py-2">
                                    <select name="books[{{ $book->id }}]" class="border border-gray-300 rounded p-2">
                                        <option value="aman" {{ $book->pivot->status === 'aman' ? 'selected' : '' }}>Aman</option>
                                        <option value="telat" {{ $book->pivot->status === 'telat' ? 'selected' : '' }}>Telat</option>
                                        <option value="hilang" {{ $book->pivot->status === 'hilang' ? 'selected' : '' }}>Hilang</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Total Denda:</label>
                    <input type="text" value="Rp. {{ number_format($totalDenda, 0, ',', '.') }}" class="border border-gray-300 rounded-lg p-2 w-full" readonly>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('pengembalian.show') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg mr-2">Kembali</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Selesaikan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</x-staffperpustakaan-layout>

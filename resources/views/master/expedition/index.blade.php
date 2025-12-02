@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">🚚 Database Ekspedisi</h2>
            <button onclick="openModal()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                ➕ Tambah Data
            </button>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-blue-600 text-white sticky top-0 z-10">
                    <tr>
                        <th class="p-3 text-left text-sm font-semibold">Nama Ekspedisi</th>
                        <th class="p-3 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($expeditions as $expedition)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $expedition->expedition }}</td>
                        <td class="p-3 text-center">
                            <button class="px-3 py-1 bg-red-600 text-white rounded-md text-xs hover:bg-red-700">
                                🗑️ Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center p-4 text-gray-500">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal --}}
<div id="addModal" class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-[999]">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Tambah Ekspedisi</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-red-600">✕</button>
        </div>

        <form>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Ekspedisi</label>
                <input type="text" class="w-full border rounded-lg p-2" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700">
                Simpan
            </button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addModal').classList.add('hidden');
    }
</script>

@endsection
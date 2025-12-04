@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">🏢 Database Cabang</h2>
            <button onclick="openModal()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                ➕ Tambah Cabang
            </button>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-blue-600 text-white sticky top-0 z-10">
                    <tr>
                        <th class="p-3 text-left text-sm font-semibold">Nama Cabang</th>
                        <th class="p-3 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($branches as $branch)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $branch->plant}}</td>
                        <td class="p-3 text-center">
                            <button onclick='openEditPlantModal(@json($branch))'
                                class="px-3 py-1 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600">
                                ✏️ Edit
                            </button>

                            <!-- Delete -->
                            <form action="{{ route('plants.destroy', $branch->uuid) }}" method="POST" class="inline"
                                onsubmit="return confirm('Hapus cabang ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 text-white rounded-md text-xs hover:bg-red-700">
                                    🗑️ Hapus
                                </button>
                            </form>
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
            <h3 class="text-lg font-bold">Tambah Cabang</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-red-600">✕</button>
        </div>

        <form action="{{ route('plants.store') }}" method="POST">
            @csrf

            {{-- NAMA CABANG --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Cabang</label>
                <input type="text" name="plant" class="w-full border rounded-lg p-2" required>
                @error('plant')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ABBREVIATION --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Abbrivation</label>
                <input type="text" name="abbrivation" class="w-full border rounded-lg p-2" placeholder="Contoh: SLTG" required>
                @error('abbrivation')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700">
                Simpan
            </button>
        </form>

    </div>
</div>

<div id="editPlantModal" class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-[999]">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Edit Cabang</h3>
            <button onclick="closeEditPlantModal()" class="text-gray-500 hover:text-red-600">✕</button>
        </div>

        <form id="editPlantForm" method="POST">
            @csrf
            @method('PUT')

            {{-- NAMA CABANG --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Cabang</label>
                <input type="text" id="edit_plant_name" name="plant" class="w-full border rounded-lg p-2" required>
            </div>

            {{-- ABBREVIATION --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Abbrivation</label>
                <input type="text" id="edit_plant_abbr" name="abbrivation" class="w-full border rounded-lg p-2" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700">
                Update
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

    function openEditPlantModal(plant) {
        document.getElementById('editPlantForm').action = '/plants/' + plant.uuid;
        document.getElementById('edit_plant_name').value = plant.plant;
        document.getElementById('edit_plant_abbr').value = plant.abbrivation;
        document.getElementById('editPlantModal').classList.remove('hidden');
        document.getElementById('editPlantModal').classList.add('flex');
    }

    function closeEditPlantModal() {
        document.getElementById('editPlantModal').classList.add('hidden');
    }
</script>

@endsection
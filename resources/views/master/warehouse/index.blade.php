@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">📦 Database Gudang</h2>
            <button onclick="openModal()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                ➕ Tambah Data
            </button>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-blue-600 text-white sticky top-0">
                    <tr>
                        <th class="p-3 text-left text-sm font-semibold">Nama Gudang</th>
                        <th class="p-3 text-left text-sm font-semibold">Cabang</th>
                        <th class="p-3 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($warehouses as $warehouse)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $warehouse->warehouse }}</td>
                        <td class="p-3 text-sm">{{ $warehouse->plant->plant }}</td>
                        <td class="p-3 text-center">
                            <button onclick='openEditWarehouseModal(@json($warehouse))'
                                class="px-3 py-1 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600">
                                ✏️ Edit
                            </button>

                            <!-- Delete -->
                            <form action="{{ route('warehouses.destroy', $warehouse->uuid) }}" method="POST" class="inline"
                                onsubmit="return confirm('Hapus gudang ini?')">
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
                        <td colspan="3" class="text-center p-4 text-gray-500">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal --}}
<div id="addModal" class="fixed inset-0 bg-black/40 hidden flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md mx-4">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Tambah Gudang</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-red-600">✕</button>
        </div>

        <form action="{{ route('warehouses.store') }}" method="POST">
            @csrf

            {{-- NAMA GUDANG --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Gudang</label>
                <input type="text" name="warehouse" class="w-full border rounded-lg p-2" required>

                @error('warehouse')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- CABANG --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cabang</label>
                <select name="plant_uuid" class="w-full border rounded-lg p-2" required>
                    <option value="">Pilih Cabang</option>
                    @foreach ($branches as $branch)
                    <option value="{{ $branch->uuid }}">{{ $branch->plant }}</option>
                    @endforeach
                </select>

                @error('plant_uuid')
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

<div id="editWarehouseModal" class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-[999]">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Edit Gudang</h3>
            <button onclick="closeEditWarehouseModal()" class="text-gray-500 hover:text-red-600">✕</button>
        </div>

        <form id="editWarehouseForm" method="POST">
            @csrf
            @method('PUT')

            {{-- NAMA GUDANG --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Gudang</label>
                <input type="text" id="edit_warehouse_name" name="warehouse" class="w-full border rounded-lg p-2" required>
            </div>

            {{-- CABANG --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cabang</label>
                <select id="edit_warehouse_plant" name="plant_uuid" class="w-full border rounded-lg p-2" required>
                    <option value="">Pilih Cabang</option>
                    @foreach ($branches as $branch)
                    <option value="{{ $branch->uuid }}">{{ $branch->plant }}</option>
                    @endforeach
                </select>
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

    function openEditWarehouseModal(warehouse) {
        document.getElementById('editWarehouseForm').action = '/warehouses/' + warehouse.uuid;
        document.getElementById('edit_warehouse_name').value = warehouse.warehouse;
        document.getElementById('edit_warehouse_plant').value = warehouse.plant_uuid;
        document.getElementById('editWarehouseModal').classList.remove('hidden');
        document.getElementById('editWarehouseModal').classList.add('flex');
    }

    function closeEditWarehouseModal() {
        document.getElementById('editWarehouseModal').classList.add('hidden');
    }
</script>

@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">👤 Database Departemen</h2>
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
                        <th class="p-3 text-left text-sm font-semibold">Nama Departemen</th>
                        <th class="p-3 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $dept)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $dept->department }}</td>
                        <td class="p-3 text-center">
                            <button
                                class="px-3 py-1 bg-yellow-500 text-white rounded-md text-xs hover:bg-yellow-600"
                                onclick="openEditModal('{{ $dept->uuid }}', '{{ $dept->department }}', '{{ $dept->abbrivation }}')">
                                ✏️ Edit
                            </button>

                            <!-- Form Hapus -->
                            <form action="{{ route('departments.destroy', $dept->uuid) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus departemen ini?')" class="inline">
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
                        <td colspan="7" class="text-center p-4 text-gray-500">Belum ada data</td>
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
            <h3 class="text-lg font-bold">Tambah Departemen</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-red-600">✕</button>
        </div>

        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Departemen</label>
                <input type="text" name="department" class="w-full border rounded-lg p-2" required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700">
                Simpan
            </button>
        </form>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-[999]">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Edit Departemen</h3>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-red-600">✕</button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Departemen</label>
                <input type="text" id="edit_department" name="department" class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Abbreviation</label>
                <input type="text" id="edit_abbrivation" name="abbrivation" class="w-full border rounded-lg p-2">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700">
                Update
            </button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('addModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('addModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById("checkAllPlants").addEventListener("change", function() {
        const checkboxes = document.querySelectorAll('input[name="plant_uuid[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    function openEditModal(uuid, department, abbr) {
        document.getElementById("edit_department").value = department;
        document.getElementById("edit_abbrivation").value = abbr ?? '';

        document.getElementById("editForm").action =
            "/departments/" + uuid + "/update";

        document.getElementById("editModal").classList.remove("hidden");
    }

    function closeEditModal() {
        document.getElementById("editModal").classList.add("hidden");
    }
</script>

@endsection
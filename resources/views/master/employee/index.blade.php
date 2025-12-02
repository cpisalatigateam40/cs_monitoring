@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">👤 Database Karyawan</h2>
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
                        <th class="p-3 text-left text-sm font-semibold">Nama Karyawan</th>
                        <th class="p-3 text-left text-sm font-semibold">Departemen</th>
                        <th class="p-3 text-left text-sm font-semibold">Jabatan</th>
                        <th class="p-3 text-center text-sm font-semibold">Role</th>
                        <th class="p-3 text-left text-sm font-semibold">Username</th>
                        <th class="p-3 text-center text-sm font-semibold">Akses Cabang</th>
                        <th class="p-3 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $emp)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $emp->name }}</td>
                        <td class="p-3 text-sm">{{ $emp->department->department->department }}</td>
                        <td class="p-3 text-sm">{{ $emp->title }}</td>
                        <td class="p-3 text-sm text-center">
                            @foreach ($user->roles as $role)
                            <span class="px-2 py-1 rounded-full text-xs font-medium">
                                {{ $role->name }}
                            </span>
                            @endforeach
                        </td>
                        <td class="p-3 text-sm">{{ $emp->username }}</td>
                        <td class="p-3 text-sm text-center">
                            @foreach($emp->plants as $emp_plant)
                            {{$emp_plant->plant->plant}}
                            @endforeach
                        </td>
                        <td class="p-3 text-center">
                            <button class="px-3 py-1 bg-red-600 text-white rounded-md text-xs hover:bg-red-700">
                                🗑️ Hapus
                            </button>
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
            <h3 class="text-lg font-bold">Tambah Karyawan</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-red-600">✕</button>
        </div>

        <form>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
                <input type="text" class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Departemen</label>
                <input type="text" class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                <input type="text" class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select class="w-full border rounded-lg p-2" required>
                    <option value="">Pilih Role</option>
                    <option value="superadmin">superadmin</option>
                    <option value="input_shipment">input_shipment</option>
                    <option value="input_all">input_all</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Akses Cabang</label>
                <input type="text" class="w-full border rounded-lg p-2" placeholder="Pisahkan dengan koma, atau 'all'"
                    required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700">
                Simpan
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
</script>

@endsection
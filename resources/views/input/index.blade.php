@extends('layouts.app')

@section('content')
@if (session('success'))
<div class="mb-6 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800">
    <strong>✔ Berhasil:</strong> {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="mb-6 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800">
    <strong>✘ Gagal:</strong> {{ session('error') }}
</div>
@endif

@if ($errors->any())
<div class="mb-6 p-4 rounded-lg bg-yellow-100 border border-yellow-300 text-yellow-800">
    <strong>⚠ Terjadi kesalahan:</strong>
    <ul class="mt-2 list-disc pl-5">
        @foreach ($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="max-w-7xl mx-auto px-6 py-6 grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Form Gudang --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">📦 Input Data Suhu Gudang</h2>

        <form action="{{ route('warehouse-temperature.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Nama Gudang</label>
                <select class="w-full border rounded-md p-2" name="warehouse_uuid" required>
                    <option value="">Pilih Gudang</option>
                    @foreach ($warehouses as $w)
                    <option value="{{ $w->uuid }}">{{ $w->warehouse }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Data Suhu & Waktu Pencatatan</label>

                <div id="dynamicFields" class="space-y-3">
                    <div class="flex gap-3 items-center single-row">
                        <input type="number" name="temperature[]" step="0.1"
                            class="w-full border rounded-md p-2" placeholder="Suhu (°C)" required>

                        <input type="datetime-local" name="time[]"
                            class="w-full border rounded-md p-2" required>

                        <button type="button"
                            class="removeRow bg-red-500 text-white px-3 py-2 rounded-md hidden">
                            ✖
                        </button>
                    </div>
                </div>

                <button type="button" onclick="addRow()"
                    class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-md">
                    + Tambah Baris
                </button>
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold">
                Simpan Data Gudang
            </button>
        </form>
        <button onclick="openModal('warehouseModal')"
            class="px-4 py-2 bg-green-600 text-white rounded shadow mt-3">
            📥 Import Excel
        </button>
    </div>

    {{-- Form Ekspedisi --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">🚚 Input Data Pengiriman</h2>

        <form action="{{ route('deliveries.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Expedition --}}
            <div>
                <label class="block text-sm font-medium mb-1">Nama Ekspedisi</label>
                <select name="expedition_uuid" class="w-full border rounded-md p-2" required>
                    <option value="">Pilih Ekspedisi</option>
                    @foreach ($expeditions as $e)
                    <option value="{{ $e->uuid }}">{{ $e->expedition }}</option>
                    @endforeach
                </select>
            </div>

            {{-- License Plate --}}
            <div>
                <label class="block text-sm font-medium mb-1">Nomor Plat Kendaraan</label>
                <input type="text" name="license_plate" class="w-full border rounded-md p-2" required>
            </div>

            {{-- Destination --}}
            <div>
                <label class="block text-sm font-medium mb-1">Tujuan Pengiriman</label>
                <input type="text" name="destination" class="w-full border rounded-md p-2" required>
            </div>

            {{-- Start Time --}}
            <div>
                <label class="block text-sm font-medium mb-1">Waktu Berangkat</label>
                <input type="datetime-local" name="start_time" class="w-full border rounded-md p-2" required>
            </div>

            {{-- End Time --}}
            <div>
                <label class="block text-sm font-medium mb-1">Waktu Kedatangan</label>
                <input type="datetime-local" name="end_time" class="w-full border rounded-md p-2" required>
            </div>

            {{-- Temperature (supports negative) --}}
            <div>
                <label class="block text-sm font-medium mb-1">Data Suhu Kendaraan</label>

                <div id="dynamicTemperature" class="space-y-3">
                    <div class="flex gap-3 items-center temp-row">
                        <input type="number" name="temperature[]" step="0.1" min="-50"
                            class="w-full border rounded-md p-2" placeholder="Suhu (°C)" required>

                        <input type="datetime-local" name="time[]"
                            class="w-full border rounded-md p-2" required>

                        <button type="button"
                            class="removeRow bg-red-500 text-white px-3 py-2 rounded-md hidden">
                            ✖
                        </button>
                    </div>
                </div>

                <button type="button" onclick="addTempRow()"
                    class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-md">
                    + Tambah Baris Suhu
                </button>
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold">
                Simpan Data Pengiriman
            </button>
        </form>
        <button onclick="openModal('deliveryModal')"
            class="px-4 py-2 bg-green-600 text-white rounded shadow mt-3">
            📥 Import Excel
        </button>
    </div>

</div>
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function addRow() {
        const container = document.getElementById('dynamicFields');
        const firstRow = container.querySelector('.single-row');

        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input').forEach(i => i.value = '');

        newRow.querySelector('.removeRow').classList.remove('hidden');

        container.appendChild(newRow);

        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('#dynamicFields .single-row');
        rows.forEach((row, i) => {
            const btn = row.querySelector('.removeRow');
            if (i === 0) {
                btn.classList.add('hidden');
            } else {
                btn.classList.remove('hidden');
                btn.onclick = () => row.remove();
            }
        });
    }

    function addTempRow() {
        const container = document.getElementById('dynamicTemperature');
        const firstRow = container.querySelector('.temp-row');

        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input').forEach(i => i.value = '');

        newRow.querySelector('.removeRow').classList.remove('hidden');

        container.appendChild(newRow);

        updateTempButtons();
    }

    function updateTempButtons() {
        const rows = document.querySelectorAll('#dynamicTemperature .temp-row');
        rows.forEach((row, i) => {
            const btn = row.querySelector('.removeRow');
            if (i === 0) {
                btn.classList.add('hidden');
            } else {
                btn.classList.remove('hidden');
                btn.onclick = () => row.remove();
            }
        });
    }
</script>

{{-- =============== WAREHOUSE MODAL =============== --}}
<div id="warehouseModal"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">

    <div class="bg-white rounded-lg w-96 p-6 shadow-xl">
        <h2 class="text-lg font-bold mb-4">📥 Import Excel - Warehouse</h2>

        <form action="{{ route('import.warehouse') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="block mb-2 font-semibold">Nama Gudang: </label>
            <select class="w-full border rounded-md p-2" name="warehouse_uuid" required>
                <option value="">Pilih Gudang</option>
                @foreach ($warehouses as $w)
                <option value="{{ $w->uuid }}">{{ $w->warehouse }}</option>
                @endforeach
            </select>

            <label class="block mb-2 font-semibold">Upload File:</label>
            <input type="file" name="excel_file"
                accept=".xlsx,.xls"
                class="border p-2 w-full rounded mb-4">

            <div class="flex justify-between">
                <a href="{{ route('temperature.template.warehouse') }}"
                    class="px-3 py-2 bg-blue-600 text-white rounded">
                    📄 Download Template
                </a>

                <button type="submit"
                    class="px-3 py-2 bg-green-600 text-white rounded">
                    Import
                </button>
            </div>
        </form>

        <button onclick="closeModal('warehouseModal')"
            class="mt-4 w-full py-2 bg-gray-300 rounded">
            Close
        </button>
    </div>
</div>


{{-- =============== DELIVERY MODAL =============== --}}
<div id="deliveryModal"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">

    <div class="bg-white rounded-lg w-96 p-6 shadow-xl">
        <h2 class="text-lg font-bold mb-4">📥 Import Excel - Delivery</h2>

        <form action="{{ route('temperature.import.delivery') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <label class="block mb-2 font-semibold">Nama Ekspedisi</label>
                <select name="expedition_uuid" class="w-full border rounded-md p-2" required>
                    <option value="">Pilih Ekspedisi</option>
                    @foreach ($expeditions as $e)
                    <option value="{{ $e->uuid }}">{{ $e->expedition }}</option>
                    @endforeach
                </select>
            </div>

            {{-- License Plate --}}
            <div>
                <label class="block mb-2 font-semibold">Nomor Plat Kendaraan</label>
                <input type="text" name="license_plate" class="w-full border rounded-md p-2" required>
            </div>

            {{-- Destination --}}
            <div>
                <label class="block mb-2 font-semibold">Tujuan Pengiriman</label>
                <input type="text" name="destination" class="w-full border rounded-md p-2" required>
            </div>

            {{-- Start Time --}}
            <div>
                <label class="block mb-2 font-semibold">Waktu Berangkat</label>
                <input type="datetime-local" name="start_time" class="w-full border rounded-md p-2" required>
            </div>

            {{-- End Time --}}
            <div>
                <label class="block mb-2 font-semibold">Waktu Kedatangan</label>
                <input type="datetime-local" name="end_time" class="w-full border rounded-md p-2" required>
            </div>

            <label class="block mb-2 font-semibold">Upload File:</label>
            <input type="file" name="excel_file"
                accept=".xlsx,.xls"
                class="border p-2 w-full rounded mb-4">

            <div class="flex justify-between">
                <a href="{{ route('temperature.template.delivery') }}"
                    class="px-3 py-2 bg-blue-600 text-white rounded">
                    📄 Download Template
                </a>

                <button type="submit"
                    class="px-3 py-2 bg-green-600 text-white rounded">
                    Import
                </button>
            </div>
        </form>

        <button onclick="closeModal('deliveryModal')"
            class="mt-4 w-full py-2 bg-gray-300 rounded">
            Close
        </button>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
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
                <label class="block text-sm font-medium mb-1">Suhu (°C)</label>
                <input type="number" name="temperature" class="w-full border rounded-md p-2" step="0.1" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Waktu Pencatatan</label>
                <input type="datetime-local" name="time" class="w-full border rounded-md p-2" required>
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold">
                Simpan Data Gudang
            </button>
        </form>
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

            {{-- Duration --}}
            <div>
                <label class="block text-sm font-medium mb-1">Durasi Pre-cooling (menit)</label>
                <input type="number" name="duration" class="w-full border rounded-md p-2" min="0" required>
            </div>

            {{-- Temperature (supports negative) --}}
            <div>
                <label class="block text-sm font-medium mb-1">Suhu Kendaraan (°C)</label>
                <input type="number" name="temperature" step="0.1" min="-50" class="w-full border rounded-md p-2" required>
            </div>

            {{-- Temperature log time --}}
            <div>
                <label class="block text-sm font-medium mb-1">Waktu Pencatatan Suhu</label>
                <input type="datetime-local" name="time" class="w-full border rounded-md p-2" required>
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold">
                Simpan Data Pengiriman
            </button>
        </form>
    </div>

</div>
@endsection
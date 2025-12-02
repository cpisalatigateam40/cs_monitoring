@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6 grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Form Gudang --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">📦 Input Data Suhu Gudang</h2>

        <form action="#" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Gudang</label>
                <select class="w-full border rounded-md p-2">
                    <option value="">Pilih Gudang</option>
                    @foreach ($warehouses as $w)
                    <option value="{{ $w }}">{{ $w }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Suhu (°C)</label>
                <input type="number" class="w-full border rounded-md p-2" step="0.1">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Waktu Pencatatan</label>
                <input type="datetime-local" class="w-full border rounded-md p-2">
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold">
                Simpan Data Gudang
            </button>
        </form>
    </div>

    {{-- Form Ekspedisi --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">🚚 Input Data Pengiriman</h2>

        <form action="#" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Ekspedisi</label>
                <select class="w-full border rounded-md p-2">
                    <option value="">Pilih Ekspedisi</option>
                    @foreach ($expeditions as $e)
                    <option value="{{ $e }}">{{ $e }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nomor Plat Kendaraan</label>
                <input type="text" class="w-full border rounded-md p-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tujuan Pengiriman</label>
                <input type="text" class="w-full border rounded-md p-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Waktu Berangkat</label>
                <input type="datetime-local" class="w-full border rounded-md p-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Waktu Kedatangan</label>
                <input type="datetime-local" class="w-full border rounded-md p-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Durasi Pre-cooling (menit)</label>
                <input type="number" class="w-full border rounded-md p-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Suhu Kendaraan (°C)</label>
                <input type="number" step="0.1" class="w-full border rounded-md p-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Waktu Pencatatan Suhu</label>
                <input type="datetime-local" class="w-full border rounded-md p-2">
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold">
                Simpan Data Pengiriman
            </button>
        </form>
    </div>

</div>
@endsection
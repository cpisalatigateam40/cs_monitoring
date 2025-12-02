@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">

    {{-- Filter Section --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">🔍 Filter Data</h2>

        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pengiriman</label>
                <select class="w-full border rounded-lg p-2">
                    <option>Semua Pengiriman</option>
                    <option>Expedisi A - B1234CD</option>
                    <option>Expedisi B - D5678EF</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" class="w-full border rounded-lg p-2" value="{{ now()->subDays(7)->toDateString() }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" class="w-full border rounded-lg p-2" value="{{ now()->toDateString() }}">
            </div>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">📊 Grafik Suhu</h2>
        <div class="text-gray-500 w-full h-64 flex items-center justify-center border rounded-lg">
            Chart suhu akan tampil di sini
        </div>
    </div>

    {{-- Stat & Table Section --}}
    <div class="grid md:grid-cols-3 gap-6">

        {{-- Stat Cards --}}
        <div class="space-y-4">

            <div class="p-4 bg-emerald-200 rounded-lg border-2 border-transparent cursor-pointer">
                <p class="text-emerald-900 font-semibold text-sm">Suhu &lt; -18°C</p>
                <h3 class="text-3xl font-extrabold text-emerald-900">12</h3>
                <p class="text-emerald-700 font-bold text-xl">40%</p>
            </div>

            <div class="p-4 bg-orange-200 rounded-lg border-2 border-transparent cursor-pointer">
                <p class="text-orange-900 font-semibold text-sm">-18°C s/d -15°C</p>
                <h3 class="text-3xl font-extrabold text-orange-900">8</h3>
                <p class="text-orange-700 font-bold text-xl">27%</p>
            </div>

            <div class="p-4 bg-red-200 rounded-lg border-2 border-transparent cursor-pointer">
                <p class="text-red-900 font-semibold text-sm">-15°C s/d -10°C</p>
                <h3 class="text-3xl font-extrabold text-red-900">6</h3>
                <p class="text-red-700 font-bold text-xl">20%</p>
            </div>

            <div class="p-4 bg-red-200 rounded-lg border-2 border-transparent cursor-pointer">
                <p class="text-red-900 font-semibold text-sm">-10°C s/d 0°C</p>
                <h3 class="text-3xl font-extrabold text-red-900">3</h3>
                <p class="text-red-700 font-bold text-xl">10%</p>
            </div>

            <div class="p-4 bg-red-200 rounded-lg border-2 border-transparent cursor-pointer">
                <p class="text-red-900 font-semibold text-sm">Suhu &gt; 0°C</p>
                <h3 class="text-3xl font-extrabold text-red-900">1</h3>
                <p class="text-red-700 font-bold text-xl">3%</p>
            </div>

        </div>

        {{-- Table --}}
        <div class="md:col-span-2 bg-white rounded-lg shadow overflow-hidden">
            <div class="border-b p-4">
                <h2 class="text-lg font-semibold text-gray-900">📋 Riwayat Pembacaan</h2>
            </div>

            <div class="overflow-y-auto" style="max-height: 500px;">
                <table class="min-w-full">
                    <thead class="bg-blue-600 text-white sticky top-0">
                        <tr>
                            <th class="p-3 text-left text-sm font-semibold">Waktu</th>
                            <th class="p-3 text-left text-sm font-semibold">Ekspedisi</th>
                            <th class="p-3 text-left text-sm font-semibold">Suhu</th>
                            <th class="p-3 text-left text-sm font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-emerald-100">
                            <td class="p-3 text-sm">01 Des 2025 - 09:20</td>
                            <td class="p-3 text-sm">Expedisi A - B1234CD</td>
                            <td class="p-3 font-bold text-sm">-18.5°C</td>
                            <td class="p-3 font-semibold text-sm">Aman</td>
                        </tr>
                        <tr class="bg-orange-100">
                            <td class="p-3 text-sm">01 Des 2025 - 08:10</td>
                            <td class="p-3 text-sm">Expedisi B - D5678EF</td>
                            <td class="p-3 font-bold text-sm">-16.3°C</td>
                            <td class="p-3 font-semibold text-sm">Warning</td>
                        </tr>
                        <tr class="bg-red-100">
                            <td class="p-3 text-sm">30 Nov 2025 - 14:50</td>
                            <td class="p-3 text-sm">Expedisi C - F5123GH</td>
                            <td class="p-3 font-bold text-sm">-12.1°C</td>
                            <td class="p-3 font-semibold text-sm">Bahaya</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
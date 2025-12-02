@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">

    {{-- Header Welcome --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">
            Selamat Datang, {{ auth()->user()->name ?? 'User' }}
        </h2>
        <p class="text-gray-500 text-sm mt-1">
            Role: {{ auth()->user()->role_name ?? '-' }} |
            Cabang: {{ session('selected_branch') ? 'Cabang '.session('selected_branch') : '-' }}
        </p>
    </div>

    {{-- Dummy Data --}}
    @php
    $warehouseAnalytics = [
    [
    'name' => 'Gudang Beku A',
    'totalReadings' => 124,
    'avgTemp' => -17.2,
    'totalAbove15' => 2,
    'mostFrequentTime' => '14:00 - 15:00'
    ],
    [
    'name' => 'Gudang Beku B',
    'totalReadings' => 98,
    'avgTemp' => -19.1,
    'totalAbove15' => 0,
    'mostFrequentTime' => '-'
    ],
    ];

    $shipmentAnalytics = [
    [
    'name' => 'J&T - B 1234 XY',
    'totalReadings' => 87,
    'avgTemp' => -14.8,
    'totalAbove15' => 3,
    'mostFrequentTime' => '11:00 - 12:00'
    ],
    [
    'name' => 'JNE - B 9987 YY',
    'totalReadings' => 69,
    'avgTemp' => -18.5,
    'totalAbove15' => 0,
    'mostFrequentTime' => '-'
    ],
    ];
    @endphp


    {{-- Rekap Gudang --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
            📦 Rekap Gudang - 7 Hari Terakhir
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="p-3 text-left text-sm font-semibold">Nama Gudang</th>
                        <th class="p-3 text-center text-sm font-semibold">Total Pembacaan</th>
                        <th class="p-3 text-center text-sm font-semibold">Rata-rata Suhu</th>
                        <th class="p-3 text-center text-sm font-semibold">Kejadian > -15°C</th>
                        <th class="p-3 text-center text-sm font-semibold">Waktu Tersering > -15°C</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($warehouseAnalytics as $index => $row)
                    @php
                    $rowBg = $index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                    $tempColor = $row['avgTemp'] > -15 ? 'text-red-500' : ($row['avgTemp'] > -18 ? 'text-yellow-500' :
                    'text-green-500');
                    $incidentColor = $row['totalAbove15'] > 0 ? 'text-red-500' : 'text-green-500';
                    @endphp
                    <tr class="{{ $rowBg }}">
                        <td class="p-3 font-semibold text-gray-700">{{ $row['name'] }}</td>
                        <td class="p-3 text-center font-bold text-blue-600">{{ $row['totalReadings'] }}</td>
                        <td class="p-3 text-center font-bold {{ $tempColor }}">{{ $row['avgTemp'] }}°C</td>
                        <td class="p-3 text-center font-bold {{ $incidentColor }}">{{ $row['totalAbove15'] }}</td>
                        <td class="p-3 text-center text-gray-600 font-medium">{{ $row['mostFrequentTime'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- Rekap Pengiriman --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
            🚚 Rekap Pengiriman - 7 Hari Terakhir
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="p-3 text-left text-sm font-semibold">Ekspedisi - Kendaraan</th>
                        <th class="p-3 text-center text-sm font-semibold">Total Pembacaan</th>
                        <th class="p-3 text-center text-sm font-semibold">Rata-rata Suhu</th>
                        <th class="p-3 text-center text-sm font-semibold">Kejadian > -15°C</th>
                        <th class="p-3 text-center text-sm font-semibold">Waktu Tersering > -15°C</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($shipmentAnalytics as $index => $row)
                    @php
                    $rowBg = $index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                    $tempColor = $row['avgTemp'] > -15 ? 'text-red-500' : ($row['avgTemp'] > -18 ? 'text-yellow-500' :
                    'text-green-500');
                    $incidentColor = $row['totalAbove15'] > 0 ? 'text-red-500' : 'text-green-500';
                    @endphp
                    <tr class="{{ $rowBg }}">
                        <td class="p-3 font-semibold text-gray-700">{{ $row['name'] }}</td>
                        <td class="p-3 text-center font-bold text-blue-600">{{ $row['totalReadings'] }}</td>
                        <td class="p-3 text-center font-bold {{ $tempColor }}">{{ $row['avgTemp'] }}°C</td>
                        <td class="p-3 text-center font-bold {{ $incidentColor }}">{{ $row['totalAbove15'] }}</td>
                        <td class="p-3 text-center text-gray-600 font-medium">{{ $row['mostFrequentTime'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
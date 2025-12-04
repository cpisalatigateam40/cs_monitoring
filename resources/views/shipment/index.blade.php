@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">

    {{-- Filter Section --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">🔍 Filter Data</h2>

        <form id="filterForm" action="{{ route('shipment.recap') }}" method="GET" class="grid md:grid-cols-4 gap-4 items-end">
            <!-- Pengiriman Dropdown -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pengiriman</label>
                <select name="expedition" class="w-full border rounded-lg p-2" onchange="this.form.submit()">
                    <option value="all" {{ request('expedition') == 'all' ? 'selected' : '' }}>Semua Pengiriman</option>
                    @foreach($expeditions as $exp)
                    <option value="{{ $exp->uuid }}" {{ request('expedition') == $exp->uuid ? 'selected' : '' }}>
                        {{ $exp->expedition }} - {{ $exp->code }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal Mulai -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" class="w-full border rounded-lg p-2" onchange="this.form.submit()">
            </div>

            <!-- Tanggal Selesai -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" class="w-full border rounded-lg p-2" onchange="this.form.submit()">
            </div>

            <!-- Reset Button -->
            <div>
                <button type="button" onclick="window.location='{{ route('shipment.recap') }}'" class="w-full bg-gray-100 border rounded-lg p-2 font-medium hover:bg-gray-200">
                    Reset
                </button>
            </div>
        </form>
    </div>

    {{-- Chart Section --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">📊 Grafik Suhu</h2>
        <div class="text-gray-500 w-full h-64 flex items-center justify-center border rounded-lg">
            Chart suhu akan tampil di sini
        </div>
    </div>

    {{-- Stat & Table Section --}}
    @php
    $groups = [
    'Suhu < -18°C'=> fn($t) => $t < -18, '-18°C s/d -15°C'=> fn($t) => $t >= -18 && $t < -15, '-15°C s/d -10°C'=> fn($t) => $t >= -15 && $t < -10, '-10°C s/d 0°C'=> fn($t) => $t >= -10 && $t < 0, 'Suhu > 0°C'=> fn($t) => $t >= 0,
                        ];

                        $total = $records->count();

                        $stats = [];

                        foreach ($groups as $label => $condition) {
                        $count = $records->filter(fn($r) => $condition($r->temperature))->count();

                        $stats[] = [
                        'label' => $label,
                        'count' => $count,
                        'percent' => $total > 0 ? round(($count / $total) * 100) : 0,
                        'bg' => match($label) {
                        'Suhu < -18°C'=> 'bg-emerald-200 text-emerald-900',
                            '-18°C s/d -15°C' => 'bg-orange-200 text-orange-900',
                            default => 'bg-red-200 text-red-900',
                            }
                            ];
                            }
                            @endphp


                            <div class="grid md:grid-cols-3 gap-6">

                                {{-- Stat Cards --}}
                                <div class="space-y-4">
                                    @foreach ($stats as $s)
                                    @php
                                    // background color (first class)
                                    $bg = explode(' ', $s['bg'])[0];
                                    $text = explode(' ', $s['bg'])[1];
                                    @endphp

                                    <div class="p-4 rounded-lg border-2 border-transparent cursor-pointer {{ $bg }}">
                                        <p class="font-semibold text-sm {{ $text }}">{{ $s['label'] }}</p>
                                        <h3 class="text-3xl font-extrabold {{ $text }}">{{ $s['count'] }}</h3>
                                        <p class="font-bold text-xl {{ $text }}">{{ $s['percent'] }}%</p>
                                    </div>
                                    @endforeach
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

                                                @foreach ($records as $r)
                                                @php
                                                $temp = $r->temperature;

                                                if ($temp < -18) {
                                                    $row=['bg'=> 'bg-emerald-100', 'text' => 'text-emerald-900', 'label' => 'Aman'];
                                                    } elseif ($temp < -10) {
                                                        $row=['bg'=> 'bg-orange-100', 'text' => 'text-orange-900', 'label' => 'Warning'];
                                                        } else {
                                                        $row = ['bg' => 'bg-red-100', 'text' => 'text-red-900', 'label' => 'Bahaya'];
                                                        }
                                                        @endphp

                                                        <tr class="{{ $row['bg'] }}">
                                                            <td class="p-3 text-sm {{ $row['text'] }}">{{ $r->time }}</td>
                                                            <td class="p-3 text-sm {{ $row['text'] }}">
                                                                {{ $r->expedition->expedition ?? '-' }} - {{$r->license_plate}}
                                                            </td>
                                                            <td class="p-3 text-sm font-bold {{ $row['text'] }}">
                                                                {{ number_format($temp, 1) }}°C
                                                            </td>
                                                            <td class="p-3 text-sm font-semibold {{ $row['text'] }}">
                                                                {{ $row['label'] }}
                                                            </td>
                                                        </tr>
                                                        @endforeach

                                                        @if ($records->isEmpty())
                                                        <tr>
                                                            <td colspan="4" class="p-6 text-center text-gray-500">
                                                                Tidak ada data
                                                            </td>
                                                        </tr>
                                                        @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
</div>
@endsection
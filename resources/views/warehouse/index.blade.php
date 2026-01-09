@extends('layouts.app')

@section('content')
@php
$fontSize = 14; // default sementara
@endphp

<div class="max-w-7xl mx-auto px-6 py-6">

    {{-- Filter Section --}}
    <div
        style="background-color: #ffffff; padding: {{ $fontSize * 1.5 }}px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: {{ $fontSize * 1.5 }}px;">
        <h2 style="font-size: {{ $fontSize * 1.25 }}px; font-weight: 600; margin-bottom: {{ $fontSize }}px;">
            🔍 Filter Data
        </h2>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: {{ $fontSize }}px; align-items: end;">
            <div>
                <label style="display: block; font-size: {{ $fontSize * 0.875 }}px; font-weight: 500; margin-bottom: {{ $fontSize * 0.5 }}px;">
                    Gudang
                </label>
                <select name="warehouse" form="filterForm" style="width: 100%; padding: {{ $fontSize * 0.75 }}px {{ $fontSize }}px; border-radius: 8px; border: 2px solid #e5e7eb;" onchange="document.getElementById('filterForm').submit()">
                    <option value="all" {{ request('warehouse') == 'all' ? 'selected' : '' }}>Semua Gudang</option>
                    @foreach($warehouses as $w)
                    <option value="{{ $w->uuid }}" {{ request('warehouse') == $w->uuid ? 'selected' : '' }}>
                        {{ $w->warehouse }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display: block; font-size: {{ $fontSize * 0.875 }}px; font-weight: 500; margin-bottom: {{ $fontSize * 0.5 }}px;">
                    Tanggal Mulai
                </label>
                <input type="date" name="start_date" form="filterForm" value="{{ request('start_date') }}" style="width: 100%; padding: {{ $fontSize * 0.75 }}px {{ $fontSize }}px; border-radius: 8px; border: 2px solid #e5e7eb;" onchange="document.getElementById('filterForm').submit()">
            </div>

            <div>
                <label style="display: block; font-size: {{ $fontSize * 0.875 }}px; font-weight: 500; margin-bottom: {{ $fontSize * 0.5 }}px;">
                    Tanggal Selesai
                </label>
                <input type="date" name="end_date" form="filterForm" value="{{ request('end_date') }}" style="width: 100%; padding: {{ $fontSize * 0.75 }}px {{ $fontSize }}px; border-radius: 8px; border: 2px solid #e5e7eb;" onchange="document.getElementById('filterForm').submit()">
            </div>

            <div>
                <button type="button" onclick="window.location='{{ route('warehouse.recap') }}'" class="w-full py-2 rounded-lg border border-cyan-500 text-cyan-600 font-semibold 
           hover:bg-cyan-50 transition-all duration-200">
                    Reset
                </button>
            </div>

            <!-- Hidden form -->
            <form id="filterForm" action="{{ route('warehouse.recap') }}" method="GET" style="display: none;"></form>
        </div>
    </div>


    {{-- Chart Section --}}
    <div
        style="background-color: #ffffff; padding: {{ $fontSize * 1.5 }}px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: {{ $fontSize * 1.5 }}px;">
        <h2 style="font-size: {{ $fontSize * 1.25 }}px; font-weight: 600; margin-bottom: {{ $fontSize }}px;">
            📈 Grafik Suhu
        </h2>
        <canvas id="warehouseChart" style="width: 100%; height: 400px;"></canvas>
    </div>

    {{-- Grid Statistik + Tabel --}}
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: {{ $fontSize * 1.5 }}px;">

        {{-- Statistik Kategori Suhu --}}
        <div style="display: flex; flex-direction: column; gap: {{ $fontSize }}px;">

            @php
            $groups = [
                'Suhu < -18°C'      => fn($t) => $t < -18,
                '-18°C s/d -15°C'   => fn($t) => $t >= -18 && $t < -15,
                '-15°C s/d -10°C'   => fn($t) => $t >= -15 && $t < -10,
                '-10°C s/d 0°C'     => fn($t) => $t >= -10 && $t < 0,
                'Suhu > 0°C'        => fn($t) => $t >= 0,
            ];

            $total = $allRecords->count();
            $stats = [];

            foreach ($groups as $label => $condition) {
                $count = $allRecords
                    ->filter(fn($r) => $condition($r->temperature))
                    ->count();

                $stats[] = [
                    'label' => $label,
                    'count' => $count,
                    'percent' => $total > 0 ? round(($count / $total) * 100) : 0,
                    'bg' => match($label) {
                        'Suhu < -18°C'    => '#d1fae5',
                        '-18°C s/d -15°C' => '#fed7aa',
                        default           => '#fecaca',
                    },
                    'text' => match($label) {
                        'Suhu < -18°C'    => '#065f46',
                        '-18°C s/d -15°C' => '#92400e',
                        default           => '#991b1b',
                    }
                ];
            }
            @endphp


            @foreach($stats as $i => $s)
                <div class="temp-tab"
                    data-index="{{ $i }}"
                    style="background: {{ $s['bg'] }};
                        padding: {{ $fontSize * 1.5 }}px;
                        border-radius: 12px;
                        cursor: pointer;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <div style="display: flex; justify-content: space-between;">
                        <div>
                            <p style="font-size: {{ $fontSize * 0.875 }}px;
                                    font-weight: 600;
                                    margin-bottom: {{ $fontSize * 0.5 }}px;
                                    color: {{ $s['text'] }};">
                                {{ $s['label'] }}
                            </p>
                            <p style="font-size: {{ $fontSize * 2.5 }}px;
                                    font-weight: 800;
                                    line-height: 1;
                                    color: {{ $s['text'] }};">
                                {{ $s['count'] }}
                            </p>
                        </div>
                        <div style="text-align: right;">
                            <p style="font-size: {{ $fontSize * 2 }}px;
                                    font-weight: 700;
                                    color: {{ $s['text'] }};">
                                {{ $s['percent'] }}%
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>


        {{-- Table --}}
        <div style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div style="padding: {{ $fontSize * 1.5 }}px; border-bottom: 2px solid #e5e7eb;">
                <h2 style="font-size: {{ $fontSize * 1.25 }}px; font-weight: 600;">📋 Riwayat Pembacaan</h2>
            </div>

            <div style="overflow-y: auto; max-height: 600px;">
                <table style="width:100%; border-collapse: collapse;">
                    <thead style="position: sticky; top: 0; background-color: #1e40af;">
                        <tr>
                            <th style="padding: {{ $fontSize }}px; color: white; text-align: left;">Waktu</th>
                            <th style="padding: {{ $fontSize }}px; color: white; text-align: left;">Lokasi</th>
                            <th style="padding: {{ $fontSize }}px; color: white; text-align: left;">Suhu</th>
                            <th style="padding: {{ $fontSize }}px; color: white; text-align: left;">Status</th>
                        </tr>
                    </thead>

                    <tbody id="warehouse-table-body">
                        @foreach($records as $r)
                            @php
                            $temp = $r->temperature;
                            if ($temp < -18) {
                                $color = ['bg'=>'#d1fae5','text'=>'#065f46','label'=>'Aman'];
                            } elseif ($temp < -10) {
                                $color = ['bg'=>'#fed7aa','text'=>'#92400e','label'=>'Warning'];
                            } else {
                                $color = ['bg'=>'#fecaca','text'=>'#991b1b','label'=>'Bahaya'];
                            }
                            @endphp

                            <tr style="background-color: {{ $color['bg'] }};">
                                <td style="padding: {{ $fontSize }}px; font-weight: 500; color: {{ $color['text'] }};">
                                    {{ $r->time }}
                                </td>
                                <td style="padding: {{ $fontSize }}px; font-weight: 500; color: {{ $color['text'] }};">
                                    {{ $r->warehouse->warehouse }}
                                </td>
                                <td style="padding: {{ $fontSize }}px; font-weight: 700; color: {{ $color['text'] }};">
                                    {{ number_format($temp,1) }}°C
                                </td>
                                <td style="padding: {{ $fontSize }}px; font-weight: 600; color: {{ $color['text'] }};">
                                    {{ $color['label'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div style="padding: 12px;">
                {{ $records->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- =====================  JAVASCRIPT  ===================== --}}
<script>
    /* Chart */
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('warehouseChart').getContext('2d');

        const chartLabels = @json($chartLabels);
        const chartData   = @json($chartData);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Temperature (°C)',
                    data: chartData,
                    borderWidth: 2,
                    tension: 0.3,
                    borderColor: '#4e79a7',
                    backgroundColor: 'rgba(78,121,167,0.15)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { title: { display: true, text: '°C' }},
                    x: { title: { display: true, text: 'Waktu' }}
                }
            }
        });
    });

    // /* Data untuk filter */
    // const allRecords = @json($records);

    // /* Range suhu sesuai PHP */
    // const tempGroups = [
    //     r => r.temperature < -18,
    //     r => r.temperature >= -18 && r.temperature < -15,
    //     r => r.temperature >= -15 && r.temperature < -10,
    //     r => r.temperature >= -10 && r.temperature < 0,
    //     r => r.temperature >= 0
    // ];

    // /* Render tabel dinamis */
    // function renderTable(rows) {
    //     const tbody = document.getElementById("warehouse-table-body");
    //     tbody.innerHTML = "";

    //     if (rows.length === 0) {
    //         tbody.innerHTML = `
    //             <tr>
    //                 <td colspan="4" style="padding: 20px; text-align: center; color: #6b7280;">
    //                     Tidak ada data
    //                 </td>
    //             </tr>`;
    //         return;
    //     }

    //     rows.forEach(r => {
    //         let bg, text, label;
    //         const t = r.temperature;

    //         if (t < -18)      { bg='#d1fae5'; text='#065f46'; label='Aman'; }
    //         else if (t < -10) { bg='#fed7aa'; text='#92400e'; label='Warning'; }
    //         else              { bg='#fecaca'; text='#991b1b'; label='Bahaya'; }

    //         tbody.innerHTML += `
    //             <tr style="background:${bg}">
    //                 <td style="padding:10px; font-weight:500; color:${text};">
    //                     ${r.time}
    //                 </td>
    //                 <td style="padding:10px; font-weight:500; color:${text};">
    //                     ${r.warehouse.warehouse}
    //                 </td>
    //                 <td style="padding:10px; font-weight:700; color:${text};">
    //                     ${parseFloat(t).toFixed(1)}°C
    //                 </td>
    //                 <td style="padding:10px; font-weight:600; color:${text};">
    //                     ${label}
    //                 </td>
    //             </tr>`;
    //     });
    // }

    // /* Klik Tab Statistik */
    // document.querySelectorAll(".temp-tab").forEach((tab, idx) => {
    //     tab.addEventListener("click", () => {

    //         const filtered = allRecords.filter(r => tempGroups[idx](r));

    //         renderTable(filtered);

    //         document.querySelectorAll(".temp-tab").forEach(e => e.style.outline = "none");
    //         tab.style.outline = "3px solid #1e40af";
    //     });
    // });
</script>
@endsection
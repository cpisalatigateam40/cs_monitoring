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
                <button type="button" onclick="window.location='{{ route('shipment.recap') }}'" class="w-full py-2 rounded-lg border border-cyan-500 text-cyan-600 font-semibold 
           hover:bg-cyan-50 transition-all duration-200">
                    Reset
                </button>
            </div>
        </form>
    </div>

    {{-- Chart Section --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">📊 Grafik Suhu Pengiriman</h2>

        <canvas id="shipmentChart" class="w-full h-64"></canvas>
    </div>

{{-- ======================== --}}
{{--     Stat + Table Grid    --}}
{{-- ======================== --}}
@php
$groups = [
    'Suhu < -18°C'       => fn($t) => $t < -18,
    '-18°C s/d -15°C'    => fn($t) => $t >= -18 && $t < -15,
    '-15°C s/d -10°C'    => fn($t) => $t >= -15 && $t < -10,
    '-10°C s/d 0°C'      => fn($t) => $t >= -10 && $t < 0,
    'Suhu > 0°C'         => fn($t) => $t >= 0,
];

$total = $chartRecords->count();
$stats = [];

foreach ($groups as $label => $condition) {
    $count = $chartRecords
        ->filter(fn($r) => $condition($r->temperature))
        ->count();

    $stats[] = [
        'label' => $label,
        'count' => $count,
        'percent' => $total > 0 ? round(($count / $total) * 100) : 0,
        'bg' => match($label) {
            'Suhu < -18°C' => 'bg-emerald-200 text-emerald-900',
            '-18°C s/d -15°C' => 'bg-orange-200 text-orange-900',
            default => 'bg-red-200 text-red-900',
        }
    ];
}
@endphp

@php
$tempRanges = [
    0 => 'lt_-18',
    1 => '-18_-15',
    2 => '-15_-10',
    3 => '-10_0',
    4 => 'gte_0',
];
@endphp


<div class="grid md:grid-cols-3 gap-6">

    {{-- ======================== --}}
    {{--       Stat Cards        --}}
    {{-- ======================== --}}
    <div class="space-y-4">
    @foreach ($stats as $i => $s)
        @php
            $bg   = explode(' ', $s['bg'])[0];
            $text = explode(' ', $s['bg'])[1];

            $isActive = request('temp_range') === ($tempRanges[$i] ?? null);
        @endphp

        <a href="{{ route('shipment.recap', array_merge(
                request()->except('page'),
                ['temp_range' => $tempRanges[$i]]
            )) }}"
           class="block p-4 rounded-lg border cursor-pointer transition
                  {{ $bg }}
                  {{ $isActive ? 'ring-4 ring-blue-600 scale-[1.02]' : 'hover:scale-[1.01]' }}">
            
            <p class="font-semibold text-sm {{ $text }}">
                {{ $s['label'] }}
            </p>

            <h3 class="text-3xl font-extrabold {{ $text }}">
                {{ $s['count'] }}
            </h3>

            <p class="font-bold text-xl {{ $text }}">
                {{ $s['percent'] }}%
            </p>
        </a>
    @endforeach

    {{-- Reset filter suhu --}}
    @if(request()->filled('temp_range'))
        <a href="{{ route('shipment.recap', request()->except('temp_range','page')) }}"
           class="block text-center text-sm font-semibold text-gray-600 hover:text-blue-600 mt-2">
            Reset Filter Suhu
        </a>
    @endif
</div>




    {{-- ======================== --}}
    {{--      Table Section       --}}
    {{-- ======================== --}}
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
                <tbody id="shipment-table-body">

                    @foreach ($records as $r)
                        @php
                            $temp = $r->temperature;

                            if ($temp < -18) {
                                $row = ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-900', 'label' => 'Aman'];
                            } elseif ($temp < -10) {
                                $row = ['bg' => 'bg-orange-100', 'text' => 'text-orange-900', 'label' => 'Warning'];
                            } else {
                                $row = ['bg' => 'bg-red-100', 'text' => 'text-red-900', 'label' => 'Bahaya'];
                            }
                        @endphp

                        <tr class="{{ $row['bg'] }}">
                            <td class="p-3 text-sm {{ $row['text'] }}">{{ $r->time }}</td>
                            <td>{{ $r->expedition_name ?? '-' }} — {{ $r->license_plate ?? '-' }}</td>



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

        <div class="mt-4 px-4">
            {{ $records->links() }}
        </div>
    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('shipmentChart').getContext('2d');

    const labels = @json($chartLabels);
    const data = @json($chartData);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Temperature (°C)',
                data: data,
                borderWidth: 2,
                tension: 0.3,
                borderColor: '#06b6d4',           // info cyan
                backgroundColor: 'rgba(6,182,212,0.15)',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    title: { display: true, text: '°C' }
                },
                x: {
                    title: { display: true, text: 'Waktu' }
                }
            }
        }
    });
});

// /* Data dari backend */
//     const allRecords = @json($records);

//     /* Kelompok suhu */
//     const tempGroups = [
//         r => r.temperature < -18,
//         r => r.temperature >= -18 && r.temperature < -15,
//         r => r.temperature >= -15 && r.temperature < -10,
//         r => r.temperature >= -10 && r.temperature < 0,
//         r => r.temperature >= 0
//     ];

//     /* Render tabel berdasarkan data */
//     function renderTable(rows) {
//     const tbody = document.getElementById("shipment-table-body");
//     tbody.innerHTML = "";

//     if (rows.length === 0) {
//         tbody.innerHTML = `
//             <tr>
//                 <td colspan="4" class="py-5 text-center text-gray-500">
//                     Tidak ada data
//                 </td>
//             </tr>`;
//         return;
//     }

//     rows.forEach(r => {
//         let bg, text, label;
//         const t = r.temperature;

//         if (t < -18) {
//             bg = 'bg-emerald-100'; text = 'text-emerald-900'; label = 'Aman';
//         }
//         else if (t < -10) {
//             bg = 'bg-orange-100'; text = 'text-orange-900'; label = 'Warning';
//         }
//         else {
//             bg = 'bg-red-100'; text = 'text-red-900'; label = 'Bahaya';
//         }

//         tbody.innerHTML += `
//             <tr class="${bg}">
//                 <td class="p-3 font-medium ${text}">${r.time}</td>
//                 <td>{{ $r->expedition_name ?? '-' }} — {{ $r->license_plate ?? '-' }}</td>
//                 <td class="p-3 font-bold ${text}">${parseFloat(t).toFixed(1)}°C</td>
//                 <td class="p-3 font-semibold ${text}">${label}</td>
//             </tr>`;
//     });
// }


//     /* Event klik Tab */
//     document.querySelectorAll(".temp-tab").forEach((tab, idx) => {
//         tab.addEventListener("click", () => {

//             const filtered = allRecords.filter(r => tempGroups[idx](r));
//             renderTable(filtered);

//             /* Reset semua tab */
//             document.querySelectorAll(".temp-tab")
//                 .forEach(e => e.classList.remove("outline", "outline-2", "outline-blue-700"));

//             /* Aktifkan outline tab terpilih */
//             tab.classList.add("outline", "outline-2", "outline-blue-700");
//         });
//     });

//     /* Default: tampilkan semua data pertama kali */
//     renderTable(allRecords);
</script>
@endsection
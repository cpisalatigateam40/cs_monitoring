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

        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: {{ $fontSize }}px;">
            <div>
                <label
                    style="display: block; font-size: {{ $fontSize * 0.875 }}px; font-weight: 500; margin-bottom: {{ $fontSize * 0.5 }}px;">
                    Gudang
                </label>
                <select
                    style="width: 100%; padding: {{ $fontSize * 0.75 }}px {{ $fontSize }}px; border-radius: 8px; border: 2px solid #e5e7eb;">
                    <option>Semua Gudang</option>
                    @foreach($warehouses as $w)
                    <option>{{ $w }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label
                    style="display: block; font-size: {{ $fontSize * 0.875 }}px; font-weight: 500; margin-bottom: {{ $fontSize * 0.5 }}px;">
                    Tanggal Mulai
                </label>
                <input type="date"
                    style="width: 100%; padding: {{ $fontSize * 0.75 }}px {{ $fontSize }}px; border-radius: 8px; border: 2px solid #e5e7eb;">
            </div>

            <div>
                <label
                    style="display: block; font-size: {{ $fontSize * 0.875 }}px; font-weight: 500; margin-bottom: {{ $fontSize * 0.5 }}px;">
                    Tanggal Selesai
                </label>
                <input type="date"
                    style="width: 100%; padding: {{ $fontSize * 0.75 }}px {{ $fontSize }}px; border-radius: 8px; border: 2px solid #e5e7eb;">
            </div>
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
            $stats = [
            ['label' => 'Suhu < -18°C', 'count'=> 4, 'percent' => 60, 'bg' => '#d1fae5', 'text' => '#065f46' ],
                ['label' => '-18°C s/d -15°C', 'count' => 2, 'percent' => 20, 'bg' => '#fed7aa', 'text' => '#92400e' ],
                ['label' => '-15°C s/d -10°C', 'count' => 1, 'percent' => 10, 'bg' => '#fecaca', 'text' => '#991b1b' ],
                ['label' => '-10°C s/d 0°C', 'count' => 1, 'percent' => 10, 'bg' => '#fecaca', 'text' => '#991b1b' ],
                ['label' => 'Suhu > 0°C', 'count' => 0, 'percent' => 0, 'bg' => '#fecaca', 'text' => '#991b1b' ],
                ];
                @endphp

                @foreach($stats as $s)
                <div
                    style="background: {{ $s['bg'] }}; padding: {{ $fontSize * 1.5 }}px; border-radius: 12px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <div style="display: flex; justify-content: space-between;">
                        <div>
                            <p
                                style="font-size: {{ $fontSize * 0.875 }}px; font-weight: 600; margin-bottom: {{ $fontSize * 0.5 }}px; color: {{ $s['text'] }};">
                                {{ $s['label'] }}
                            </p>
                            <p
                                style="font-size: {{ $fontSize * 2.5 }}px; font-weight: 800; line-height: 1; color: {{ $s['text'] }};">
                                {{ $s['count'] }}
                            </p>
                        </div>
                        <div style="text-align: right;">
                            <p style="font-size: {{ $fontSize * 2 }}px; font-weight: 700; color: {{ $s['text'] }};">
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
                    <tbody>
                        @foreach($records as $r)
                        @php
                        $temp = $r['temperature'];
                        if ($temp < -18) { $color=['bg'=>'#d1fae5','text'=>'#065f46','label'=>'Aman']; }
                            else if ($temp < -10) { $color=['bg'=>'#fed7aa','text'=>'#92400e','label'=>'Warning']; }
                                else { $color = ['bg'=>'#fecaca','text'=>'#991b1b','label'=>'Bahaya']; }
                                @endphp
                                <tr style="background-color: {{ $color['bg'] }};">
                                    <td
                                        style="padding: {{ $fontSize }}px; font-weight: 500; color: {{ $color['text'] }};">
                                        {{ $r['timestamp']->format('d M Y H:i') }}</td>
                                    <td
                                        style="padding: {{ $fontSize }}px; font-weight: 500; color: {{ $color['text'] }};">
                                        {{ $r['warehouse_name'] }}</td>
                                    <td
                                        style="padding: {{ $fontSize }}px; font-weight: 700; color: {{ $color['text'] }};">
                                        {{ number_format($temp,1) }}°C</td>
                                    <td
                                        style="padding: {{ $fontSize }}px; font-weight: 600; color: {{ $color['text'] }};">
                                        {{ $color['label'] }}</td>
                                </tr>
                                @endforeach

                                @if(empty($records))
                                <tr>
                                    <td colspan="4"
                                        style="padding: {{ $fontSize * 3 }}px; text-align: center; color: #6b7280;">
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
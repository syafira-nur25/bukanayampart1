<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pakan</title>
</head>
<body>
    <h2>Laporan Pakan — BukanAyam</h2>
    <p>Desa Tanjung Agung — Dicetak: {{ now()->format('d/m/Y H:i') }}</p>

    <table border="1">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Total Masuk (zak)</th>
                <th colspan="{{ max($kandangs->count(), 1) }}">Keluar (Kg)</th>
                <th rowspan="2">Sisa (zak)</th>
                <th rowspan="2">Sisa (Kg)</th>
            </tr>
            <tr>
                @foreach ($kandangs as $kandang)
                    <th>{{ $kandang->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($row['tanggal'])->format('d/m/Y') }}</td>
                    <td>{{ $row['total_masuk'] + 0 }}</td>
                    @foreach ($kandangs as $kandang)
                        <td>{{ ($row['keluar'][$kandang->id] ?? 0) + 0 }}</td>
                    @endforeach
                    <td>{{ round($row['sisa_zak'], 1) }}</td>
                    <td>{{ round($row['sisa_kg'], 0) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 6 + $kandangs->count() }}">Belum ada data pakan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Arus Kas</title>
</head>
<body>
<h2 style="text-align:center;">ARUS KAS</h2>
<p style="text-align:center;">CLUSTER AYAM PETELUR — Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Nomor Bukti</th>
            <th>Penerimaan (Rp)</th>
            <th>Pengeluaran (Rp)</th>
            <th>Saldo (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row['tanggal']->format('d/m/Y') }}</td>
                <td>{{ $row['keterangan'] }}</td>
                <td>{{ $row['nomor_bukti'] ?? '' }}</td>
                <td>{{ $row['penerimaan'] > 0 ? number_format($row['penerimaan'], 0, ',', '.') : '' }}</td>
                <td>{{ $row['pengeluaran'] > 0 ? number_format($row['pengeluaran'], 0, ',', '.') : '' }}</td>
                <td>{{ number_format($row['saldo'], 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="text-align:right;"><b>TOTAL</b></td>
            <td><b>{{ number_format($totalPenerimaan, 0, ',', '.') }}</b></td>
            <td><b>{{ number_format($totalPengeluaran, 0, ',', '.') }}</b></td>
            <td><b>{{ number_format($totalPenerimaan - $totalPengeluaran, 0, ',', '.') }}</b></td>
        </tr>
    </tfoot>
</table>
</body>
</html>

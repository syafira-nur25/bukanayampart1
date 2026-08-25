<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Arus Kas</title>
</head>
<body>
<table border="1">
    <tr><th colspan="7" style="text-align:center; font-size:14pt;">ARUS KAS</th></tr>
    <tr><th colspan="7" style="text-align:center; font-size:12pt;">CLUSTER AYAM PETELUR</th></tr>
    <tr><th colspan="7"></th></tr>
    <tr style="background:#dbe9f9;">
        <th>No</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Nomor Bukti</th>
        <th>Penerimaan (Rp)</th>
        <th>Pengeluaran (Rp)</th>
        <th>Saldo</th>
    </tr>
    <tr style="background:#dbe9f9; text-align:center;">
        <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td>
    </tr>
    @foreach ($rows as $i => $r)
        <tr>
            <td style="text-align:center;">{{ $i + 1 }}</td>
            <td>{{ $r['tanggal']->format('d/m/Y') }}</td>
            <td>{{ $r['keterangan'] }}</td>
            <td>{{ $r['nomor_bukti'] ?? '' }}</td>
            <td>{{ $r['penerimaan'] > 0 ? 'Rp ' . number_format($r['penerimaan'], 0, ',', '.') : '' }}</td>
            <td>{{ $r['pengeluaran'] > 0 ? 'Rp ' . number_format($r['pengeluaran'], 0, ',', '.') : '' }}</td>
            <td>Rp {{ number_format($r['saldo'], 0, ',', '.') }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4" style="text-align:right;"><b>TOTAL</b></td>
        <td><b>Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}</b></td>
        <td><b>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</b></td>
        <td><b>Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</b></td>
    </tr>
</table>
</body>
</html>

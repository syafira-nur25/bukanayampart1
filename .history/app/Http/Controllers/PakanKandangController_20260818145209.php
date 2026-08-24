    /** Halaman laporan pakan */
    public function laporan()
    {
        [$laporan, $kandangs] = $this->dataLaporan();

        return view('pakan_kandang.laporan', compact('laporan', 'kandangs'));
    }

    /** BARU: export laporan pakan ke Excel (.xls) */
    public function exportExcel()
    {
        [$laporan, $kandangs] = $this->dataLaporan();

        $html = view('pakan_kandang.export-excel', compact('laporan', 'kandangs'))->render();

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="laporan-pakan-' . now()->format('Ymd-His') . '.xls"',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);
    }

    /** BARU: menyusun data laporan (dipakai halaman laporan & export) */
    private function dataLaporan(): array
    {
        $kandangs   = Kandang::orderBy('id')->get();
        $perTanggal = PakanKandang::orderBy('tanggal')->orderBy('id')->get()
            ->groupBy(fn ($r) => $r->tanggal->toDateString());

        $laporan = [];
        $saldoKg = 0;

        foreach ($perTanggal as $tanggal => $items) {
            $masukZak = (float) $items->sum('total_masuk');
            $saldoKg += $masukZak * PakanKandang::ZAK_KE_KG;

            $keluarPerKandang = [];
            foreach ($items->whereNotNull('kandang_id') as $item) {
                $keluarPerKandang[$item->kandang_id] =
                    ($keluarPerKandang[$item->kandang_id] ?? 0) + (float) $item->keluar;
            }

            $saldoKg -= array_sum($keluarPerKandang);

            $laporan[] = [
                'tanggal'     => $tanggal,
                'total_masuk' => $masukZak,
                'keluar'      => $keluarPerKandang,
                'sisa_kg'     => $saldoKg,
                'sisa_zak'    => $saldoKg / PakanKandang::ZAK_KE_KG,
            ];
        }

        return [$laporan, $kandangs];
    }

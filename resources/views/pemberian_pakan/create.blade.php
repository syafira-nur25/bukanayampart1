@extends('layouts.app')

@section('title', 'Tambah Pemberian Pakan')

@section('content')

<h2>Tambah Pemberian Pakan</h2>

<div class="card">
<div class="card-body">

<form
    action="{{ route('pemberian-pakan.store') }}"
    method="POST"
>
@csrf

<div class="row">

    <div class="col-md-6 mb-3">

        <label>Bulan</label>

        <input
            type="text"
            name="bulan"
            class="form-control"
            value="{{ old('bulan') }}"
            placeholder="Contoh: Januari"
            required
        >

    </div>

    <div class="col-md-6 mb-3">

        <label>Populasi</label>

        <select name="populasi_id" class="form-select" required>

            <option value="">
                -- Pilih Populasi --
            </option>

            @foreach($populasis as $populasi)

                <option
                    value="{{ $populasi->id }}"
                    @selected(old('populasi_id') == $populasi->id)
                >
                    {{ $populasi->tanggal->format('d-m-Y') }}
                    -
                    {{ $populasi->kandang->nama ?? '-' }}
                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label>Jenis Pakan</label>

        <input
            type="text"
            name="jenis_pakan"
            class="form-control"
            value="{{ old('jenis_pakan') }}"
            required
        >

    </div>

    @foreach([
        'gr' => 'Gram',
        'kg' => 'Kg',
        'total' => 'Total',
        'harga' => 'Harga',
        'pengeluaran' => 'Pengeluaran'
    ] as $field => $label)

        <div class="col-md-4 mb-3">

            <label>{{ $label }}</label>

            <input
                type="number"
                name="{{ $field }}"
                class="form-control"
                value="{{ old($field, 0) }}"
                min="0"
                required
            >

        </div>

    @endforeach

</div>

<button class="btn btn-primary">
    Simpan
</button>

<a
    href="{{ route('pemberian-pakan.index') }}"
    class="btn btn-secondary"
>
    Kembali
</a>

</form>

</div>
</div>

@endsection

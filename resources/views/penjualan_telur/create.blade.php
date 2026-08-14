@extends('layouts.app')

@section('title', 'Tambah Penjualan Telur')

@section('content')

<h2>Tambah Penjualan Telur</h2>

<div class="card">
<div class="card-body">

<form
    action="{{ route('penjualan-telur.store') }}"
    method="POST"
>
@csrf

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Tanggal</label>

        <input
            type="date"
            name="tanggal"
            class="form-control"
            value="{{ old('tanggal') }}"
            required
        >
    </div>

    <div class="col-md-6 mb-3">
        <label>Customer</label>

        <input
            type="text"
            name="customer"
            class="form-control"
            value="{{ old('customer') }}"
            required
        >
    </div>

    <div class="col-md-6 mb-3">
        <label>Produksi Telur</label>

        <select name="produksi_id" class="form-select" required>

            <option value="">
                -- Pilih Produksi --
            </option>

            @foreach($produksis as $produksi)

                <option
                    value="{{ $produksi->id }}"
                    @selected(old('produksi_id') == $produksi->id)
                >
                    {{ $produksi->tanggal->format('d-m-Y') }}
                    -
                    {{ $produksi->kandang->nama ?? '-' }}
                </option>

            @endforeach

        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label>Jumlah</label>

        <input
            type="number"
            name="jumlah"
            class="form-control"
            value="{{ old('jumlah', 0) }}"
            min="1"
            required
        >
    </div>

    <div class="col-md-6 mb-3">
        <label>Harga</label>

        <input
            type="number"
            name="harga"
            class="form-control"
            value="{{ old('harga', 0) }}"
            min="0"
            step="0.01"
            required
        >
    </div>

    <div class="col-md-6 mb-3">
        <label>Total</label>

        <input
            type="number"
            name="total"
            class="form-control"
            value="{{ old('total', 0) }}"
            min="0"
            required
        >
    </div>

</div>

<button class="btn btn-primary">
    Simpan
</button>

<a
    href="{{ route('penjualan-telur.index') }}"
    class="btn btn-secondary"
>
    Kembali
</a>

</form>

</div>
</div>

@endsection

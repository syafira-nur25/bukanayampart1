@extends('layouts.app')

@section('title', 'Edit Penjualan Telur')

@section('content')

<h2>Edit Penjualan Telur</h2>

<div class="card">
<div class="card-body">

<form
    action="{{ route('penjualan-telur.update', $penjualanTelur) }}"
    method="POST"
>
@csrf
@method('PUT')

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Tanggal</label>

        <input
            type="date"
            name="tanggal"
            class="form-control"
            value="{{ old('tanggal', $penjualanTelur->tanggal->format('Y-m-d')) }}"
            required
        >
    </div>

    <div class="col-md-6 mb-3">
        <label>Customer</label>

        <input
            type="text"
            name="customer"
            class="form-control"
            value="{{ old('customer', $penjualanTelur->customer) }}"
            required
        >
    </div>

    <div class="col-md-6 mb-3">
        <label>Produksi Telur</label>

        <select name="produksi_id" class="form-select" required>

            @foreach($produksis as $produksi)

                <option
                    value="{{ $produksi->id }}"
                    @selected($penjualanTelur->produksi_id == $produksi->id)
                >
                    {{ $produksi->tanggal->format('d-m-Y') }}
                    -
                    {{ $produksi->kandang->nama ?? '-' }}
                </option>

            @endforeach

        </select>
    </div>

    @foreach([
        'jumlah' => 'Jumlah',
        'harga' => 'Harga',
        'total' => 'Total'
    ] as $field => $label)

        <div class="col-md-6 mb-3">

            <label>{{ $label }}</label>

            <input
                type="number"
                name="{{ $field }}"
                class="form-control"
                value="{{ old($field, $penjualanTelur->$field) }}"
                min="0"
                required
            >

        </div>

    @endforeach

</div>

<button class="btn btn-primary">
    Update
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

@extends('layouts.app')

@section('title', 'Edit Pemberian Pakan')

@section('content')

<h2>Edit Pemberian Pakan</h2>

<div class="card">
<div class="card-body">

<form
    action="{{ route('pemberian-pakan.update', $pemberianPakan) }}"
    method="POST"
>
@csrf
@method('PUT')

<div class="row">

    <div class="col-md-6 mb-3">

        <label>Bulan</label>

        <input
            type="text"
            name="bulan"
            class="form-control"
            value="{{ old('bulan', $pemberianPakan->bulan) }}"
            required
        >

    </div>

    <div class="col-md-6 mb-3">

        <label>Populasi</label>

        <select name="populasi_id" class="form-select" required>

            @foreach($populasis as $populasi)

                <option
                    value="{{ $populasi->id }}"
                    @selected($pemberianPakan->populasi_id == $populasi->id)
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
            value="{{ old('jenis_pakan', $pemberianPakan->jenis_pakan) }}"
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
                value="{{ old($field, $pemberianPakan->$field) }}"
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
    href="{{ route('pemberian-pakan.index') }}"
    class="btn btn-secondary"
>
    Kembali
</a>

</form>

</div>
</div>

@endsection

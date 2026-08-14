@extends('layouts.app')

@section('title', 'Tambah Total Pakan')

@section('content')

<h2>Tambah Total Pakan</h2>

<div class="card">
<div class="card-body">

<form
    action="{{ route('total-pakan.store') }}"
    method="POST"
>
@csrf

<div class="mb-3">

    <label>Pakan Kandang</label>

    <select
        name="pakan_kandang_id"
        class="form-select"
        required
    >

        <option value="">
            -- Pilih Pakan --
        </option>

        @foreach($pakanKandangs as $pakan)

            <option
                value="{{ $pakan->id }}"
                @selected(old('pakan_kandang_id') == $pakan->id)
            >
                {{ $pakan->tanggal->format('d-m-Y') }}
                -
                {{ $pakan->kandang->nama ?? '-' }}
            </option>

        @endforeach

    </select>

</div>

<div class="mb-3">

    <label>Total (Kg)</label>

    <input
        type="number"
        name="total"
        class="form-control"
        value="{{ old('total', 0) }}"
        min="0"
        step="0.01"
        required
    >

</div>

<button class="btn btn-primary">
    Simpan
</button>

<a
    href="{{ route('total-pakan.index') }}"
    class="btn btn-secondary"
>
    Kembali
</a>

</form>

</div>
</div>

@endsection

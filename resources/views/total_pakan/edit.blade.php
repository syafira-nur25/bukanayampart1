@extends('layouts.app')

@section('title', 'Edit Total Pakan')

@section('content')

<h2>Edit Total Pakan</h2>

<div class="card">
<div class="card-body">

<form
    action="{{ route('total-pakan.update', $totalPakan) }}"
    method="POST"
>
@csrf
@method('PUT')

<div class="mb-3">

    <label>Pakan Kandang</label>

    <select
        name="pakan_kandang_id"
        class="form-select"
        required
    >

        @foreach($pakanKandangs as $pakan)

            <option
                value="{{ $pakan->id }}"
                @selected($totalPakan->pakan_kandang_id == $pakan->id)
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
        value="{{ old('total', $totalPakan->total) }}"
        min="0"
        step="0.01"
        required
    >

</div>

<button class="btn btn-primary">
    Update
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

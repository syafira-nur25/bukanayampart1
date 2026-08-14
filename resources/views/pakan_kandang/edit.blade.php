@extends('layouts.app')

@section('title', 'Edit Pakan Kandang')

@section('content')

<h2>Edit Pakan Kandang</h2>

<div class="card">
<div class="card-body">

<form
    action="{{ route('pakan-kandang.update', $pakanKandang) }}"
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
            value="{{ old('tanggal', $pakanKandang->tanggal->format('Y-m-d')) }}"
            required
        >

    </div>

    <div class="col-md-6 mb-3">

        <label>Kandang</label>

        <select name="kandang_id" class="form-select" required>

            @foreach($kandangs as $kandang)

                <option
                    value="{{ $kandang->id }}"
                    @selected($pakanKandang->kandang_id == $kandang->id)
                >
                    {{ $kandang->nama }}
                </option>

            @endforeach

        </select>

    </div>

    @foreach([
        'total_masuk' => 'Total Masuk (Kg)',
        'keluar' => 'Keluar (Kg)',
        'sisa' => 'Sisa (Kg)'
    ] as $field => $label)

        <div class="col-md-4 mb-3">

            <label>{{ $label }}</label>

            <input
                type="number"
                name="{{ $field }}"
                class="form-control"
                value="{{ old($field, $pakanKandang->$field) }}"
                min="0"
                step="0.01"
                required
            >

        </div>

    @endforeach

</div>

<button class="btn btn-primary">
    Update
</button>

<a
    href="{{ route('pakan-kandang.index') }}"
    class="btn btn-secondary"
>
    Kembali
</a>

</form>

</div>
</div>

@endsection

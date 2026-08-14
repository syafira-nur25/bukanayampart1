@extends('layouts.app')

@section('title', 'Edit Populasi')

@section('content')

<div class="card">
    <div class="card-body">

        <form
            action="{{ route('populasi.update', $populasi) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Tanggal</label>

                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    value="{{ old('tanggal', $populasi->tanggal->format('Y-m-d')) }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Kandang</label>

                <select name="kandang_id" class="form-select" required>

                    @foreach($kandangs as $kandang)

                        <option
                            value="{{ $kandang->id }}"
                            @selected($populasi->kandang_id == $kandang->id)
                        >
                            {{ $kandang->nama }}
                        </option>

                    @endforeach

                </select>
            </div>

            <div class="row">

                @foreach([
                    'hidup' => 'Hidup',
                    'mati' => 'Mati',
                    'afkir' => 'Afkir',
                    'sisa' => 'Sisa',
                    'usia' => 'Usia (hari)'
                ] as $field => $label)

                    <div class="col-md-4 mb-3">

                        <label>{{ $label }}</label>

                        <input
                            type="number"
                            name="{{ $field }}"
                            class="form-control"
                            value="{{ old($field, $populasi->$field) }}"
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
                href="{{ route('populasi.index') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection

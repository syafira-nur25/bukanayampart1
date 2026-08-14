@extends('layouts.app')

@section('title', 'Tambah Produksi Telur')

@section('content')

<h2>Tambah Produksi Telur</h2>

<div class="card">
    <div class="card-body">

        <form
            action="{{ route('produksi-telur.store') }}"
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

                    <label>Kandang</label>

                    <select
                        name="kandang_id"
                        class="form-select"
                        required
                    >
                        <option value="">
                            -- Pilih Kandang --
                        </option>

                        @foreach($kandangs as $kandang)

                            <option
                                value="{{ $kandang->id }}"
                                @selected(old('kandang_id') == $kandang->id)
                            >
                                {{ $kandang->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Populasi</label>

                    <select
                        name="populasi_id"
                        class="form-select"
                        required
                    >

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

                @foreach([
                    'jumlah_produksi' => 'Jumlah Produksi',
                    'presentase' => 'Persentase (%)',
                    'mati' => 'Mati',
                    'afkir' => 'Afkir',
                    'sisa_ayam' => 'Sisa Ayam',
                    'telur_bagus' => 'Telur Bagus',
                    'telur_reject' => 'Telur Reject'
                ] as $field => $label)

                    <div class="col-md-4 mb-3">

                        <label>{{ $label }}</label>

                        <input
                            type="number"
                            name="{{ $field }}"
                            class="form-control"
                            value="{{ old($field, 0) }}"
                            min="0"
                            step="{{ $field === 'presentase' ? '0.01' : '1' }}"
                            required
                        >

                    </div>

                @endforeach

            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

            <a
                href="{{ route('produksi-telur.index') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection

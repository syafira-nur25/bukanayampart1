@extends('layouts.app')

@section('title', 'Input Laporan Harian')

@section('content')

<div class="row justify-content-center">

    <div class="col-xl-9">

        <div class="mb-4">

            <h3 class="fw-bold mb-1">
                Laporan Harian
            </h3>

            <p class="text-muted mb-0">
                Silakan masukkan data kondisi ayam dan produksi hari ini.
            </p>

        </div>


        @if(session('success'))

            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        <form
            action="{{ route('manpower.laporan.store') }}"
            method="POST"
        >

            @csrf


            <!-- INFORMASI -->

            <div class="panel mb-4">

                <div class="panel-header">

                    <div>

                        <div class="panel-title">
                            Informasi Laporan
                        </div>

                        <div class="text-muted small">
                            Tentukan tanggal, kandang dan umur ayam.
                        </div>

                    </div>

                </div>


                <div class="row g-3">

                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Tanggal
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            class="form-control"
                            value="{{ old('tanggal', date('Y-m-d')) }}"
                            required
                        >

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Umur Ayam
                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                name="umur_minggu"
                                class="form-control"
                                min="0"
                                value="{{ old('umur_minggu') }}"
                                placeholder="Contoh: 25"
                                required
                            >

                            <span class="input-group-text">
                                minggu
                            </span>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Kandang
                        </label>

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
                                    {{ old('kandang_id') == $kandang->id ? 'selected' : '' }}
                                >
                                    {{ $kandang->nama }}
                                    - {{ $kandang->lokasi }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>


            <!-- POPULASI -->

            <div class="panel mb-4">

                <div class="panel-header">

                    <div>

                        <div class="panel-title">
                            Populasi Ayam
                        </div>

                        <div class="text-muted small">
                            Masukkan kondisi populasi ayam.
                        </div>

                    </div>

                </div>


                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Hidup
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-heart-fill text-success"></i>
                            </span>

                            <input
                                type="number"
                                name="hidup"
                                class="form-control"
                                min="0"
                                value="{{ old('hidup', 0) }}"
                                required
                            >

                            <span class="input-group-text">
                                ekor
                            </span>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Mati
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-x-circle text-danger"></i>
                            </span>

                            <input
                                type="number"
                                name="mati"
                                class="form-control"
                                min="0"
                                value="{{ old('mati', 0) }}"
                                required
                            >

                            <span class="input-group-text">
                                ekor
                            </span>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Afkir
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-exclamation-triangle text-warning"></i>
                            </span>

                            <input
                                type="number"
                                name="afkir"
                                class="form-control"
                                min="0"
                                value="{{ old('afkir', 0) }}"
                                required
                            >

                            <span class="input-group-text">
                                ekor
                            </span>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Sisa Ayam
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-people-fill text-primary"></i>
                            </span>

                            <input
                                type="number"
                                name="sisa_ayam"
                                class="form-control"
                                min="0"
                                value="{{ old('sisa_ayam', 0) }}"
                                required
                            >

                            <span class="input-group-text">
                                ekor
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            <!-- PRODUKSI -->

            <div class="panel mb-4">

                <div class="panel-header">

                    <div>

                        <div class="panel-title">
                            Produksi Telur
                        </div>

                        <div class="text-muted small">
                            Masukkan hasil produksi telur hari ini.
                        </div>

                    </div>

                </div>


                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Produksi Telur
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-egg-fill text-warning"></i>
                            </span>

                            <input
                                type="number"
                                name="produksi_telur"
                                class="form-control"
                                min="0"
                                value="{{ old('produksi_telur', 0) }}"
                                required
                            >

                            <span class="input-group-text">
                                butir
                            </span>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Total Telur Pecah
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-egg text-danger"></i>
                            </span>

                            <input
                                type="number"
                                name="telur_pecah"
                                class="form-control"
                                min="0"
                                value="{{ old('telur_pecah', 0) }}"
                                required
                            >

                            <span class="input-group-text">
                                butir
                            </span>

                        </div>

                    </div>


                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Data Tambahan
                        </label>

                        <input
                            type="text"
                            name="column_10"
                            class="form-control"
                            value="{{ old('column_10') }}"
                            placeholder="Opsional"
                        >

                        <div class="form-text">
                            Field ini menggantikan "Column 10" dari form lama.
                        </div>

                    </div>

                </div>

            </div>


            <!-- SUBMIT -->

            <div class="d-flex justify-content-end gap-2">

                <button
                    type="reset"
                    class="btn btn-light px-4"
                >
                    Reset
                </button>

                <button
                    type="submit"
                    class="btn btn-primary px-4"
                >
                    <i class="bi bi-save me-2"></i>
                    Simpan Laporan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection

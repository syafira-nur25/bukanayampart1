@extends('layouts.app')

@section('title', 'Edit Bobot')

@section('content')
<h2 class="mb-3">Edit Bobot Ayam</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('bobot.update', $bobot) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" class="form-select" required>
                        @foreach ($kandangs as $k)
                            <option value="{{ $k->id }}" @selected($bobot->kandang_id == $k->id)>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal', $bobot->tanggal->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Bobot (gram)</label>
                    <input type="number" name="bobot" class="form-control"
                        value="{{ old('bobot', $bobot->bobot) }}" min="0" required>
                </div>
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('bobot.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection

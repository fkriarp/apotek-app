@extends('layouts.template')

@section('content')
    <form action="{{ route('medicine.store') }}" method="post" class="card p-5">
        @csrf

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama Obat :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>  

        <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Jenis Obat :</label>
            <div class="col-sm-10">
                <select class="form-select" name="type" id="type" required>
                    <option value="" disabled hidden>Pilih</option>
                    <option value="tablet" {{ old('type') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="sirup" {{ old('type') == 'sirup' ? 'selected' : '' }}>Sirup</option>
                    <option value="kapsul" {{ old('type') == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                </select>
                @error('type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Harga Obat :</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stok Obat :</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" required>
                @error('stock')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
    </form>
@endsection

@extends('layouts.template')

@section('content')
    <form action="{{ route('user.store') }}" method="post" class="card p-5">
        @csrf

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email :</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                @endif
                @if (Session::get('failed'))
                    <small class="text-danger">{{ Session::get('failed') }}</small>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Tipe pengguna :</label>
            <div class="col-sm-10">
                <select class="form-control" name="role" id="role">
                    <option value= ""  selected disable hidden>Pilih</option>
                    <option value="admin" {{ old('role') =='admin' ? 'selected' : '' }}>Admin</option>
                    <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
                </select>
                @if ($errors->has('role'))
                    <small class="text-danger">{{ $errors->first('role') }}</small>
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Tambah Pengguna</button>
    </form>
@endsection 
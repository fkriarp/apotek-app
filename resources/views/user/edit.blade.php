@extends('layouts.template')

@section('content')
    <form action="{{ route('user.update', $user->id) }}" method="POST" class="card p-5">
        @csrf
        @method('PATCH')

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                @if ($errors->has('name'))
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email :</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                @if ($errors->has('email'))
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                @endif
                @if (Session::get('failed'))
                    <small class="text-danger">{{ Session::get('failed') }}</small>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Tipe Pengguna :</label>
            <div class="col-sm-10">
                <select class="form-control" name="role" id="role">
                    <option value= ""  selected disable hidden>Pilih</option>
                    <option value="admin" {{ $user->role =='admin' ? 'selected' : '' }}>Admin</option>
                    <option value="cashier" {{ $user->role == 'cashier' ? 'selected' : '' }}>Cashier</option>
                </select>
                @if ($errors->has('role'))
                    <small class="text-danger">{{ $errors->first('role') }}</small>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Ubah Password :</label>
            <div class="col-sm-10">
                <input type="password" name="password" id="password" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
    </form>
@endsection 
@extends('layouts.template')

@section('content')
    <form action="{{ route('login.auth') }}" class="card p-5" method="POST">
        @csrf
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        @if (Session::get('logout'))
            <div class="alert alert-primary">{{ Session::get('logout') }}</div>
        @endif
        <h1 class="mb-5">Login</h1>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror 
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control">
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror 
        </div>
        <button type="submit" class="btn btn-primary">LOGIN</button>
    </form>
@endsection
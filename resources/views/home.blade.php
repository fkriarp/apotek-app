@extends('layouts.template')

@section('content')
    @if (Session::get('failed'))
        <div class="alert alert-danger">{{ Session::get('failed') }}</div>
    @endif
    <div class="jumbotron py-4 px-4">
        <h1 class="display-4">Selamat Datang {{ Auth::user()->name }}!</h1>
        <hr class="my-4">
        <p>Aplikasi ini digunakan hanya oleh pegawai administrator APOTEK. Digunakan untuk mengelola data obat, penyetokan, juga pembelian (kasir).</p>
    </div>
@endsection
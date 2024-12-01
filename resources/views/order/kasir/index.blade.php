@extends('layouts.template')

@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-end">
            <a href="{{ route('kasir.order.create') }}" class="btn btn-primary">Pembelian Baru</a>
        </div>
        <table>
            <thead>
                <th>Nama Pembeli</th>
                <th></th>
            </thead>
        </table>
    </div>
@endsection
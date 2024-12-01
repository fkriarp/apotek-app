@extends('layouts.template')

@section('content')
    @if (Session::has('success') || Session::has('deleted'))
        <div class="alert alert-{{ Session::has('success') ? 'success' : 'warning' }}">
            {{ Session::get('success') ?: Session::get('deleted') }}
        </div>
    @endif

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Harga</th>
                <th>Stok</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php  $no = 1; @endphp
            @foreach ($medicines as $index => $item)
                <tr>    
                    <td>{{ ($medicines->currentPage() - 1) * ($medicines->perPage()) + ($index+1) }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->type }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>  
                    <td>{{ $item->stock }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('medicine.edit', $item->id) }}" class="btn btn-primary me-3">Edit</a>
                        <button type="button" class="btn btn-danger" onclick="showModalDelete('{{ $item->id }}', '{{ $item->name }}')">
                            Hapus
                        </button>
                    </td>
                </tr>
            @endforeach
            @if ($medicines->isEmpty())
                <tr>
                    <td class="text-center" colspan="6">Tidak ada data obat</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        {{ $medicines->links() }}
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Data Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus obat <b id="name_medicine"></b>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    @push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            window.showModalDelete = function(id, name) {
                $('#name_medicine').text(name);
                $('#deleteModal').modal('show');
                let url = "{{ route('medicine.delete', ':id') }}";
                url = url.replace(':id', id);
                $('form').attr('action', url);
            }
        });
    </script>
    @endpush
@endsection

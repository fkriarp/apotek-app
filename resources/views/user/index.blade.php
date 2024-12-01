@extends('layouts.template')

@section('content')
    @if (session('success'))
        <div class="alert alert-success"> {{ session('success') }} </div>
    @endif
    @if (session('failed')) 
        <div class="alert alert-danger"> {{ session('failed') }} </div>
    @endif
    <div class="d-flex justify-content-end">
        <a href="{{ route('user.create') }}" class="btn btn-secondary mb-3">Tambah Pengguna</a>  
    </div>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php  $no = 1; @endphp
            @if ($users->isEmpty())
                <tr>
                    <td class="text-center" colspan="5">Tidak ada data pengguna</td>
                </tr>
            @endif
            @foreach ($users as $index => $user)
                <tr>    
                    <td>{{ ($users->currentPage() - 1) * ($users->perPage()) + ($index + 1) }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary me-3">Edit</a>
                        <button type="button"  onclick="showModalDelete('{{ $user->id }}', '{{ $user->name }}')">
                            Hapus
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end">
        {{-- links() : memunculkan button pagination --}}
        {{ $users->links() }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Pengguna</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus pengguna <b id="name_user"></b>?
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
        function showModalDelete(id, name) {
            $('#name_user').text(name);
            $('#deleteModal').modal('show');
            let url = "{{ route('user.delete', ':id') }}";
            url = url.replace(':id', id);
            $('form').attr('action', url);
        }
    </script>
    @endpush
@endsection

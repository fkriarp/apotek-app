@extends('layouts.template')

@section('content')
<div id="msg-success"></div>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Stok</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($medicines as $item)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $item['name'] }}</td>
            <td style="{{ $item['stock'] <= 3 ? 'background: red; color: white;' : 'background: none; color: black;' }}">
                {{ $item['stock'] }}
            </td>
            <td class="d-flex justify-content-center">
                <div onclick="edit({{ $item['id'] }})" class="btn btn-primary me-3" style="cursor: pointer">Tambah Stock</div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal untuk Edit Stok -->
<div class="modal" tabindex="-1" id="edit-stock">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header Modal -->
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form Edit Stok -->
            <form method="POST" id="form-stock">
                <div class="modal-body">
                    <div id="msg"></div> <!-- Pesan Error atau Sukses -->

                    <!-- Input Hidden ID untuk menyimpan ID Obat -->
                    <input type="hidden" name="id" id="id">

                    <!-- Input Nama Obat (disabled) -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Obat:</label>
                        <input type="text" class="form-control" id="name" name="name" disabled>
                    </div>

                    <!-- Input untuk mengubah Stok Obat -->
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok Obat:</label>
                        <input type="number" class="form-control" id="stock" name="stock">
                    </div>
                </div>

                <!-- Footer Modal dengan Tombol Tutup dan Simpan -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function edit(id) {
            var url = "{{ route('medicine.stock.edit', ':id') }}".replace(':id', id);
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                success: function(res) {
                    $('#edit-stock').modal('show');
                    $('#id').val(res.id);
                    $('#name').val(res.name);
                    $('#stock').val(res.stock);
                },
                error: function(xhr) {
                    alert('Gagal memuat data obat. Silakan coba lagi.');
                }
            });
        }

        $('#form-stock').submit(function(e) {
            e.preventDefault();

            var id = $('#id').val();
            var urlForm = "{{ route('medicine.stock.update', ':id') }}".replace(':id', id);

            $.ajax({
                type: 'PATCH',
                url: urlForm,
                data: {
                    stock: $('#stock').val()
                },
                beforeSend: function() {
                    $('#msg').removeClass("alert-danger").addClass("alert alert-info").text("Memproses...");
                },
                success: function() {
                    $('#msg').removeClass("alert-info").addClass("alert alert-success").text("Stok berhasil diperbarui!");
                    $('#edit-stock').modal('hide');
                    sessionStorage.reloadAfterPageLoad = true;
                    window.location.reload();
                },
                error: function(xhr) {
                    $('#msg').removeClass("alert-info").addClass("alert alert-danger");
                    $('#msg').text(xhr.responseJSON.message || 'Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });

        $(function() {
            if (sessionStorage.reloadAfterPageLoad) {
                $('#msg-success').addClass('alert alert-success').text("Berhasil menambahkan data stock!");
                sessionStorage.removeItem("reloadAfterPageLoad");
            }
        });
    </script>
@endpush
@endsection

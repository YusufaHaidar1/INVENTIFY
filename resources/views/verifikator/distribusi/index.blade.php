@extends('layouts2.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
            <div class="card-body">
                @if (@session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (@session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Filter :</label>
                            <div class="col-3">
                                <select name="id_ruang" id="id_ruang" class="form-control" required>
                                    <option value="">- Semua -</option>
                                    @foreach ($ruang as $item)
                                        <option value="{{ $item->id_ruang }}">{{ $item->nama_ruang }}</option>
                                    @endforeach
                                    </select>
                                    <small class="form-text text-muted">Ruangan</small>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-hover table-sm" id="table_distribusi">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Jenis Barang</th>
                            <th>Merk Barang</th>
                            <th>NUP</th>
                            <th>Ruangan</th>
                            <th>Status Awal</th>
                            <th>Status Akhir</th>
                            <th>Tanggal Perubahan</th>
                            <th>Verifikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    </table>
            </div>
    </div>
@endsection

@push('css')
@endpush
@push('js')

<script>
    $(document).ready(function() {
    var dataDistribusi = $('#table_distribusi').DataTable({
        serverSide: true,
        ajax: {
            "url": "{{ url('/verifikator/distribusi/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.id_ruang = $('#id_ruang').val();
            }
        },
        columns: [
            {
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            },
            {
                data: "deskripsi_barang",
                className: "",
                orderable: false,
                searchable: true,
            },
            {
                data: "nama_barang",
                className: "",
                orderable: false,
                searchable: true
            },
            {
                data: "NUP",
                className: "",
                orderable: false,
                searchable: true
            },
            {
                data: "nama_ruang", // Use the key from the formatted data
                className: "",
                orderable: false,
                searchable: false
            },
            {
                data: "status_awal", // Use the key from the formatted data
                className: "",
                orderable: false,
                searchable: true
            },
            {
                data: "status_akhir", // Use the key from the formatted data
                className: "",
                orderable: false,
                searchable: true
            },
            {
                data: "tanggal_perubahan",
                className: "",
                orderable: true,
                searchable: false,
                render: function(data, type, row) {
                    if (data === '' || data === null) {
                        return "Belum diubah";
                    } else {
                        return data;
                    }
                }
            },
            {
                data: "user", // Use the key from the formatted data
                className: "",
                orderable: false,
                searchable: true,
                render: function(data, type, row) {
                    if (data === '') {
                        return "Belum diverifikasi";
                    } else {
                        return data;
                    }
                }
            },
            {
                data: "aksi",
                className: "",
                orderable: false,
                searchable: false
            }
        ]
    });

    $('#id_ruang').on('change', function() {
        dataDistribusi.ajax.reload();
    });
});
</script>
@endpush
@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('/admin/distribusi/create')}}">Tambah</a>
            </div>
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
                            <th>Nama Barang</th>
                            <th>NUP</th>
                            <th>Ruangan</th>
                            <th>Status Awal</th>
                            <th>Status Akhir</th>
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
            serverSide: true, // serverSide: true, jika ingin menggunakan server side processing
            ajax: {
            "url": "{{ url('/admin/distribusi/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function ( d ) {
                d.id_ruang = $('#id_ruang').val();
            }
            },
            columns: [
                {
                data: "DT_RowIndex", // nomor urut dari laravel datatable addIndexColumn()
                className: "text-center",
                orderable: false,
                searchable: false
                },
                {
                data: "barang.nama_barang",
                className: "",
                orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "barang.NUP",
                className: "",
                orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "ruang.nama_ruang",
                className: "",
                orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "status_awal.nama_status",
                className: "",
                orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "status_akhir.nama_status",
                className: "",
                orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "aksi",
                className: "",
                orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                }
            ]
        });
        $('#id_ruang').on('change', function() {
            dataDistribusi.ajax.reload();
        });
    });
</script>
@endpush
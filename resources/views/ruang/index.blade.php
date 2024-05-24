@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('/admin/ruang/create')}}">Tambah</a>
            </div>
        </div>
            <div class="card-body">
                @if (@session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (@session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <table class="table table-bordered table-striped table-hover table-sm" id="table_ruang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Ruangan</th>
                        <th>Nama Ruangan</th>
                        <th>Penanggung Jawab</th>
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
        var dataRuang = $('#table_ruang').DataTable({
            serverSide: true, // serverSide: true, jika ingin menggunakan server side processing
            ajax: {
            "url": "{{ url('/admin/ruang/list') }}",
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
                data: "kode_ruang",
                className: "",
                orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "nama_ruang",
                className: "",
                orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "penanggung_jawab",
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
            dataRuang.ajax.reload();
        });
    });
</script>
@endpush
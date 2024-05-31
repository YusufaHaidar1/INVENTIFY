@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('/admin/barang/create')}}">Tambah</a>
                <button id="downloadButton" class="btn btn-sm btn-success mt-1">Download</button>
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
                            <select name="id_kode_barang" id="id_kode_barang" class="form-control" required>
                                <option value="">- Semua -</option>
                                @foreach ($kode as $item)
                                    <option value="{{ $item->id_kode_barang }}">{{ $item->deskripsi_barang }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Barang</small>
                        </div>
                        <div class="col-3">
                            <select name="id_user" id="id_user" class="form-control" required>
                                <option value="">- Semua -</option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Admin Pengelola</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Admin Pengelola</th>
                        <th>Kode Barang</th>
                        <th>Merk Barang</th>
                        <th>NUP</th>
                        <th>Satuan</th>
                        <th>Harga Perolehan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    <!-- Ensure this tbody is populated with data -->
                </tbody> --}}
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    document.getElementById('downloadButton').addEventListener('click', function() {
        // Get the original table
        var originalTable = document.getElementById('table_barang');
        
        // Create a new table element
        var newTable = document.createElement('table');
        var newThead = document.createElement('thead');
        var newTbody = document.createElement('tbody');
        
        // Copy the header row, excluding the last cell ("Aksi")
        var originalThead = originalTable.querySelector('thead');
        var originalHeaderRow = originalThead.rows[0];
        var newHeaderRow = newThead.insertRow(0);
        for (var i = 0; i < originalHeaderRow.cells.length - 1; i++) {
            var newCell = newHeaderRow.insertCell(i);
            newCell.innerHTML = originalHeaderRow.cells[i].innerHTML;
        }
        newTable.appendChild(newThead);
        
        // Copy the body rows, excluding the last cell ("Aksi")
        var originalTbody = originalTable.querySelector('tbody');
        for (var i = 0; i < originalTbody.rows.length; i++) {
            var originalRow = originalTbody.rows[i];
            var newRow = newTbody.insertRow(i);
            for (var j = 0; j < originalRow.cells.length - 1; j++) {
                var newCell = newRow.insertCell(j);
                newCell.innerHTML = originalRow.cells[j].innerHTML;
            }
        }
        newTable.appendChild(newTbody);

        // Create a new workbook and a worksheet from the new table
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.table_to_sheet(newTable);

        // Append the worksheet to the workbook
        XLSX.utils.book_append_sheet(wb, ws, 'Table Data');

        // Generate a file
        XLSX.writeFile(wb, 'table_data.xlsx');
    });
</script>

<script>
    $(document).ready(function() {
        var dataBarang = $('#table_barang').DataTable({
            serverSide: true, // serverSide: true, jika ingin menggunakan server side processing
            ajax: {
            "url": "{{ url('/admin/barang/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function ( d ) {
                d.id_kode_barang = $('#id_kode_barang').val();
                d.id_user = $('#id_user').val();
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
                data: "user.nama",
                className: "",
                orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "kode.kode_barang",
                className: "",
                orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "nama_barang",
                className: "",
                orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "NUP",
                className: "",
                orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "kode.satuan",
                className: "",
                orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "harga_perolehan",
                className: "",
                orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                data: "aksi",
                className: "",
                orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                }
            ]
        });

        $('#id_kode_barang').on('change', function() {
            dataBarang.ajax.reload();
        });
        $('#id_user').on('change', function() {
            dataBarang.ajax.reload();
        });
    });
</script>
@endpush
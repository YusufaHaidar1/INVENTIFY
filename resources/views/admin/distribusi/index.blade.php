@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('/admin/distribusi/create')}}">Tambah</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    document.getElementById('downloadButton').addEventListener('click', function() {
        // Get the original table
        var originalTable = document.getElementById('table_distribusi');
        
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
        XLSX.writeFile(wb, 'table_distribusi.xlsx');
    });
</script>

<script>
    $(document).ready(function() {
    var dataDistribusi = $('#table_distribusi').DataTable({
        serverSide: true,
        ajax: {
            "url": "{{ url('/admin/distribusi/list') }}",
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
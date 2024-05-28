@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('/admin/barang') }}" class="form-horizontal">
            @csrf
            <!-- Dynamic form fields -->
            <div id="dynamicForms">
                <!-- Initial form fields -->
                <div class="dynamicForm">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kode & Deskripsi Barang</label>
                        <div class="col-11">
                            <select class="form-control" name="id_kode_barang[]" required>
                                <option value="">- Pilih Kode & Deskripsi Barang -</option>
                                @foreach($kode as $item)
                                    <option value="{{ $item->id_kode_barang }}">{{ $item->kode_barang}} - {{ $item->deskripsi_barang}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('id_kode_barang.*'))
                                <small class="form-text text-danger">{{ $errors->first('id_kode_barang.*') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Merk Barang</label>
                        <div class="col-11">
                            <input type="text" class="form-control" name="nama_barang[]" value="{{ old('nama_barang.0') }}" required>
                            @if ($errors->has('nama_barang.*'))
                                <small class="form-text text-danger">{{ $errors->first('nama_barang.*') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Harga Perolehan</label>
                        <div class="col-11">
                            <input type="text" class="form-control" name="harga_perolehan[]" value="{{ old('harga_perolehan.0') }}" required>
                            @if ($errors->has('harga_perolehan.*'))
                                <small class="form-text text-danger">{{ $errors->first('harga_perolehan.*') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of dynamic form fields -->
            
            <div class="">
                <div class="col-lg-12">
                    <button id="rowAdder" type="button" class="btn btn-primary">
                        <span class="bi bi-plus-square-dotted"></span> Tambah Barang
                    </button>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('/admin/barang') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    document.getElementById('rowAdder').addEventListener('click', function() {
        // Clone the dynamic form fields
        var dynamicForm = document.querySelector('.dynamicForm');
        var clone = dynamicForm.cloneNode(true);

        // Remove any existing delete button from the cloned form to avoid duplicates
        var existingDeleteButton = clone.querySelector('.btn-danger');
        if (existingDeleteButton) {
            existingDeleteButton.remove();
        }

        // Create a delete button
        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'btn btn-danger btn-sm';
        deleteButton.innerText = 'Delete';
        deleteButton.style.marginTop = '10px';
        
        // Add delete button event listener
        deleteButton.addEventListener('click', function() {
            this.closest('.dynamicForm').remove();
        });

        // Append the delete button to the cloned form
        clone.appendChild(deleteButton);

        // Add a horizontal rule for separation
        var hr = document.createElement('hr');
        clone.appendChild(hr);

        // Append the cloned form to the dynamicForms container
        document.getElementById('dynamicForms').appendChild(clone);
    });
</script>
@endpush
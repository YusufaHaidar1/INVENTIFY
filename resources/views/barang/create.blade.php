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
                        @error('id_kode_barang')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Admin Pencatatan</label>
                    <div class="col-11">
                        <select class="form-control" name="id_user[]" required>
                            <option value="">- Pilih User -</option>
                            @foreach($user as $item)
                                <option value="{{ $item->id_user }}">{{ $item->nama}}</option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Merk Barang</label>
                    <div class="col-11">
                        <input type="text" class="form-control" name="nama_barang[]" value="{{ old('nama_barang') }}" required>
                        @error('nama_barang')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">NUP</label>
                    <div class="col-11">
                        <input type="number" class="form-control" name="NUP[]" value="{{ old('NUP') }}" required>
                        @error('NUP')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Harga Perolehan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" name="harga_perolehan[]" value="{{ old('harga_perolehan') }}" required>
                        @error('harga_perolehan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Tanggal Pencatatan</label>
                    <div class="col-11">
                        <input type="datetime-local" class="form-control" name="tanggal_pencatatan[]" required>
                        @error('tanggal_pencatatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
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
</div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    document.getElementById('rowAdder').addEventListener('click', function() {
        // Clone the dynamic form fields and add separation
        var dynamicForm = document.querySelector('.dynamicForm');
        var clone = dynamicForm.cloneNode(true);
        clone.innerHTML += '<hr>'; // Add separation
        document.getElementById('dynamicForms').appendChild(clone);
    });
</script>
@endpush
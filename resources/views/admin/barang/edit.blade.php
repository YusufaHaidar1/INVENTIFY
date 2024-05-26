@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools"></div>
    </div>
    <div class="card-body">
    @empty($barang)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
        </div>
        <a href="{{ url('/admin/barang') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
        <form method="POST" action="{{ url('/admin/barang/'.$barang->id_barang) }}" class="form-horizontal">
            @csrf
            {!! method_field('PUT')!!}
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Kode & Deskripsi Barang</label>
                <div class="col-11">
                    <select class="form-control" id="id_kode_barang" name="id_kode_barang" required>
                        <option value="">- Pilih Kode & Deskripsi Barang -</option>
                    @foreach($kode as $item)
                        <option value="{{ $item->id_kode_barang }}" @if($item->id_kode_barang == $barang->id_kode_barang) selected @endif>{{ $item->kode_barang}} - {{ $item->deskripsi_barang}}</option>
                    @endforeach
                    </select>
                    @error('id_kode_barang')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Nama Barang</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ old('nama', $barang->nama_barang) }}" required>
                @error('nama_barang')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">NUP</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="NUP" name="NUP" value="{{ old('NUP', $barang->NUP) }}" required>
                @error('NUP')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Harga Perolehan</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="harga_perolehan" name="harga_perolehan" value="{{ old('harga_perolehan', $barang->harga_perolehan) }}" required>
                @error('harga_perolehan')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('/admin/barang') }}">Kembali</a>
                </div>
            </div>
        </form>
        @endempty
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
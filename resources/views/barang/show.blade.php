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
        @else
    <table class="table table-bordered table-striped table-hover tablesm">
        <tr>
            <th>ID</th>
            <td>{{ $barang->id_barang }}</td>
        </tr>
        <tr>
            <th>Admin Pengelola</th>
            <td>{{ $barang->user->nama }}</td>
        </tr>
        <tr>
            <th>Kode Barang</th>
            <td>{{ $barang->kode->kode_barang }}</td>
        </tr>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>NUP</th>
            <td>{{ $barang->NUP }}</td>
        </tr>
        <tr>
            <th>Satuan</th>
            <td>{{ $barang->kode->satuan }}</td>
        </tr>
        <tr>
            <th>Harga Perolehan</th>
            <td>{{ $barang->harga_perolehan }}</td>
        </tr>
        <tr>
            <th>Tanggal Pencatatan</th>
            <td>{{ $barang->tanggal_pencatatan }}</td>
        </tr>
        </table>
    @endempty
    <a href="{{ url('/admin/barang') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
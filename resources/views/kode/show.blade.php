@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools"></div>
    </div>
    <div class="card-body">
    @empty($kode)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
        </div>
        @else
    <table class="table table-bordered table-striped table-hover tablesm">
        <tr>
            <th>ID</th>
            <td>{{ $kode->id_kode_barang }}</td>
        </tr>
        <tr>
            <th>Kode Barang</th>
            <td>{{ $kode->kode_barang }}</td>
        </tr>
        <tr>
            <th>Satuan Barang</th>
            <td>{{ $kode->satuan }}</td>
        </tr>
        <tr>
            <th>Deskripsi Barang</th>
            <td>{{ $kode->deskripsi_barang }}</td>
        </tr>
        </table>
    @endempty
    <a href="{{ url('kode') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools"></div>
    </div>
    <div class="card-body">
    @empty($distribusi)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
        </div>
        @else
    <table class="table table-bordered table-striped table-hover tablesm">
        <tr>
            <th>ID</th>
            <td>{{ $distribusi->id_distribusi }}</td>
        </tr>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $distribusi->barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>NUP Barang</th>
            <td>{{ $distribusi->barang->NUP }}</td>
        </tr>
        <tr>
            <th>Ruangan</th>
            <td>{{ $distribusi->ruang->nama_ruang }}</td>
        </tr>
        <tr>
            <th>Penanggung Jawab Ruangan</th>
            <td>{{ $distribusi->ruang->penanggung_jawab }}</td>
        </tr>
        <tr>
            <th>Kondisi Awal</th>
            <td>{{ $distribusi->statusAwal->nama_status }}</td>
        </tr>
        <tr>
            <th>Kondisi Akhir</th>
            <td>{{ $distribusi->statusAkhir->nama_status }}</td>
        </tr>
        </table>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover table-sm" id="table_distribusi">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Tanggal Perubahan</th>
                        <th>Status Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log['tahun'] }}</td>
                            <td>{{ $log['tanggal_perubahan'] }}</td>
                            <td>{{ $log['status_akhir'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Belum ada Perubahan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endempty
    <a href="{{ url('/admin/distribusi') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
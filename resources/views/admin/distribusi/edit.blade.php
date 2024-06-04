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
        <a href="{{ url('/admin/distribusi') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
        <form method="POST" action="{{ url('/admin/distribusi/'.$distribusi->id_distribusi) }}" class="form-horizontal">
            @csrf
            {!! method_field('PUT')!!}
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Barang</label>
                <div class="col-11">
                    <select class="form-control" id="id_barang" name="id_barang" required>
                        <option value="">- Pilih Jenis Barang & NUP & Merk Barang -</option>
                    @foreach($barang as $item)
                        <option value="{{ $item->id_barang }}" @if($item->id_barang == $distribusi->id_barang) selected @endif>{{ $item->kode->deskripsi_barang }} - {{ $item->NUP }} - {{ $item->nama_barang }}</option>
                    @endforeach
                    </select>
                    @error('id_barang')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Ruang</label>
                <div class="col-11">
                    <select class="form-control" id="id_ruang" name="id_ruang" required>
                        <option value="">- Pilih Ruang -</option>
                    @foreach($ruang as $item)
                        <option value="{{ $item->id_ruang }}" @if($item->id_ruang == $distribusi->id_ruang) selected @endif>{{ $item->kode_ruang}} - {{ $item->nama_ruang}}</option>
                    @endforeach
                    </select>
                    @error('id_ruang')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Status Awal</label>
                <div class="col-11">
                    <select class="form-control" id="id_detail_status_awal" name="id_detail_status_awal" required>
                        <option value="">- Pilih Status Awal -</option>
                    @foreach($statusAwal as $item)
                        <option value="{{ $item->id_detail_status }}" @if($item->id_detail_status == $distribusi->id_detail_status_awal) selected @endif>{{ $item->kode_status}} - {{ $item->nama_status}}</option>
                    @endforeach
                    </select>
                    @error('id_detail_status_awal')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Status Akhir</label>
                <div class="col-11">
                    <select class="form-control" id="id_detail_status_akhir" name="id_detail_status_akhir" disabled>
                        <option value="">- Pilih Status Akhir -</option>
                    @foreach($statusAkhir as $item)
                        <option value="{{ $item->id_detail_status }}" @if($item->id_detail_status == $distribusi->id_detail_status_akhir) selected @endif>{{ $item->kode_status}} - {{ $item->nama_status}}</option>
                    @endforeach
                    </select>
                    @error('id_detail_status_akhir')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('/admin/distribusi') }}">Kembali</a>
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
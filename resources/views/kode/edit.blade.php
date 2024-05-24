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
        <a href="{{ url('/admin/kode') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
        <form method="POST" action="{{ url('/admin/kode/'.$kode->id_kode_barang) }}" class="form-horizontal">
            @csrf
            {!! method_field('PUT')!!}
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Kode Barang</label>
                <div class="col-11">
                    <input type="number" class="form-control" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $kode->kode_barang) }}" required>
                @error('kode_barang')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Satuan Barang</label>
                <div class="col-11">
                    <select class="form-control" id="satuan" name="satuan" required>
                        <option value="Buah" <?php echo ($kode->satuan == 'Buah') ? 'selected' : ''; ?>>Buah</option>
                        <option value="Ekor" <?php echo ($kode->satuan == 'Ekor') ? 'selected' : ''; ?>>Ekor</option>
                        <option value="M2" <?php echo ($kode->satuan == 'M2') ? 'selected' : ''; ?>>M2</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Deskripsi Barang</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="deskripsi_barang" name="deskripsi_barang" value="{{ old('deskripsi_barang', $kode->deskripsi_barang) }}" required>
                @error('deskripsi_barang')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('/admin/kode') }}">Kembali</a>
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
@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row justify-content-center">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $user_count }}</h3>

            <p>Jumlah Pegawai</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="http://localhost/INVENTIFY/public/admin/user" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $barang_count }}</h3>

            <p>Jumlah Barang</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="http://localhost/INVENTIFY/public/admin/barang" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $distribusi_count }}</h3>

            <p>Barang yang telah terdistribusi</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="http://localhost/INVENTIFY/public/admin/distribusi" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $barang_belum_terdistribusi }}</h3>

            <p>Barang yang belum terdistribusi (Gudang JTI)</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Dashboard <?php echo (Auth::user()->id_role == 1) ? 'Admin' : 'Verifikator'; ?>
            </div>
            <div class="card-body">
                <h2>
                    Selamat Datang <?php echo (Auth::user()->nama)?>
                </h2>
                <a>
                  Anda Login sebagai <?php echo (Auth::user()->id_role == 1) ? 'Admin' : 'Verifikator'; ?>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
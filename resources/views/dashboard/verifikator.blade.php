@extends('layouts2.template')

@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row justify-content-center">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $distribusi_count }}</h3>

            <p>Jumlah Barang yang telah Terdistribusi</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="http://localhost/INVENTIFY/public/verifikator/distribusi" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $distribusi_count_baik }}</h3>
            <p>Jumlah Barang (Status Baik)</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $distribusi_count_ringan }}</h3>
            <p>Jumlah Barang (Status Rusak Ringan)</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ $distribusi_count_berat }}</h3>
            <p>Jumlah Barang (Status Rusak Berat)</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Tampilan <?php echo (Auth::user()->id_role == 1) ? 'Admin' : 'Verifikator'; ?>
            </div>
            <div class="card-body">
                <h1>
                    Login sebagai <?php echo (Auth::user()->id_role == 1) ? 'Admin' : 'Verifikator'; ?>
                </h1>
                <a href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
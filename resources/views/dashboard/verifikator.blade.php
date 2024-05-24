@extends('layouts2.template')

@section('content')
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
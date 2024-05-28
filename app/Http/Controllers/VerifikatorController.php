<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\DistribusiModel;

class VerifikatorController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Verifikator Dashboard',
            'list' => ['Home', 'Verifikator']
        ];

        $page = (object) [
            'title' => 'Verifikator Dashboard'
        ];

        $activeMenu = 'dashboard'; // set menu yang sedang aktif
        $distribusi_count = DistribusiModel::count();
        $distribusi_count_baik = DistribusiModel::where('id_detail_status_akhir', 1)->count();
        $distribusi_count_ringan = DistribusiModel::where('id_detail_status_akhir', 2)->count();
        $distribusi_count_berat = DistribusiModel::where('id_detail_status_akhir', 3)->count();

        return view('dashboard.verifikator', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu,
            'distribusi_count' => $distribusi_count,
            'distribusi_count_baik' => $distribusi_count_baik,
            'distribusi_count_ringan' => $distribusi_count_ringan,
            'distribusi_count_berat' => $distribusi_count_berat]);
    }
}

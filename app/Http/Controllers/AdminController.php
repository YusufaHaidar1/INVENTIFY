<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\BarangModel;
use App\Models\DistribusiModel;

class AdminController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Admin Dashboard',
            'list' => ['Home', 'Admin']
        ];

        $page = (object) [
            'title' => 'Admin Dashboard'
        ];

        $user_count = UserModel::count();
        $barang_count = BarangModel::count();
        $distribusi_count = DistribusiModel::count();

        $activeMenu = 'dashboard'; // set menu yang sedang aktif

        return view('dashboard.admin', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu, 
            'user_count' => $user_count, 
            'barang_count' => $barang_count,
            'distribusi_count' => $distribusi_count]);
    }
}

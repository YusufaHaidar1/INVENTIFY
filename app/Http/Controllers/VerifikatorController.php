<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        return view('dashboard.verifikator', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $activeMenu = 'dashboard'; // set menu yang sedang aktif

        return view('dashboard.admin', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
}

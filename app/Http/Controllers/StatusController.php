<?php

namespace App\Http\Controllers;

use App\Models\StatusModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StatusController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Status Barang',
            'list' => ['Home', 'Status']
        ];

        $page = (object)[
            'title' => 'Daftar Status Barang',
        ];

        $activeMenu = 'status';

        return view('admin.status.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $statuss = StatusModel::select('id_detail_status', 'kode_status', 'nama_status');

        return DataTables::of($statuss)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($status) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/admin/status/' . $status->id_detail_status) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/admin/status/' . $status->id_detail_status . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admin/status/' . $status->id_detail_status) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah Status Barang',
            'list' => ['Home', 'Status', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Status Barang Baru',
        ];

        $activeMenu = 'status';

        return view('admin.status.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request){
        $request->validate([
            'kode_status'       =>'required|unique:detail_status_barang,kode_status',
            'nama_status'       =>'required|string'
        ]);

        StatusModel::create([
            'kode_status'       => $request->kode_status,
            'nama_status'       => $request->nama_status
        ]);

        return redirect('/admin/status')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(string $id){
        $status = StatusModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Status Barang',
            'list' => ['Home', 'Status', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Status Barang',
        ];

        $activeMenu = 'status';

        return view('admin.status.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'status' => $status, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id){
        $status = StatusModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Status Barang',
            'list' => ['Home', 'Status', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Status',
        ];

        $activeMenu = 'status';

        return view('admin.status.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'status' => $status, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'kode_status'       =>'required|unique:detail_status_barang,kode_status,'. $id . ',id_detail_status',
            'nama_status'       =>'required|string'
        ]);

        StatusModel::find($id)->update([
            'kode_status'       => $request->kode_status,
            'nama_status'       => $request->nama_status
        ]);

        return redirect('/admin/status')->with('success', 'Data berhasil diubah!');;
    }

    public function destroy($id)
    {
        $check = StatusModel::find($id);
        if(!$check){
            return redirect('/admin/status')->with('error', 'Data tidak ditemukan!');
        }

        try{
            StatusModel::destroy($id);
            return redirect('/admin/status')->with('success', 'Data berhasil dihapus!');
        }catch(\Illuminate\Database\QueryException $e){
            return redirect('/admin/status')->with('error', 'Data gagal dihapus! masih terdapat tabel lain yang terikat dengan data ini!');
        }
    }
}


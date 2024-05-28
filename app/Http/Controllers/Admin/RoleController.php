<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Role',
            'list' => ['Home', 'Role']
        ];

        $page = (object)[
            'title' => 'Daftar Role',
        ];

        $activeMenu = 'role';

        return view('admin.role.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $roles = RoleModel::select('id_role', 'kode_role', 'nama_role');

        return DataTables::of($roles)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama_role kolom: DT_RowIndex)
            ->addColumn('aksi', function ($role) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/admin/role/' . $role->id_role) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/admin/role/' . $role->id_role . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admin/role/' . $role->id_role) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah Role',
            'list' => ['Home', 'Role', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Role Baru',
        ];

        $activeMenu = 'role';

        return view('admin.role.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request){
        $request->validate([
            'kode_role' =>'required | string | unique:role,kode_role',
            'nama_role' =>'required | string | max:100',
        ]);

        RoleModel::create([
            'kode_role' => $request->kode_role,
            'nama_role' => $request->nama_role,
        ]);

        return redirect('/admin/role')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(string $id){
        $role = RoleModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Role',
            'list' => ['Home', 'Role', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Role',
        ];

        $activeMenu = 'role';

        return view('admin.role.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'role' => $role, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id){
        $role = RoleModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Role',
            'list' => ['Home', 'Role', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Role',
        ];

        $activeMenu = 'role';

        return view('admin.role.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'role' => $role, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'kode_role' => 'required|string|unique:role,kode_role,' . $id . ',id_role',
            'nama_role' => 'required|string|max:100',
        ]);

        RoleModel::find($id)->update([
            'kode_role' => $request->kode_role,
            'nama_role' => $request->nama_role,
        ]);

        return redirect('/admin/role')->with('success', 'Data berhasil diubah!');;
    }

    public function destroy($id)
    {
        $check = RoleModel::find($id);
        if(!$check){
            return redirect('/admin/role')->with('error', 'Data tidak ditemukan!');
        }

        try{
            RoleModel::destroy($id);
            return redirect('/admin/role')->with('success', 'Data berhasil dihapus!');
        }catch(\Illuminate\Database\QueryException $e){
            return redirect('/admin/role')->with('error', 'Data gagal dihapus! masih terdapat tabel lain yang terikat dengan data ini!');
        }
    }
}


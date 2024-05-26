<?php

namespace App\Http\Controllers;

use App\Models\KodeBarangModel;
use App\Models\RuangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RuangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Ruang JTI',
            'list' => ['Home', 'Ruang']
        ];

        $page = (object)[
            'title' => 'Daftar Ruang JTI',
        ];

        $activeMenu = 'ruang';
        $ruang = RuangModel::all();

        return view('admin.ruang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'ruang' => $ruang, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $ruangs = RuangModel::select('id_ruang', 'kode_ruang', 'nama_ruang', 'nip', 'penanggung_jawab');

        return DataTables::of($ruangs)
            ->addIndexColumn() // menambahkan kolom index / no urut (default deskripsi_barang kolom: DT_RowIndex)
            ->addColumn('aksi', function ($ruang) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/admin/ruang/' . $ruang->id_ruang) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/admin/ruang/' . $ruang->id_ruang . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admin/ruang/' . $ruang->id_ruang) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah Ruang JTI',
            'list' => ['Home', 'Ruang', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Data Ruang Baru',
        ];

        $activeMenu = 'ruang';

        return view('admin.ruang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request){
        $request->validate([
            'kode_ruang'       =>'required | string | unique:ruang,kode_ruang',
            'nama_ruang'       =>'required | string ',
            'nip'              =>'required | string ',
            'penanggung_jawab' =>'required | string ',
        ]);

        RuangModel::create([
            'kode_ruang'        => $request->kode_ruang,
            'nama_ruang'        => $request->nama_ruang,
            'nip'               => $request->nip,
            'penanggung_jawab'  => $request->penanggung_jawab
        ]);

        return redirect('/admin/ruang')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(string $id){
        $ruang = RuangModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Ruang JTI',
            'list' => ['Home', 'Ruang', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Ruang JTI',
        ];

        $activeMenu = 'ruang';

        return view('admin.ruang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'ruang' => $ruang, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id){
        $ruang = RuangModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Data Ruang JTI',
            'list' => ['Home', 'Ruang', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Data Ruang JTI',
        ];

        $activeMenu = 'ruang';

        return view('admin.ruang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'ruang' => $ruang, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'kode_ruang'       =>'required | string | unique:ruang,kode_ruang,' . $id . ',id_ruang',
            'nama_ruang'       =>'required | string ',
            'nip'              =>'required | string ',
            'penanggung_jawab' =>'required | string ',
        ]);

        RuangModel::find($id)->update([
            'kode_ruang'        => $request->kode_ruang,
            'nama_ruang'        => $request->nama_ruang,
            'nip'               => $request->nip,
            'penanggung_jawab'  => $request->penanggung_jawab
        ]);

        return redirect('/admin/ruang')->with('success', 'Data berhasil diubah!');;
    }

    public function destroy($id)
    {
        $check = RuangModel::find($id);
        if(!$check){
            return redirect('/admin/ruang')->with('error', 'Data tidak ditemukan!');
        }

        try{
            RuangModel::destroy($id);
            return redirect('/admin/ruang')->with('success', 'Data berhasil dihapus!');
        }catch(\Illuminate\Database\QueryException $e){
            return redirect('/admin/ruang')->with('error', 'Data gagal dihapus! masih terdapat tabel lain yang terikat dengan data ini!');
        }
    }
}


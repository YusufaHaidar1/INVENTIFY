<?php

namespace App\Http\Controllers;

use App\Models\KodeBarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KodeBarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Kode Barang',
            'list' => ['Home', 'Kode Barang']
        ];

        $page = (object)[
            'title' => 'Daftar Kode Barang',
        ];

        $activeMenu = 'kode';

        return view('kode.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $kodes = KodeBarangModel::select('id_kode_barang', 'kode_barang', 'satuan', 'deskripsi_barang');

        return DataTables::of($kodes)
            ->addIndexColumn() // menambahkan kolom index / no urut (default deskripsi_barang kolom: DT_RowIndex)
            ->addColumn('aksi', function ($kode) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/admin/kode/' . $kode->id_kode_barang) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/admin/kode/' . $kode->id_kode_barang . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admin/kode/' . $kode->id_kode_barang) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah Kode Barang',
            'list' => ['Home', 'Kode Barang', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Kode Barang Baru',
        ];

        $activeMenu = 'kode';

        return view('kode.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request){
        $request->validate([
            'kode_barang' =>'required | string | unique:detail_kode_barang,kode_barang',
            'satuan' =>'required | string ',
            'deskripsi_barang' =>'required | string ',
        ]);

        KodeBarangModel::create([
            'kode_barang' => $request->kode_barang,
            'satuan' => $request->satuan,
            'deskripsi_barang' => $request->deskripsi_barang,
        ]);

        return redirect('/admin/kode')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(string $id){
        $kode = KodeBarangModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Kode Barang',
            'list' => ['Home', 'Kode Barang', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Kode Barang',
        ];

        $activeMenu = 'kode';

        return view('kode.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kode' => $kode, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id){
        $kode = KodeBarangModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Kode Barang',
            'list' => ['Home', 'Kode Barang', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Kode Barang',
        ];

        $activeMenu = 'kode';

        return view('kode.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kode' => $kode, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'kode_barang' => 'required|string|unique:detail_kode_barang,kode_barang,' . $id . ',id_kode_barang',
            'satuan' => 'required|string',
            'deskripsi_barang' => 'required|string',
        ]);

        KodeBarangModel::find($id)->update([
            'kode_barang' => $request->kode_barang,
            'satuan' => $request->satuan,
            'deskripsi_barang' => $request->deskripsi_barang,
        ]);

        return redirect('/admin/kode')->with('success', 'Data berhasil diubah!');;
    }

    public function destroy($id)
    {
        $check = KodeBarangModel::find($id);
        if(!$check){
            return redirect('/admin/kode')->with('error', 'Data tidak ditemukan!');
        }

        try{
            KodeBarangModel::destroy($id);
            return redirect('/admin/kode')->with('success', 'Data berhasil dihapus!');
        }catch(\Illuminate\Database\QueryException $e){
            return redirect('/admin/kode')->with('error', 'Data gagal dihapus! masih terdapat tabel lain yang terikat dengan data ini!');
        }
    }
}


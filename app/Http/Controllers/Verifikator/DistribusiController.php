<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;

use App\Models\BarangModel;
use App\Models\DistribusiModel;
use App\Models\RuangModel;
use App\Models\StatusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DistribusiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Distribusi Barang JTI',
            'list' => ['Home', 'Distribusi']
        ];

        $page = (object)[
            'title' => 'Daftar Distribusi Barang JTI',
        ];

        $activeMenu = 'distribusi';
        $statusAwal = StatusModel::all();
        $statusAkhir = StatusModel::all();
        $ruang = RuangModel::all();
        $barang = BarangModel::all();

        return view('verifikator.distribusi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'ruang' => $ruang, 'barang' => $barang, 'statusAwal' => $statusAwal, 'statusAkhir' => $statusAkhir, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $distribusis = DistribusiModel::select('id_distribusi', 'detail_distribusi_barang.id_barang', 'id_ruang', 'id_detail_status_awal', 'id_detail_status_akhir')
                        ->with('barang.kode')
                        ->with('ruang')
                        ->with('statusAwal')
                        ->with('statusAkhir');


        if ($request->id_barang) {
            $distribusis->where('id_barang', $request->id_barang);
        }

        if ($request->id_ruang) {
            $distribusis->where('id_ruang', $request->id_ruang);
        }
        
        if ($request->id_detail_status) {
            $distribusis->whereHas('detail_status', function ($query) use ($request) {
                $query->where('id', $request->id_detail_status);
            });
        }

        $data = $distribusis->get()->map(function ($distribusi) {
            return [
                'id_distribusi' => $distribusi->id_distribusi,
                'id_barang' => $distribusi->id_barang,
                'id_ruang' => $distribusi->id_ruang,
                'id_detail_status_awal' => $distribusi->id_detail_status_awal,
                'id_detail_status_akhir' => $distribusi->id_detail_status_akhir,
                'deskripsi_barang' => $distribusi->barang->kode->deskripsi_barang ?? '',
                'nama_barang' => $distribusi->barang->nama_barang ?? '', // Add this line
                'NUP' => $distribusi->barang->NUP ?? '', // Add this line
                'nama_ruang' => $distribusi->ruang->nama_ruang ?? '',
                'status_awal' => $distribusi->statusAwal->nama_status ?? '',
                'status_akhir' => $distribusi->statusAkhir->nama_status ?? '',
            ];
        });
    
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($distribusi) {
                $btn = '<a href="' . url('/verifikator/distribusi/' . $distribusi['id_distribusi'] . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show(string $id){
        $distribusi = DistribusiModel::with('ruang')->with('barang')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Distribusi Barang JTI',
            'list' => ['Home', 'Distribusi', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Distribusi Barang JTI',
        ];

        $activeMenu = 'distribusi';

        return view('verifikator.distribusi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'distribusi' => $distribusi, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id){
        $distribusi = DistribusiModel::find($id);
        $ruang = RuangModel::all();
        $barang = BarangModel::all();
        $statusAwal = StatusModel::all();
        $statusAkhir = StatusModel::all();

        $breadcrumb = (object)[
            'title' => 'Edit Data Distribusi Barang JTI',
            'list' => ['Home', 'Distribusi', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Data Distribusi Barang JTI',
        ];

        $activeMenu = 'distribusi';

        return view('verifikator.distribusi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'ruang' => $ruang, 'barang' => $barang, 'statusAwal' => $statusAwal, 'statusAkhir' => $statusAkhir, 'distribusi' => $distribusi, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'id_detail_status_akhir'  =>'required|integer:detail_distribusi_barang,' .$id. ',id_distribusi',
        ]);

        DistribusiModel::find($id)->update([
            'id_detail_status_akhir' => $request->id_detail_status_akhir
        ]);

        return redirect('/verifikator/distribusi')->with('success', 'Data berhasil diubah!');;
    }
}


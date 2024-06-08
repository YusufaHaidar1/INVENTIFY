<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\BarangModel;
use App\Models\DistribusiModel;
use App\Models\KodeBarangModel;
use App\Models\RuangModel;
use App\Models\StatusModel;
use App\Models\UserModel;
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
        $user = UserModel::all();

        return view('admin.distribusi.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'ruang' => $ruang, 
            'barang' => $barang, 
            'statusAwal' => $statusAwal, 
            'statusAkhir' => $statusAkhir,
            'user' => $user, 
            'activeMenu' => $activeMenu]);
    }

    public function list(Request $request){
    $distribusis = DistribusiModel::select('id_distribusi', 'detail_distribusi_barang.id_barang', 'id_ruang', 'id_detail_status_awal', 'id_detail_status_akhir', 'id_user')
        ->with('barang.kode')
        ->with('ruang')
        ->with('statusAwal')
        ->with('statusAkhir')
        ->with('user');

    if ($request->id_barang) {
        $distribusis->where('id_barang', $request->id_barang);
    }

    if ($request->id_ruang) {
        $distribusis->where('id_ruang', $request->id_ruang);
    }

    if ($request->id_ruang) {
        $distribusis->where('id_user', $request->id_user);
    }

    if ($request->id_detail_status) {
        $distribusis->whereHas('detail_status', function ($query) use ($request) {
            $query->where('id', $request->id_detail_status);
        });
    }

    $data = $distribusis->get()->map(function ($distribusi) {
        $logPerubahan = DB::table('log_perubahan')
        ->where('id_distribusi', $distribusi->id_distribusi)
        ->orderBy('tanggal_perubahan', 'desc')
        ->first();

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
            'user' => $distribusi->user->nama ?? '',
            'tanggal_perubahan' => $logPerubahan ? $logPerubahan->tanggal_perubahan : null,
        ];
    });

    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function ($distribusi) {
            $btn = '<a href="' . url('/admin/distribusi/' . $distribusi['id_distribusi']) . '" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="' . url('/admin/distribusi/' . $distribusi['id_distribusi'] . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admin/distribusi/' . $distribusi['id_distribusi']) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
}
    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah Distribusi Barang JTI',
            'list' => ['Home', 'Distribusi', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Data Distribusi Barang JTI Baru',
        ];

        $activeMenu = 'distribusi';
        // Get all ids of id_barang already present in DistribusiModel
        $usedBarangIds = DistribusiModel::pluck('id_barang')->toArray();

        // Fetch items not in the usedBarangIds
        $barang = BarangModel::whereNotIn('id_barang', $usedBarangIds)->get();
        $ruang = RuangModel::all();
        $statusAwal = StatusModel::all();
        $statusAkhir = StatusModel::all();
        $kode = DistribusiModel::with('barang.kode')->get();

        return view('admin.distribusi.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'ruang' => $ruang, 'statusAwal' => $statusAwal, 'statusAkhir' => $statusAkhir, 'kode'=>$kode, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request){
        $request->validate([
            'id_barang'              =>'required|integer',
            'id_ruang'               =>'required|integer',
        ]);

        $request->merge(['id_detail_status_awal' => 1]);
        $request->merge(['id_detail_status_akhir' => 1]);

        DistribusiModel::create([
            'id_barang'              => $request->id_barang,
            'id_ruang'               => $request->id_ruang,
            'id_detail_status_awal'  => $request->id_detail_status_awal,
            'id_detail_status_akhir' => $request->id_detail_status_akhir
        ]);

        return redirect('/admin/distribusi')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(string $id){
        $distribusi = DistribusiModel::with('ruang')->with('barang')->find($id);

        if ($distribusi) {
            $logPerubahan = DB::table('log_perubahan')
                ->where('id_distribusi', $id)
                ->orderBy('tanggal_perubahan', 'desc') // Order by date to get the latest status
                ->get();
    
            $processedLogs = $logPerubahan->map(function ($log) use ($distribusi) {
                return [
                    'tahun' => date('Y', strtotime($log->tanggal_perubahan)), // Extract year from tanggal_perubahan
                    'tanggal_perubahan' => $log->tanggal_perubahan,
                    'status_akhir' => $distribusi->statusAkhir->nama_status
                ];
            });
    
            $latestStatusByYear = [];
            foreach ($processedLogs as $log) {
                $year = $log['tahun'];
                $latestStatusByYear[$year] = $log['status_akhir'];
            }
    
            $breadcrumb = (object)[
                'title' => 'Detail Distribusi Barang JTI',
                'list' => ['Home', 'Distribusi', 'Detail']
            ];
    
            $page = (object)[
                'title' => 'Detail Distribusi Barang JTI',
            ];
    
            $activeMenu = 'distribusi';
    
            return view('admin.distribusi.show', [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'distribusi' => $distribusi,
                'activeMenu' => $activeMenu,
                'logs' => $processedLogs // Pass the processed logs to the view
            ]);
        } else {
            // Handle the case where no DistribusiModel record is found
            return redirect()->back()->with('error', 'Distribusi not found');
        }
    }

    public function edit(string $id){
        $distribusi = DistribusiModel::find($id);
        $ruang = RuangModel::all();
        $barang = BarangModel::all();
        $statusAwal = StatusModel::all();
        $statusAkhir = StatusModel::all();
        $kode = DistribusiModel::with('barang.kode')->get();

        $breadcrumb = (object)[
            'title' => 'Edit Data Distribusi Barang JTI',
            'list' => ['Home', 'Distribusi', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Data Distribusi Barang JTI',
        ];

        $activeMenu = 'distribusi';

        return view('admin.distribusi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'ruang' => $ruang, 'barang' => $barang, 'statusAwal' => $statusAwal, 'statusAkhir' => $statusAkhir, 'distribusi' => $distribusi, 'kode' => $kode, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'id_barang'              =>'required|integer:detail_distribusi_barang,' .$id. ',id_distribusi',
            'id_ruang'               =>'required|integer',
            'id_detail_status_awal'  =>'required|integer',
        ]);

        DistribusiModel::find($id)->update([
            'id_barang'              => $request->id_barang,
            'id_ruang'               => $request->id_ruang,
            'id_detail_status_awal'  => $request->id_detail_status_awal,
        ]);

        return redirect('/admin/distribusi')->with('success', 'Data berhasil diubah!');;
    }

    public function destroy($id)
    {
        $check = DistribusiModel::find($id);
        if(!$check){
            return redirect('/admin/distribusi')->with('error', 'Data tidak ditemukan!');
        }

        try{
            DistribusiModel::destroy($id);
            return redirect('/admin/distribusi')->with('success', 'Data berhasil dihapus!');
        }catch(\Illuminate\Database\QueryException $e){
            return redirect('/admin/distribusi')->with('error', 'Data gagal dihapus! masih terdapat tabel lain yang terikat dengan data ini!');
        }
    }
}


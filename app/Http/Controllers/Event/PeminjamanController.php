<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PeminjamanController extends Controller
{
    public function index()
    {
        return view('event.peminjaman');
    }

    // // Mendapatkan data untuk DataTables
    // public function getData(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Peminjaman::all();
    //         return DataTables::of($data)
    //             ->addColumn('action', function ($row) {
    //                 return view('peminjaman.partials.actions', ['data' => $row]);
    //             })
    //             ->make(true);
    //     }
    // }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'nama_peminjam' => 'required|string|max:255',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
            'lokasi_peminjam' => 'required|string|max:255',
            'kebutuhan_hardware' => 'required|json',
        ]);


        Peminjaman::create($validated);

        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Peminjaman',
            'text' => 'Data peminjaman berhasil ditambahkan.',
            'data'    => ''
        ]);
    }

    // Menampilkan data untuk diedit
    public function show($peminjamans_id)
    {
        $data = Peminjaman::findOrFail($peminjamans_id);
        return response()->json(['data' => $data]);
    }


    // Mengupdate data peminjaman
    public function update(Request $request, $peminjamans_id)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'nama_peminjam' => 'required|string|max:255',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
            'lokasi_peminjam' => 'required|string|max:255',
            'kebutuhan_hardware' => 'required|json',
        ]);

        $peminjaman = Peminjaman::findOrFail($peminjamans_id);
        $peminjaman->update($validated);

        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Peminjaman',
            'text' => 'Data peminjaman berhasil diperbarui.',
            'data'    => ''
        ]);
    }


    // Menghapus data peminjaman
    public function destroy($peminjamans_id)
    {
        $peminjaman = Peminjaman::findOrFail($peminjamans_id);
        $peminjaman->delete();

        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Peminjaman',
            'text' => 'Data peminjaman berhasil dihapus.',
            'data'    => ''
        ]);
    }

    function get_datatable(Request $request)
    {

        $data = Peminjaman::get();

        // dd($data);

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('nama_kegiatan', function ($data) {
                    return $data->nama_kegiatan;
                })
                ->addColumn('nama_peminjam', function ($data) {
                    return $data->nama_peminjam;
                })
                ->addColumn('tanggal_peminjaman', function ($data) {
                    return $data->tanggal_peminjaman;
                })
                ->addColumn('tanggal_pengembalian', function ($data) {
                    return $data->tanggal_pengembalian;
                })
                ->addColumn('lokasi_peminjam', function ($data) {
                    return $data->lokasi_peminjam;
                })
                ->addColumn('kebutuhan_hardware', function ($data) {
                    return $data->kebutuhan_hardware;
                })
                ->addColumn('action', function ($data) {
                    // return $data->a;
                    return '<div style="display: inline-flex;" class="">
                            <a href="javascript:void(0)" id="btn-edit" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}

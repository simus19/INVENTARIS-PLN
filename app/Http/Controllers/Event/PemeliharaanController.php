<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PemeliharaanController extends Controller
{
    public function index()
    {
        return view('event.pemeliharaan');
    }

    // Mendapatkan data untuk DataTables
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Pemeliharaan::all();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return view('pemeliharaan.partials.actions', ['data' => $row]);
                })
                ->make(true);
        }
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_mulai_kegiatan' => 'required|date',
            'tanggal_selesai_kegiatan' => 'required|date|after_or_equal:tanggal_mulai_kegiatan',
            'lokasi' => 'required|string|max:255',
            'pelaksana' => 'required|string|max:255',
            'evidence' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'kebutuhan_hardware' => 'required|json',

        ]);


        Pemeliharaan::create($validated);

        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Pemeliharaan',
            'text' => 'Data pemeliharaan berhasil ditambahkan.',
            'data'    => ''
        ]);
    }

    // Menampilkan data untuk diedit
    public function show($pemeliharaan_id)
    {
        $data = Pemeliharaan::findOrFail($pemeliharaan_id);
        return response()->json(['data' => $data]);
    }

    function get_datatable(Request $request)
    {

        $data = Pemeliharaan::get();

        // dd($data);

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('nama_kegiatan', function ($data) {
                    return $data->nama_kegiatan;
                })
                ->addColumn('tanggal_mulai_kegiatan', function ($data) {
                    return $data->tanggal_mulai_kegiatan;
                })
                ->addColumn('tanggal_selesai_kegiatan', function ($data) {
                    return $data->tanggal_selesai_kegiatan;
                })
                ->addColumn('lokasi', function ($data) {
                    return $data->lokasi;
                })
                ->addColumn('pelaksana', function ($data) {
                    return $data->pelaksana;
                })
                ->addColumn('evidence', function ($data) {
                    return $data->evidence;
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

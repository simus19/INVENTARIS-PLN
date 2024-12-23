<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AplikasiController extends Controller
{
    public function index()
    {
        return view('item.aplikasi');
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_aplikasi' => 'required',
            'versi_aplikasi' => 'required',
            'tahun_produksi' => 'required',
            'bahasa_pemrograman' => 'required',
            'jenis_database' => 'required',
            'server_id' => 'required',
            'pengelola' => 'required',
            'penanggung_jawab' => 'required',
            'status' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Aplikasi::create([
            'nama_aplikasi' => $request->nama_aplikasi,
            'versi_aplikasi' => $request->versi_aplikasi,
            'tahun_produksi' => $request->tahun_produksi,
            'bahasa_pemrograman' => $request->bahasa_pemrograman,
            'jenis_database' => $request->jenis_database,
            'server_id' => $request->server_id,
            'pengelola' => $request->pengelola,
            'penanggung_jawab' => $request->penanggung_jawab,
            'status' => $request->status,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Aplikasi',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_show($aplikasis_id)
    {
        $aplikasi = Aplikasi::find($aplikasis_id);

        return response()->json([
            'success' => true,
            'title' => 'Aplikasi',
            'data'    => $aplikasi
        ]);
    }

    function put_update(Request $request, $aplikasis_id)
    {
        $validator = Validator::make($request->all(), [
            'nama_aplikasi' => 'required',
            'versi_aplikasi' => 'required',
            'tahun_produksi' => 'required',
            'bahasa_pemrograman' => 'required',
            'jenis_database' => 'required',
            'server_id' => 'required',
            'pengelola' => 'required',
            'penanggung_jawab' => 'required',
            'status' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $data = [
            'nama_aplikasi' => $request->nama_aplikasi,
            'versi_aplikasi' => $request->versi_aplikasi,
            'tahun_produksi' => $request->tahun_produksi,
            'bahasa_pemrograman' => $request->bahasa_pemrograman,
            'jenis_database' => $request->jenis_database,
            'server_id' => $request->server_id,
            'pengelola' => $request->pengelola,
            'penanggung_jawab' => $request->penanggung_jawab,
            'status' => $request->status,
        ];

        Aplikasi::find($aplikasis_id)->update($data);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Aplikasi',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }

    function delete_destroy($aplikasis_id)
    {
        Aplikasi::destroy($aplikasis_id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Aplikasi',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
    }

    function get_datatable(Request $request)
    {

        $data = Aplikasi::get();

        // dd($data);

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('nama_aplikasi', function ($data) {
                    return $data->nama_aplikasi;
                })
                ->addColumn('versi_aplikasi', function ($data) {
                    return $data->versi_aplikasi;
                })
                ->addColumn('tahun_produksi', function ($data) {
                    return $data->tahun_produksi;
                })
                ->addColumn('bahasa_pemrograman', function ($data) {
                    return $data->bahasa_pemrograman;
                })
                ->addColumn('jenis_database', function ($data) {
                    return $data->jenis_database;
                })
                ->addColumn('server_id', function ($data) {
                    return $data->server_id;
                })
                ->addColumn('pengelola', function ($data) {
                    return $data->pengelola;
                })
                ->addColumn('penanggung_jawab', function ($data) {
                    return $data->penanggung_jawab;
                })
                ->addColumn('status', function ($data) {
                    return $data->status;
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

<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ServerController extends Controller
{
    public function index()
    {
        return view('item.server');
    }

    public function getServers()
    {
        $servers = Server::select('id', 'merk_server')->get();
        return response()->json($servers);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merk_server' => 'required',
            'server_serial_number' => 'required',
            'operating_system' => 'required',
            'lisensi_os' => 'required',
            'ip_address' => 'required',
            'processor' => 'required',
            'memory' => 'required',
            'jumlah_core' => 'required',
            'storage' => 'required',
            'status_hardisk' => 'required',
            'fungsi_server' => 'required',
            'server_type' => 'required',
            'keterangan' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Server::create([
            'merk_server' => $request->merk_server,
            'server_serial_number' => $request->server_serial_number,
            'operating_system' => $request->operating_system,
            'lisensi_os' => $request->lisensi_os,
            'ip_address' => $request->ip_address,
            'processor' => $request->processor,
            'memory' => $request->memory,
            'jumlah_core' => $request->jumlah_core,
            'storage' => $request->storage,
            'status_hardisk' => $request->status_hardisk,
            'fungsi_server' => $request->fungsi_server,
            'server_type' => $request->server_type,
            'keterangan' => $request->keterangan,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Server',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_show($servers_id)
    {
        $server = Server::find($servers_id);

        return response()->json([
            'success' => true,
            'title' => 'Server',
            'data'    => $server
        ]);
    }

    function put_update(Request $request, $servers_id)
    {
        $validator = Validator::make($request->all(), [
            'merk_server' => 'required',
            'server_serial_number' => 'required',
            'operating_system' => 'required',
            'lisensi_os' => 'required',
            'ip_address' => 'required',
            'processor' => 'required',
            'memory' => 'required',
            'jumlah_core' => 'required',
            'storage' => 'required',
            'status_hardisk' => 'required',
            'fungsi_server' => 'required',
            'server_type' => 'required',
            'keterangan' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $data = [
            'merk_server' => $request->merk_server,
            'server_serial_number' => $request->server_serial_number,
            'operating_system' => $request->operating_system,
            'lisensi_os' => $request->lisensi_os,
            'ip_address' => $request->ip_address,
            'processor' => $request->processor,
            'memory' => $request->memory,
            'jumlah_core' => $request->jumlah_core,
            'storage' => $request->storage,
            'status_hardisk' => $request->status_hardisk,
            'fungsi_server' => $request->fungsi_server,
            'server_type' => $request->server_type,
            'keterangan' => $request->keterangan,
        ];

        Server::find($servers_id)->update($data);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Server',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }


    function delete_destroy($servers_id)
    {
        Server::destroy($servers_id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Server',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
    }

    function get_datatable(Request $request)
    {

        $data = Server::get();

        // dd($data);

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('merk_server', function ($data) {
                    return $data->merk_server;
                })
                ->addColumn('server_serial_number', function ($data) {
                    return $data->server_serial_number;
                })
                ->addColumn('operating_system', function ($data) {
                    return $data->operating_system;
                })
                ->addColumn('lisensi_os', function ($data) {
                    return $data->lisensi_os;
                })
                ->addColumn('ip_address', function ($data) {
                    return $data->ip_address;
                })
                ->addColumn('processor', function ($data) {
                    return $data->processor;
                })
                ->addColumn('memory', function ($data) {
                    return $data->memory;
                })
                ->addColumn('jumlah_core', function ($data) {
                    return $data->jumlah_core;
                })
                ->addColumn('storage', function ($data) {
                    return $data->storage;
                })
                ->addColumn('status_hardisk', function ($data) {
                    return $data->status_hardisk;
                })
                ->addColumn('fungsi_server', function ($data) {
                    return $data->fungsi_server;
                })
                ->addColumn('server_type', function ($data) {
                    return $data->server_type;
                })
                ->addColumn('keterangan', function ($data) {
                    return $data->keterangan;
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

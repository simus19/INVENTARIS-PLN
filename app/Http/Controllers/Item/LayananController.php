<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LayananController extends Controller
{
    public function index()
    {
        return view('item.layanan');
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_layanan' => 'required',
            'unit_induk_PLN' => 'required',
            'no_BA_aktivasi' => 'required',
            'tanggal_BA' => 'required',
            'nama_layanan' => 'required',
            'level_unit' => 'required',
            'alamat_unit' => 'required',
            'bandwidth' => 'required',
            'ip_gateway' => 'required',
            'status' => 'required',
            'harga_layanan' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Layanan::create([
            'jenis_layanan' => $request->jenis_layanan,
            'unit_induk_PLN' => $request->unit_induk_PLN,
            'no_BA_aktivasi' => $request->no_BA_aktivasi,
            'tanggal_BA' => $request->tanggal_BA,
            'nama_layanan' => $request->nama_layanan,
            'level_unit' => $request->level_unit,
            'alamat_unit' => $request->alamat_unit,
            'bandwidth' => $request->bandwidth,
            'ip_gateway' => $request->ip_gateway,
            'status' => $request->status,
            'harga_layanan' => $request->harga_layanan,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'layanan',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_show($layanans_id)
    {
        $layanan = Layanan::find($layanans_id);

        return response()->json([
            'success' => true,
            'title' => 'Layanan',
            'data'    => $layanan
        ]);
    }

    function put_update(Request $request, $layanans_id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_layanan' => 'required',
            'unit_induk_PLN' => 'required',
            'no_BA_aktivasi' => 'required',
            'tanggal_BA' => 'required',
            'nama_layanan' => 'required',
            'level_unit' => 'required',
            'alamat_unit' => 'required',
            'bandwidth' => 'required',
            'ip_gateway' => 'required',
            'status' => 'required',
            'harga_layanan' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $data = [
            'jenis_layanan' => $request->jenis_layanan,
            'unit_induk_PLN' => $request->unit_induk_PLN,
            'no_BA_aktivasi' => $request->no_BA_aktivasi,
            'tanggal_BA' => $request->tanggal_BA,
            'nama_layanan' => $request->nama_layanan,
            'level_unit' => $request->level_unit,
            'alamat_unit' => $request->alamat_unit,
            'bandwidth' => $request->bandwidth,
            'ip_gateway' => $request->ip_gateway,
            'status' => $request->status,
            'harga_layanan' => $request->harga_layanan,
        ];

        Layanan::find($layanans_id)->update($data);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Layanan',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }


    function delete_destroy($layanans_id)
    {
        Layanan::destroy($layanans_id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Layanan',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
    }

    function get_datatable(Request $request)
    {

        $data = Layanan::get();

        // dd($data);

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('jenis_layanan', function ($data) {
                    return $data->jenis_layanan;
                })
                ->addColumn('unit_induk_PLN', function ($data) {
                    return $data->unit_induk_PLN;
                })
                ->addColumn('no_BA_aktivasi', function ($data) {
                    return $data->no_BA_aktivasi;
                })
                ->addColumn('tanggal_BA', function ($data) {
                    return $data->tanggal_BA;
                })
                ->addColumn('nama_layanan', function ($data) {
                    return $data->nama_layanan;
                })
                ->addColumn('level_unit', function ($data) {
                    return $data->level_unit;
                })
                ->addColumn('alamat_unit', function ($data) {
                    return $data->alamat_unit;
                })
                ->addColumn('bandwidth', function ($data) {
                    return $data->bandwidth;
                })
                ->addColumn('ip_gateway', function ($data) {
                    return $data->ip_gateway;
                })
                ->addColumn('status', function ($data) {
                    return $data->status;
                })
                ->addColumn('harga_layanan', function ($data) {
                    return $data->harga_layanan;
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

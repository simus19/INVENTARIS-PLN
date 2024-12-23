<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Hardware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;


class HardwareController extends Controller
{
    public function index()
    {
        return view('item.hardware');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_hardware' => 'required',
            'merk_hardware' => 'required',
            'tipe_hardware' => 'required',
            'serial_number' => 'required|string|unique:hardware',
            'lokasi' => 'required',
            'status' => 'required|in:Aktif,Standby,Terpinjam,Rusak',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $hardware = Hardware::create([
            'jenis_hardware' => $request->jenis_hardware,
            'merk_hardware' => $request->merk_hardware,
            'tipe_hardware' => $request->tipe_hardware,
            'serial_number' => $request->serial_number,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
            'qr_code' => '',
        ]);

        $hardware_qr = Hardware::where('serial_number', $request->serial_number)->first();

        $hardware_qr_data = [
            'id' => $hardware_qr->id,
            'jenis_hardware' => $request->jenis_hardware,
            'merk_hardware' => $request->merk_hardware,
            'tipe_hardware' => $request->tipe_hardware,
            'serial_number' => $request->serial_number,
        ];

        // Mengubah data menjadi JSON
        $qrCodeData = json_encode($hardware_qr_data, JSON_PRETTY_PRINT);

        // Menyimpan QR Code
        $qrCodePath = 'qrcodes/' . uniqid() . '.png';
        QrCode::format('png')->size(200)->generate($qrCodeData, public_path($qrCodePath));

        $hardware_qr->update([
            'qr_code' => $qrCodePath,
        ]);


        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Hardware',
            'text' => 'Data Berhasil Disimpan dan QR Code Dihasilkan!',
            'data' => $hardware,
        ]);
    }

    public function get_show($hardwares_id)
    {
        $hardware = Hardware::find($hardwares_id);

        return response()->json([
            'success' => true,
            'title' => 'Hardware',
            'data' => $hardware,
        ]);
    }

    public function update(Request $request, $hardwares_id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_hardware' => 'required',
            'merk_hardware' => 'required',
            'tipe_hardware' => 'required',
            'serial_number' => 'required|string|unique:hardware,serial_number,' . $hardwares_id, // Mencegah duplikasi serial_number
            'lokasi' => 'required',
            'status' => 'required|in:Aktif,Standby,Terpinjam,Rusak',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Mencari data hardware berdasarkan ID
        $hardware = Hardware::find($hardwares_id);

        if (!$hardware) {
            return response()->json([
                'success' => false,
                'icon' => 'error',
                'title' => 'Hardware Not Found',
                'text' => 'Data hardware tidak ditemukan!',
            ], 404);
        }

        // Update data hardware
        $hardware->update([
            'jenis_hardware' => $request->jenis_hardware,
            'merk_hardware' => $request->merk_hardware,
            'tipe_hardware' => $request->tipe_hardware,
            'serial_number' => $request->serial_number,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
        ]);

        // Data untuk QR Code
        $hardware_qr_data = [
            'id' => $hardware->id,
            'jenis_hardware' => $request->jenis_hardware,
            'merk_hardware' => $request->merk_hardware,
            'tipe_hardware' => $request->tipe_hardware,
            'serial_number' => $request->serial_number,
        ];

        // Mengubah data menjadi JSON untuk QR Code
        $qrCodeData = json_encode($hardware_qr_data, JSON_PRETTY_PRINT);

        // Menyimpan QR Code baru
        $qrCodePath = 'qrcodes/' . uniqid() . '.png';
        QrCode::format('png')->size(200)->generate($qrCodeData, public_path($qrCodePath));

        // Update path QR Code
        $hardware->update([
            'qr_code' => $qrCodePath,
        ]);

        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Hardware',
            'text' => 'Data dan QR Code Berhasil Diperbarui!',
            'data' => $hardware,
        ]);
    }


    public function delete_destroy($hardwares_id)
    {
        $hardware = Hardware::find($hardwares_id);

        if ($hardware) {
            if (file_exists(public_path($hardware->qr_code))) {
                unlink(public_path($hardware->qr_code));
            }

            $hardware->delete();
        }

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Hardware',
            'text' => 'Data dan QR Code Telah Dihapus!',
        ]);
    }

    public function get_datatable(Request $request)
    {
        $data = Hardware::get();

        // dd($data);

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('jenis_hardware', function ($data) {
                    return $data->jenis_hardware;
                })
                ->addColumn('merk_hardware', function ($data) {
                    return $data->merk_hardware;
                })
                ->addColumn('tipe_hardware', function ($data) {
                    return $data->tipe_hardware;
                })
                ->addColumn('serial_number', function ($data) {
                    return $data->serial_number;
                })
                ->addColumn('lokasi', function ($data) {
                    return $data->lokasi;
                })
                ->addColumn('qr_code', function ($data) {
                    return
                        '<img src="' . url('/' . $data->qr_code) . '" width="100" height="100">';
                })
                ->addColumn('status', function ($data) {
                    return $data->status;
                })
                ->addColumn('action', function ($data) {
                    // Generate URL QR Code
                    $qrCodeUrl = url('/' . $data->qr_code);

                    return '
                        <div style="display: inline-flex;">
                            <a href="javascript:void(0)" id="btn-edit" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="javascript:void(0)" id="btn-delete" data-id="' . $data->id . '" class="btn btn-sm btn-danger mr-2">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                            <button class="btn btn-primary btn-sm btn-print-qr" data-qrcode="' . $qrCodeUrl . '">
                                <i class="fa fa-print"></i> Print QR
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['qr_code', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}

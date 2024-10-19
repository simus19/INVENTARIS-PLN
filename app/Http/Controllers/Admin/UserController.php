<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('rolemenucek');
    }

    function index()
    {
        return view('admin.user');
    }

    function post_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'admin_roles_id' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        User::create([
            'roles_id' => $request->admin_roles_id,
            'name' => $request->name,
            'email' => $request->email,
            'role_verified_is' => 1,
            'password' => $request->password,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'User',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_show($users_id)
    {
        $user = User::with('role')->find($users_id);

        return response()->json([
            'success' => true,
            'title' => 'Role',
            'data'    => $user
        ]);
    }

    function put_update(Request $request, $users_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => $request->password != '' ? 'min:8' : '',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $data = [
            'name' => $request->name,
            'roles_id' => $request->admin_roles_id,
        ];
        if ($request->password != '') {
            $data['password'] = $request->password;
        }


        User::find($users_id)->update($data);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'User',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }

    function delete_destroy($users_id)
    {
        User::destroy($users_id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'User',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
    }
    
    function post_verify($users_id)
    {
        User::find($users_id)->update(['role_verified_is' => 1]);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'User',
            'text' => 'Data Telah Diverifikasi!',
            'data'    => ''
        ]);
    }
    
    function post_unverify($users_id)
    {
        User::find($users_id)->update(['role_verified_is' => null]);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'User',
            'text' => 'Data Tidak Terverifikasi!',
            'data'    => ''
        ]);
    }




    function get_datatable(Request $request)
    {

        $data = User::get();

        // dd($data);

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('role', function ($data) {
                    return $data->role->name;
                })
                ->addColumn('role_verified_is', function ($data) {
                    return $data->role_verified_is != null ? '<small class="badge badge-success badge-lg text-center">verified</small>' : '';
                })
                ->addColumn('action', function ($data) {
                    // return $data->a;
                    if ( $data->role_verified_is == null) {
                        $role_verified = '<a href="javascript:void(0)" id="btn-verified" data-id="' . $data->id . '" class="btn btn-sm btn-success mr-2"><i class="fas fa-check"></i> Verify</a>';
                    }else{
                        $role_verified = '<a href="javascript:void(0)" id="btn-unverified" data-id="' . $data->id . '" class="btn btn-sm btn-warning mr-2"><i class="fas fa-times"></i> Unverify</a>';
                    }
                    return '<div style="display: inline-flex;" class="">
                            '.$role_verified.'
                            <a href="javascript:void(0)" id="btn-edit" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action', 'role_verified_is'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}

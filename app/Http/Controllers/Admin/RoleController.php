<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User_role_menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('rolemenucek');
    }

    function get_index()
    {
        return view('admin.role');
    }

    function post_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Role::create([
            'name' => $request->name,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Role',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_show(Role $role)
    {
        return response()->json([
            'success' => true,
            'title' => 'Role',
            'data'    => $role
        ]);
    }

    function post_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Role::find($id)->update([
            'name' => $request->name,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Role',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }


    function get_datatable(Request $request)
    {

        $data = Role::get();

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('action', function ($data) {
                    // return $data->a;
                    return '<div style="display: inline-flex;" class="">
                            <a href="' . url('admin/role/show-access/' . $data->id) . '" id="btn-access" data-id="' . $data->id . '" class="btn btn-sm btn-warning mr-2">Access</a>
                            <a href="javascript:void(0)" id="btn-edit" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    function delete_destroy($id)
    {
        Role::destroy($id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Role',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
    }

    function get_showAccess($roles_id)
    {
        $role = Role::find($roles_id);
        $admin_menu = Menu::select('id', 'name')->get();

        return view('admin.role-access-menu', compact('role', 'admin_menu', 'roles_id'));
    }

    function get_changeAccess(Request $request, $menu_id, $role_id)
    {
        $data = [
            'roles_id' => $role_id,
            'menus_id' => $menu_id,
        ];

        $user_role_menu = User_role_menu::where('menus_id', $menu_id)->where('roles_id', $role_id)->get();

        // return $User_role_menu;

        if (count($user_role_menu) < 1) {
            User_role_menu::create($data);
        } else {
            User_role_menu::where('menus_id', $menu_id)->where('roles_id', $role_id)->delete();
        }

        return response()->json([
            'success' => true,
            'title' => 'Access Role',
            'data'    => ''
        ]);
    }

    function get_roleAjax(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Role::select("id", "name")->where('name', 'LIKE', "%$search%")->orWhere('id', '=', "$search")->get();
        } else {
            $data = Role::select("id", "name")->get();
        }
        return response()->json($data);
    }
}

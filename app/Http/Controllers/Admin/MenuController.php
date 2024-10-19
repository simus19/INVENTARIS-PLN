<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Menu_sub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('rolemenucek');
    }

    function get_index()
    {
        return view('admin.menu');
    }

    function post_storemenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'icon' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Menu::create([
            'name' => $request->name,
            'icon' => $request->icon,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Menu',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_showmenu(Menu $menu)
    {
        return response()->json([
            'success' => true,
            'title' => 'Menu',
            'data'    => $menu
        ]);
    }

    function put_updatemenu(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'icon' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Menu::find($id)->update([
            'name' => $request->name,
            'icon' => $request->icon,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Menu',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }

    function delete_destroymenu($id)
    {

        Menu::destroy($id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Menu',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
        // return $admin;
    }


    function post_storesubmenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'url' => 'required',
            'menus_id' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Menu_sub::create([
            'name' => $request->name,
            'menus_id' => $request->menus_id,
            'url' => $request->url,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Sub Menu',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_showsubmenu($id)
    {
        $admin_sub_menu = Menu_sub::with('menu')->find($id);
        return response()->json([
            'success' => true,
            'title' => 'Sub Menu',
            'data'    => $admin_sub_menu
        ]);
    }

    function put_updatesubmenu(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'url' => 'required',
            'menus_id' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Menu_sub::find($id)->update([
            'name' => $request->name,
            'menus_id' => $request->menus_id,
            'url' => $request->url,
            'icon' => $request->icon,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Sub Menu',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }

    function delete_destroysubmenu($id)
    {

        Menu_sub::destroy($id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Sub Menu',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
        // return $admin;
    }








    function get_menudatatable(Request $request)
    {

        $data = Menu::get();

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('icon', function ($data) {
                    return $data->icon;
                })
                ->addColumn('action', function ($data) {
                    // return $data->a;
                    return '<div style="display: inline-flex;" class="">
                            <a href="javascript:void(0)" id="btn-edit-menu" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete-menu" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    function get_submenudatatable(Request $request)
    {

        $data = Menu_sub::get();

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('url', function ($data) {
                    return $data->url;
                })
                ->addColumn('menus_id', function ($data) {
                    return $data->menu->name;
                })
                ->addColumn('action', function ($data) {
                    // return $data->a;
                    return '<div style="display: inline-flex;" class="">
                            <a href="javascript:void(0)" id="btn-edit-submenu" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete-submenu" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    function get_menuAjax(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Menu::select("id", "name")->where('name', 'LIKE', "%$search%")->orWhere('id', '=', "$search")->get();
        } else {
            $data = Menu::select("id", "name")->get();
        }
        return response()->json($data);
    }
}

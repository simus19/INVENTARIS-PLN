<?php

namespace App\Http\Middleware;

use App\Models\Menu_sub;
use App\Models\User_role_menu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMenuCek
{
    static function get()
    {
        $data = User_role_menu::where('roles_id', Auth::user()->roles_id)->get();
        return $data;
    }
    
    // static function getmenusub()
    // {
    //     $user_menu = User_role_menu::where('roles_id', Auth::user()->roles_id)->get();
    //     $data = [];
    //     foreach ($user_menu as $menu) {
    //         $menu_subs = Menu_sub::where('menus_id', $menu->menu->id)->get();
    //         foreach ($menu_subs as $menu_sub) {
    //            $data[] = $menu_sub->url;
    //         }
    //     }
    //     return $data;
    // }

    public function handle(Request $request, Closure $next): Response
    {
        // dd($this->getmenusub());
        $user_menu = User_role_menu::where('roles_id', Auth::user()->roles_id)->get();

        
        foreach ($user_menu as $menu) {
            $menu_subs = Menu_sub::where('menus_id', $menu->menu->id)->get();
            
            $allowed_urls = [];

            foreach ($menu_subs as $menu_sub) {
                $allowed_urls[] = url($menu_sub->url);
            }

            foreach ($allowed_urls as $allowed_url) {
                if (str_starts_with($request->url(), $allowed_url)) {
                    return $next($request); // Izinkan akses jika URL cocok dengan awalan yang diizinkan
                }
            }
        }

        // dd($allowed_urls);

        return abort(403);
    }
}

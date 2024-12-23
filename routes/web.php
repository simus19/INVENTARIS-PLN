<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Event\PemeliharaanController;
use App\Http\Controllers\Event\PeminjamanController;
use App\Http\Controllers\Item\AplikasiController;
use App\Http\Controllers\Item\HardwareController;
use App\Http\Controllers\Item\LayananController;
use App\Http\Controllers\Item\ServerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------|
| Web Routes                                                               |
|--------------------------------------------------------------------------|
| Here is where you can register web routes for your application. These    |
| routes are loaded by the RouteServiceProvider and all of them will       |
| be assigned to the "web" middleware group. Make something great!          |
|--------------------------------------------------------------------------|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

// Route::get('/about', function () {
//     return view('about');
// })->name('about');

Route::auto('/admin/role', RoleController::class);
Route::auto('/admin/menu', MenuController::class);
Route::auto('/admin/user', UserController::class);

Route::auto('/items/layanan', LayananController::class);
Route::auto('/items/aplikasi', AplikasiController::class);



Route::auto('/items/hardware', HardwareController::class);
Route::auto('/items/server', ServerController::class);
Route::get('/items/servers', [ServerController::class, 'getServers'])->name('servers.get');

// // Menambahkan route untuk hardware
// Route::post('/items/hardware/store', [HardwareController::class, 'store'])->name('hardware.store');
// Route::get('/items/hardware/{id}', [HardwareController::class, 'get_show'])->name('hardware.show');
// Route::put('/items/hardware/update/{id}', [HardwareController::class, 'update']);


Route::auto('/events/peminjaman', PeminjamanController::class);
Route::auto('/events/pemeliharaan', PemeliharaanController::class);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Test;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/test',[Test::class,'index']);


Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::get('users', [AuthController::class, 'users']);
    Route::put('toAdmin/{id}', [AuthController::class, 'userToAdmin']);
    Route::put('toUser/{id}', [AuthController::class, 'adminToUser']);
    Route::post('forgot/{email}', [AuthController::class, 'forgotPassword']);
});

Route::prefix('menus')->group(function () {
    Route::get('all', [ProductController::class, 'index']);
    Route::post('menu', [ProductController::class, 'create']);
    Route::delete('menu/{id}', [ProductController::class, 'destroy']);
    Route::get('menu/{id}', [ProductController::class, 'show']);
});

Route::prefix('admin')->group(function () {

        Route::get('profile', [AdminController::class, 'profile']);
        Route::get('daftarguru', [AdminController::class, 'daftarGuru']);
        Route::get('daftarortu', [AdminController::class, 'daftarOrtu']);
        Route::post('registerakunguru', [AdminController::class, 'registerAkunGuru']);
        Route::post('registerakunortu', [AdminController::class, 'registerAkunOrtu']);
        Route::put('updateguru/{id}', [AdminController::class, 'updateGuru']);
        Route::put('updateortu/{id}', [AdminController::class, 'updateOrtu']);
        Route::delete('deleteuser/{id}', [AdminController::class, 'destroyUser']);
        Route::get('daftarkelas', [AdminController::class, 'daftarKelas']);
        Route::post('tambahkelas', [AdminController::class, 'tambahKelas']);
        Route::put('updatekelas/{id}', [AdminController::class, 'updateKelas']);
        Route::delete('deletekelas/{id}', [AdminController::class, 'destroyKelas']);
        Route::get('daftarmurid', [AdminController::class, 'daftarMurid']);
        Route::post('tambahmurid', [AdminController::class, 'tambahMurid']);
        Route::put('updatemurid/{id}', [AdminController::class, 'updateMurid']);
        Route::delete('deletemurid/{id}', [AdminController::class, 'destroyMurid']);
   
    });

    Route::prefix('guru')->group(function () {

        Route::get('me', [GuruController::class, 'me']);
        Route::get('profile', [GuruController::class, 'profile']);
        Route::get('daftarmurid', [GuruController::class, 'daftarMurid']);
        Route::get('daftarhafalanmurid/{id}', [GuruController::class, 'daftarHafalanMurid']);
        Route::get('daftarhafalanfilter/{id}/{status}', [GuruController::class, 'daftarHafalanFilter']);
        Route::post('tambahhafalan', [GuruController::class, 'tambahHafalan']);
        Route::post('updatehafalan/{id_input}', [GuruController::class, 'updateHafalan']);
        Route::delete('deletehafalan/{id}', [GuruController::class, 'destroyHafalan']);
        Route::get('daftartilawah', [GuruController::class, 'dataTilawah']);
        Route::post('tambahtilawah', [GuruController::class, 'tambahTilawah']);
        Route::put('updatetilawah/{id}', [GuruController::class, 'updateTilawah']);
        Route::delete('deletetilawah/{id}', [GuruController::class, 'destroyTilawah']);
        Route::get('daftarmurojaah', [GuruController::class, 'dataMurojaah']);
        Route::post('tambahmurojaah', [GuruController::class, 'tambahMurojaah']);
        Route::put('updatemurojaah/{id}', [GuruController::class, 'updateMurojaah']);
        Route::delete('deletemurojaah/{id}', [GuruController::class, 'destroyMurojaah']);



    });

    Route::prefix('ortu')->group(function () {
        Route::get('profile', [OrtuController::class, 'profile']);
        Route::get('datamurid', [OrtuController::class, 'dataMurid']);
        Route::get('datahafalanfilter/{id_murid}/{status}', [OrtuController::class, 'dataHafalanFilter']);
        Route::get('datamurojaah/{data}', [OrtuController::class, 'dataMurojaah']);
        Route::get('datatilawah/{data}', [OrtuController::class, 'dataTilawah']);



    });



    Route::prefix('checkout')->group(function () {
        Route::get('get/{id}', [CheckoutController::class, 'index']);
        Route::get('show/{id}', [CheckoutController::class, 'show']);
        Route::post('add/{user_id}/{code}', [CheckoutController::class, 'create']);
        Route::delete('delete/{id}', [CheckoutController::class, 'destroy']);
    });

    Route::prefix('purchase')->group(function () {
        Route::get('get/admin', [PurchaseController::class, 'getPurchaseAdmin']);
        Route::get('get/{id}', [PurchaseController::class, 'index']);
        Route::get('show/{id}', [PurchaseController::class, 'show']);
        Route::put('delivered/{id}', [PurchaseController::class, 'delivered']);
        Route::post('payment/{user_id}/{id}', [PurchaseController::class, 'payment']);
        Route::post('create/{user_id}', [PurchaseController::class, 'create']);
        Route::delete('delete/{id}', [PurchaseController::class, 'destroy']);
    });
    





// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

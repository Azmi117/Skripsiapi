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
        Route::post('updateguru/{id}', [AdminController::class, 'updateGuru']);
        Route::post('updateortu/{id}', [AdminController::class, 'updateOrtu']);
        Route::delete('deleteuser/{id}', [AdminController::class, 'destroyUser']);
        Route::get('getuser/{id}', [AdminController::class, 'getUser']);
        Route::get('daftarkelas', [AdminController::class, 'daftarKelas']);
        Route::post('tambahkelas', [AdminController::class, 'tambahKelas']);
        Route::put('updatekelas/{id}', [AdminController::class, 'updateKelas']);
        Route::delete('deletekelas/{id}', [AdminController::class, 'destroyKelas']);
        Route::get('daftarmurid', [AdminController::class, 'daftarMurid']);
        Route::post('tambahmurid', [AdminController::class, 'tambahMurid']);
        Route::post('updatemurid/{id}', [AdminController::class, 'updateMurid']);
        Route::delete('deletemurid/{id}', [AdminController::class, 'destroyMurid']);
        Route::get('datamurid/{id}', [AdminController::class, 'dataMurid']);
        Route::get('datakelas/{id}', [AdminController::class, 'dataKelas']);
        Route::get('gurukelas/{id}', [AdminController::class, 'guruKelas']);
        Route::get('muridkelas/{id}', [AdminController::class, 'muridKelas']);
        Route::get('laporanhafalan', [AdminController::class, 'laporanhafalan']);
        Route::get('filterlaporan/{from}/{to}', [AdminController::class, 'filterlaporan']);
        Route::get('filterlaporanlama/{from}/{to}', [AdminController::class, 'filterlaporanhafalanlama']);
        Route::get('filterlaporantilawah/{from}/{to}', [AdminController::class, 'filterlaporantilawah']);
        Route::get('filterlaporanhafalanrumah/{from}/{to}', [AdminController::class, 'filterlaporanhafalanrumah']);
        Route::get('filterlaporanhafalanlamarumah/{from}/{to}', [AdminController::class, 'filterlaporanhafalanlamarumah']);
        Route::get('filterlaporantilawahrumah/{from}/{to}', [AdminController::class, 'filterlaporantilawahmarumah']);
    });

    Route::prefix('guru')->group(function () {
        Route::get('me', [GuruController::class, 'me']);
        Route::get('profile', [GuruController::class, 'profile']);
        Route::get('daftarmurid', [GuruController::class, 'daftarMurid']);
        Route::get('datamurid/{id}', [GuruController::class, 'dataMurid']);
        Route::get('daftarhafalanmurid/{id}', [GuruController::class, 'daftarHafalanMurid']);
        Route::get('daftarhafalanfilter/{id_murid}/{status}', [GuruController::class, 'daftarHafalanFilter']);
        Route::post('tambahhafalan', [GuruController::class, 'tambahHafalan']);
        Route::post('updatehafalan/{id_input}', [GuruController::class, 'updateHafalan']);
        Route::delete('deletehafalan/{id}', [GuruController::class, 'destroyHafalan']);
        Route::put('updatestatushafalan/{id}', [GuruController::class, 'updateStatusHafalan']);
        Route::delete('deleteallhafalan/{id_input}', [GuruController::class, 'destroyAllHafalan']);
        Route::get('daftarhafalandetail/{id_kelas}', [GuruController::class, 'dataHafalanDetail']);
        Route::get('daftartilawah', [GuruController::class, 'dataTilawah']);
        Route::post('tambahtilawah', [GuruController::class, 'tambahTilawah']);
        Route::put('updatetilawah/{id}', [GuruController::class, 'updateTilawah']);
        Route::delete('deletetilawah/{id}', [GuruController::class, 'destroyTilawah']);
        Route::get('detailtilawah/{id}', [GuruController::class, 'detailTilawah']);
        Route::get('daftarmurojaah', [GuruController::class, 'dataMurojaah']);
        Route::post('tambahmurojaah', [GuruController::class, 'tambahMurojaah']);
        Route::put('updatemurojaah/{id}', [GuruController::class, 'updateMurojaah']);
        Route::delete('deletemurojaah/{id}', [GuruController::class, 'destroyMurojaah']);
        Route::get('detailmurojaah/{id}', [GuruController::class, 'detailMurojaah']);
        Route::get('kelas/{id}', [GuruController::class, 'kelas']);
        Route::put('updateprofileguru/{id}', [GuruController::class, 'updateGuru']);
        Route::get('daftarhafalankelas/{id_kelas}', [GuruController::class, 'dataHafalanKelas']);
        Route::get('dataortu/{id}', [GuruController::class, 'dataOrtu']);
        Route::get('datahafalan/{id}', [GuruController::class, 'dataHafalan']);
    });

    Route::prefix('ortu')->group(function () {
        Route::get('profile', [OrtuController::class, 'profile']);
        Route::get('datamurid', [OrtuController::class, 'dataMurid']);
        Route::get('datahafalanfilter/{id_murid}/{status}', [OrtuController::class, 'dataHafalanFilter']);
        Route::get('datamurojaah/{data}', [OrtuController::class, 'dataMurojaah']);
        Route::get('datatilawah/{data}', [OrtuController::class, 'dataTilawah']);
        Route::get('kelas/{id}', [OrtuController::class, 'kelasAnak']);
        Route::get('guru/{id}', [OrtuController::class, 'dataGuru']);
        Route::put('updateprofileortu/{id}', [OrtuController::class, 'updateOrtu']);
        Route::post('updatehafalan/{id}', [OrtuController::class, 'updateHafalan']);
        Route::post('tambahhafalan', [OrtuController::class, 'tambahHafalan']);
        Route::post('tambahmurojaah', [OrtuController::class, 'tambahMurojaah']);
        Route::post('tambahtilawah', [OrtuController::class, 'tambahTilawah']);
        Route::post('updatestatushafalan/{id}', [OrtuController::class, 'updateStatusHafalan']);
        Route::post('updatestatusmurojaah/{id}', [OrtuController::class, 'updateStatusMurojaah']);
        Route::post('updatestatustilawah/{id}', [OrtuController::class, 'updateStatusTilawah']);
        Route::post('updatehafalan/{id}', [OrtuController::class, 'updateHafalan']);
        Route::post('updatemurojaah/{id}', [OrtuController::class, 'updateMurojaah']);
        Route::post('updatetilawah/{id}', [OrtuController::class, 'updateTilawah']);
        Route::delete('deletehafalan/{id}', [OrtuController::class, 'destroyHafalan']);
        Route::delete('deletemurojaah/{id}', [OrtuController::class, 'destroyMurojaah']);
        Route::delete('deletetilawah/{id}', [OrtuController::class, 'destroyTilawah']);
        Route::get('datahafalanfilterumah/{id_murid}/{status}', [OrtuController::class, 'dataHafalanFilterRumah']);
        Route::get('datamurojaahfilter/{id_murid}/{status}', [OrtuController::class, 'dataMurojaahFilter']);
        Route::get('datatilawahfilter/{id_murid}/{status}', [OrtuController::class, 'dataTilawahFilter']);
        Route::get('detailhafalanrumah/{id}', [OrtuController::class, 'detailHafalanRumah']);
        Route::get('detailmurojaahrumah/{id}', [OrtuController::class, 'detailMurojaahRumah']);
        Route::get('detailtilawahrumah/{id}', [OrtuController::class, 'detailTilawahRumah']);
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

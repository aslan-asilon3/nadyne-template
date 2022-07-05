<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/greeting', function () {
    return 'Hello World';
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/cek-member-data', 'TestController@cekMemberRaw');

Route::get('test/notifikasi', function () {
    event(new App\Events\StatusLiked('Someone'));
    return "Event has been sent!";
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Auth::routes([
    "register" => true
]);

Route::group(['middleware' => 'admin'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/data-sales', 'DataSalesController@index')->name('data-sales.index');
    Route::post('/ajax/data-sales', 'DataSalesController@ajax')->name('ajax-data-sales');
    Route::post('/data-sales/export-excel', 'DataSalesController@exportExcel')->name('export-excel-data-sales');
    Route::get('/data-sales/action-excel/{filename}', 'DataSalesController@actionDownloadExcel')->name('action-excel-data-sales');
    Route::post('/data-sales/import-excel', 'DataSalesController@importExcel')->name('import-excel-data-sales');

    Route::get('/data-member', 'DataMemberController@index')->name('data-member.index');
    Route::post('/ajax/data-member', 'DataMemberController@ajax')->name('ajax-data-member');
    Route::post('/data-member/export-excel', 'DataMemberController@exportExcel')->name('export-excel-data-member');
    Route::get('/data-member/action-excel/{filename}', 'DataMemberController@actionDownloadExcel')->name('action-excel-data-member');
    Route::post('/data-member/import-excel', 'DataMemberController@importExcel')->name('import-excel-data-member');
    // Route::post('import', [HomeController::class, 'import'])->name('import');

    // =====Data Member Raw
    Route::get('/data-member-raw', 'DataMemberRawController@index')->name('data-member-raw.index');
    Route::post('/ajax/data-member-raw', 'DataMemberRawController@ajax')->name('ajax-data-member-raw');
    Route::post('/data-member-raw/export-excel', 'DataMemberRawController@exportExcel')->name('export-excel-data-member-raw');
    Route::get('/data-member-raw/action-excel/{filename}', 'DataMemberRawController@actionDownloadExcel')->name('action-excel-data-member-raw');
    Route::post('/data-member-raw/import-excel', 'DataMemberRawController@importExcel')->name('import-excel-data-member-raw');

    Route::get('/akumulasi-poin', 'AkumulasiPoinController@index')->name('akumulasi-poin.index');
    Route::post('/ajax/akumulasi-poin', 'AkumulasiPoinController@ajax')->name('ajax-akumulasi-poin');
    Route::post('/akumulasi-poin/export-excel', 'AkumulasiPoinController@exportExcel')->name('export-excel-akumulasi-poin');
    Route::get('/akumulasi-poin/action-excel/{filename}', 'AkumulasiPoinController@actionDownloadExcel')->name('action-excel-akumulasi-poin');
});

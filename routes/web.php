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

Auth::routes([
    "register" => false
]);

Route::group(['middleware' => 'admin'], function () {
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/data-sales', 'DataSalesController@index')->name('data-sales.index');
    Route::post('/ajax/data-sales', 'DataSalesController@ajax')->name('ajax-data-sales');
    Route::post('/data-sales/export-excel', 'DataSalesController@exportExcel')->name('export-excel-data-sales');
    Route::get('/data-sales/action-excel/{filename}', 'DataSalesController@actionDownloadExcel')->name('action-excel-data-sales');

    Route::get('/data-member', 'DataMemberController@index')->name('data-member.index');
    Route::post('/ajax/data-member', 'DataMemberController@ajax')->name('ajax-data-member');
    Route::post('/data-member/export-excel', 'DataMemberController@exportExcel')->name('export-excel-data-member');
    Route::get('/data-member/action-excel/{filename}', 'DataMemberController@actionDownloadExcel')->name('action-excel-data-member');

    Route::get('/akumulasi-poin', 'AkumulasiPoinController@index')->name('akumulasi-poin.index');
    Route::post('/ajax/akumulasi-poin', 'AkumulasiPoinController@ajax')->name('ajax-akumulasi-poin');
    Route::post('/akumulasi-poin/export-excel', 'AkumulasiPoinController@exportExcel')->name('export-excel-akumulasi-poin');
    Route::get('/akumulasi-poin/action-excel/{filename}', 'AkumulasiPoinController@actionDownloadExcel')->name('action-excel-akumulasi-poin');
});

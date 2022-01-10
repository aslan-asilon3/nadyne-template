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

Route::get('/', function () {
    return view('welcome');
});

Route::get('test/cek-member-data', 'TestController@cekMemberRaw');

Auth::routes([
    "register" => false
]);


Route::group(['middleware' => 'admin'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/data-sales', 'DataSalesController@index')->name('data-sales.index');
    Route::get('/ajax/data-sales', 'DataSalesController@ajax')->name('ajax-data-sales');
    Route::get('/data-member', 'DataMemberController@index')->name('data-member.index');
    Route::get('/ajax/data-member', 'DataMemberController@ajax')->name('ajax-data-member');
    Route::get('/akumulasi-poin', 'AkumulasiPoinController@index')->name('akumulasi-poin.index');
    Route::get('/ajax/akumulasi-poin', 'AkumulasiPoinController@ajax')->name('ajax-akumulasi-poin');
});

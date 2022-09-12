<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\UnicharmMemberraw\Create;
use App\Http\Controllers\DataMemberRawController;
use App\Http\Controllers\DataSalesController;
use App\Http\Controllers\AkumulasiPoinController;

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
});

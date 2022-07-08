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

    // =====Data Sales 
    Route::get('/data-sales', function () {
        return view('livewire.data-sales.index');
    }); 
    Route::post('/ajax/data-sales', 'DataSalesController@ajax')->name('ajax-data-sales');
    Route::get('data-sales/export', [DataSalesController::class, 'export'])->name('data-sales-export');
    Route::post('data-sales/import', [DataSalesController::class, 'import'])->name('data-sales-import');
    // =====End Data Sales 
    
    
    // =====Data Member 
    Route::get('/data-member', function () {
        return view('livewire.unicharm-member.index');
    }); 
    Route::post('/ajax/data-member', 'DataMemberController@ajax')->name('ajax-data-member');
    Route::get('/data-member/export', 'DataMemberController@export')->name('export-unicharm-member');
    // =====End Data Member 

    
    // =====Data Member Raw
    Route::get('/data-member-raw', function () {
        return view('livewire.unicharm-memberraw.index');
    });    
    Route::post('/ajax/data-member-raw', 'DataMemberRawController@ajax')->name('ajax-data-member-raw');
    Route::get('memberraw/export', [DataMemberRawController::class, 'export'])->name('memberraw-export');
    Route::post('memberraw/import', [DataMemberRawController::class, 'import'])->name('memberraw-import');
    // =====End Data Member Raw
    
    
    // =====Data Akumulasi Poin
    Route::get('/akumulasi-poin', function () {
        return view('livewire.akumulasi-poin.index');
    }); 
    Route::post('/ajax/akumulasi-poin', [AkumulasiPoinController::class, 'ajax'])->name('ajax-akumulasi-poin');
    Route::get('akumulasipoin/export', [AkumulasiPoinController::class, 'export'])->name('data-akumulasi-poin-export');
    // =====End Data Akumulasi Poin

});

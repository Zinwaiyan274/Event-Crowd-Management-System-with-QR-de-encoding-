<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ScannerController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [QrCodeController::class, 'generateQrPage'])->name('generatePage');
Route::post('generateQr', [QrCodeController::class, 'generateQr'])->name('generateQr');

Route::get('scanner', [ScannerController::class, 'scannerPage'])->name('scannerPage');
Route::post('scanner', [ScannerController::class, 'scan'])->name('scan');

Route::get('scanner/firstDay', [ScannerController::class, 'firstDayPage'])->name('firstDay');
Route::get('scanner/secondDay', [ScannerController::class, 'secondDayPage'])->name('secondDay');

Route::post('scanner/firstDay/csv', [ScannerController::class, 'firstDayCSV'])->name('firstDayCSV');
Route::post('scanner/secondDay/csv', [ScannerController::class, 'secondDayCSV'])->name('secondDayCSV');

Route::get('detail',[DetailController::class,'detail'])->name('detail');
Route::get('detail/firstDay',[DetailController::class,'firstDayDetail'])->name('firstDayDetail');
Route::get('detail/secondDay',[DetailController::class,'secondDayDetail'])->name('secondDayDetail');

// filter by company name
Route::get('/filter/company',[DetailController::class,'filterByCompany'])->name('filterByCompany');

// filter by role
Route::get('/filter/role',[DetailController::class,'filterByRole'])->name('filterByRole');

//filter by attend
Route::get('filter/attend',[DetailController::class,'filterByAttend'])->name('filterByAttend');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

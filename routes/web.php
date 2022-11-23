<?php

use Illuminate\Support\Facades\Route;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

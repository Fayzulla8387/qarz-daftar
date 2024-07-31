<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\QarzConteroller;
use \Illuminate\Support\Facades\Auth;

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
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', [FrontController::class, 'dashboard'])->name('dashboard');
    Route::get('/qarzdaftar', [FrontController::class, 'qarzdaftar'])->name('qarzdaftar');
//    Route::get('/madrasa_qarzlar', [FrontController::class, 'madrasa_qarzlar'])->name('madrasa_qarzlar');
    Route::get('/royhat', [FrontController::class, 'royhat'])->name('royhat');
    Route::get('/sms', [FrontController::class, 'sms'])->name('sms');
    Route::get('/muddati_otgan', [FrontController::class, 'muddati_otgan'])->name('muddati_otgan');
    Route::post('/qarzdor_yaratish', [QarzConteroller::class, 'qarzdor_yaratish'])->name('qarzdor_yaratish');
    Route::post('/qarz_berish', [QarzConteroller::class, 'qarz_berish'])->name('qarz_berish');
    Route::post('/qarz_uzish', [QarzConteroller::class, 'qarz_uzish'])->name('qarz_uzish');
    Route::post('/qarzdor_tahrirlash', [QarzConteroller::class, 'qarzdor_tahrirlash'])->name('qarzdor_tahrirlash');
    Route::post('/tarix', [QarzConteroller::class, 'tarix'])->name('tarix');
    Route::post('/bitta', [QarzConteroller::class, 'bittaSmsJonat'])->name('bitta-sms-jonat');
    Route::post('/tanlanganlara_jonat', [QarzConteroller::class, 'tanlanganlara_jonat'])->name('tanlanganlara_jonat');
    Route::post('/statistika_custom', [FrontController::class, 'dashboard2'])->name('statistika_custom');
    Route::post('/profile_update', [FrontController::class, 'profile_update'])->name('profile_update');
    Route::get('/profile', [FrontController::class, 'profile'])->name('profile');
    Route::post('/reklama_sms', [QarzConteroller::class, 'reklama_sms'])->name('reklama_sms');
    Route::get('/balansim', [FrontController::class, 'balansim'])->name('balansim');
    Route::get('eskitarix/{id}', [QarzConteroller::class, 'eskitarix'])->name('eskitarix');
    Route::get('qarzdor/{id}', [FrontController::class, 'qarzdor'])->name('qarzdor');


});


require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\HtmlController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtenteJoomlaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'dashboard')->middleware(['auth', 'verified']);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('autorizza', 'autorizza')
    ->middleware(['auth', 'verified'])
    ->name('autorizza');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::group(['api'], function () {
    Route::post('creautente', [UtenteJoomlaController::class, 'creaUtenteJoomla']);
    Route::post('authUser', [UtenteJoomlaController::class, 'authUser']);
})->middleware(['auth']);


Route::group(['html'], function () {
    Route::post('tabella_autorizzazioni', [HtmlController::class, 'tabella_autorizzazioni']);
})->middleware(['auth']);

require __DIR__ . '/auth.php';

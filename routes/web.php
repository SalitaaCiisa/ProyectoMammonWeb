<?php

use App\Http\Controllers\abonosController;
use App\Http\Controllers\cobrosController;
use App\Http\Controllers\cuentasController;
use App\Http\Controllers\usuariosController;
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

Route::view('/','index')->name('inicio');

Route::view('/login','login')->name('login');

Route::view('/register','register')->name('register');

#CONTROLLERS
Route::resource('usuarios', usuariosController::class)->only('store');
Route::resource('cuentas', cuentasController::class)->only(['index','store','update','destroy'])->name('index','cuentas');
Route::resource('abonos', abonosController::class)->only(['index','store','update','destroy'])->name('index','abonos');
Route::resource('cobros', cobrosController::class)->only(['index','store','update','destroy'])->name('index','cobros');

Route::get('/cobrosB', [cobrosController::class, 'show'])->name('cobros.show');

Route::get('/confirmarUsuario', [usuariosController::class, 'search']);
Route::get('/desconectarCuenta', [usuariosController::class, 'logOut']);

<?php

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

Route::get('/', function () {
    return view('index');
});

Route::get('/cuentas', function () {
    return view('cuentasBancarias');
});

Route::get('/cobros', function () {
    return view('cobros');
});

Route::get('/abonos', function () {
    return view('abonos');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::view('/','index')->name('inicio');

Route::get('/cuentas',[cuentasController::class, 'index'])->name('cuentas');

Route::view('/cobros','cobros')->name('cobros');

Route::view('/abonos','abonos')->name('abonos');

Route::view('/login','login')->name('login');

#CONTROLLERS
Route::resources([
    'usuariosController' => usuariosController::class,
]);

Route::resources([
    'cuentasController' => cuentasController::class,
]);

Route::get('/confirmarUsuario', [usuariosController::class, 'search']);
Route::post('/desconectarCuenta', [usuariosController::class, 'logOut']);
Route::post('/crearUsuario', [usuariosController::class, 'store']);

Route::post('/crearCuenta', [cuentasController::class, 'store']);
Route::delete('/borrarCuenta', [cuentasController::class, 'destroy']);
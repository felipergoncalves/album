<?php

use App\Http\Controllers\PhotoController;
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

Route::get('/', [PhotoController::class,'index']);
Route::get('/photos/new', [PhotoController::class,'create']);

//Rota que insere no banco de dados uma nova foto
Route::post('/photos',[PhotoController::class,'store']);

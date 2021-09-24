<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Product;
use App\Http\Controllers\Apikey_validation; 

Route::get('/Prod', 'App\Http\Controllers\Product@index');

            //OR
// Route::get('/Prod', [Product :: class, 'index']);
// Route::get()

Route::get('/Prod/newFunction', [Product :: class, 'newFunction']);
Route::get('/Apikey_validation/api_key_checking', [Apikey_validation :: class, 'api_key_checking']);

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

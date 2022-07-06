<?php

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

Route::get('master/asset/{time}/{name}.js',function($id,$name){
    return 'const __master_asset_' . $name .' = ' . $id;
})->name('master_asset_js')->middleware('cache.headers:public;max_age=2628000;etag');

Route::view('/','Eleoi::home');
Route::view('{eleoi_segments}', 'Eleoi::home');


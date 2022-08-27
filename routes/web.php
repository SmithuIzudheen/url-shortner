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

Route::get('/', function () {
    return redirect('/short-url');
});


/** 
 * Short URL Management
*/ 

Route::group(["prefix"=>"short-url","as"=>"short-url."], function () {
    Route::get("/", "App\Http\Controllers\ShortUrlController@index")->name("index");
    Route::post("/{uuid}/destroy", "App\Http\Controllers\ShortUrlController@destroy")->name("destroy");
    Route::post("/store","App\Http\Controllers\ShortUrlController@store")->name("store");
});

Route::get("/{short_url}", "App\Http\Controllers\ShortUrlController@redirect")->name("redirect");

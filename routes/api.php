<?php

use App\Http\Controllers\CreateBinar;
use App\Http\Controllers\ManageBinar;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'binar'], function() {
    Route::post('create', [CreateBinar::class, 'store']);
    Route::get("fill", [ManageBinar::class, "fillTable"]);
    Route::get('{binar}/related', [ManageBinar::class, "getRelated"]);
});

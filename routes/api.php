<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('allow_access:api')->group(function (){

    // Позиция прайслиста

    Route::get('/price/{price}', function(Request $request){
        return new \App\Http\Resources\PriceResource(\App\Price::find($request->price));
    });

    // Товар

    Route::get('/products/{product}', function(Request $request){
        return new \App\Http\Resources\ProductResource(\App\Product::find($request->product));
    });

});

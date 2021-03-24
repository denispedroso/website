<?php

use App\Events\UserSignedUp;

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

Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/token', 'ApiTokenController@update')->name('token')->middleware('verified');

// Main page
Route::get('/', 'MainController@main');


Route::get('nav/index', 'NavController@index');
Route::get('nav/itens', 'NavController@itens');

// Carousel routes
Route::get('carousel', 'CarouselController@create')->middleware('verified')->name('carousel');
Route::get('carousel/index/{number?}', 'CarouselController@index');
Route::get('carousel/nocachedindex', 'CarouselController@noCachedIndex');
Route::post('carousel/store', 'CarouselController@store')->middleware('verified');
Route::post('carousel/destroy', 'CarouselController@destroy')->middleware('verified');
Route::post('carousel/show', 'CarouselController@show')->middleware('verified');
Route::get('carousel/{carousel}', 'CarouselController@list');
// .End of Carousel Routes

// Product routes
Route::get('product', 'ProductController@create')->middleware('verified')->name('product');
Route::get('product/index/{number?}', 'ProductController@index');
Route::get('product/nocachedindex', 'ProductController@noCachedIndex');
Route::post('product/store', 'ProductController@store')->middleware('verified');
Route::post('product/destroy', 'ProductController@destroy')->middleware('verified');
Route::post('product/show', 'ProductController@show')->middleware('verified');
Route::get('product/{product}', 'ProductController@list');
// .End of Product Routes

// Type routes
Route::get('type', 'TypeController@create')->middleware('verified')->name('type');
Route::get('type/index', 'TypeController@index');
Route::post('type/store', 'TypeController@store')->middleware('verified');
Route::post('type/destroy', 'TypeController@destroy')->middleware('verified');
Route::post('type/show', 'TypeController@show')->middleware('verified');
// .End of Type Routes

// Brand routes
Route::get('brand', 'BrandController@create')->middleware('verified')->name('brand');
Route::get('brand/index', 'BrandController@index');
Route::post('brand/store', 'BrandController@store')->middleware('verified');
Route::post('brand/destroy', 'BrandController@destroy')->middleware('verified');
Route::post('brand/show', 'BrandController@show')->middleware('verified');
// .End of Brand Routes

// List routes
Route::get('list/{type}', 'ListController@type');
Route::get('list/{type}/{brand}', 'ListController@typeBrand');

//Contato
Route::view('/contato', 'public.contato')->name('contato');

//Contato
Route::get('test', function () {

    cache(['teste' => [1, 2, 3]], now()->addMinutes(5));
    $test = cache('teste');
    dump($test);

    return cache('teste');
});



// Route to test cookies
//Route::get('/cookie', function () {
//    session(['key' => 'value']);
//    return response('Teste Cookie')
//        ->cookie('color', encrypt('blue'), 10);
//});

//Route::get('/socket', function () {
//    $data = [
//        'event' => 'UserSignedUp',
//        'data' => [
//            'username' => 'JohnDoe'
//        ]
//    ];
//
//    Redis::publish('test-channel', json_encode($data));
//
//    event(new UserSignedUp('JonhDoe'));
//
//    return view('clear');
//});

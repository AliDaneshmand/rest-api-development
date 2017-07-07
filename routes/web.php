<?php

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
    //echo '<pre>';
    //return var_export(anetwork\Category::where('title', 'Gadget')->first()->id);
    //return anetwork\Category::orderBy('priority')->get()->toArray();
    return 'Rest API development assignment.';
});

Route::get('/input.json', 'ProductController@input');

Route::get('/output.json', 'ProductController@output');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

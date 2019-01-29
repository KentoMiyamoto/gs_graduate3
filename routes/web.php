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

// use	App\Book;
use	App\entry;
use	Illuminate\Http\Request;		


Route::get('/','BooksController@index');

// エントリー画面
Route::post('/portal','BooksController@entry');

//  エントリーを削除 
Route::post('/entry/delete/{entry}', 'BooksController@destroy');

//  table share 
Route::post('/matching/{entry}', 'BooksController@matching');

//  OK 
Route::post('/ok', 'BooksController@ok');

Route::post('/ng', 'BooksController@ng');

Route::post('/goryu', 'BooksController@goryu');

Route::POST('/','BooksController@index');

/**
* 新「本」を追加 
*/
Route::post('/books', 'BooksController@store'); 


// 更新画面
Route::post('/booksedit/{books}', 'BooksController@edit');


// 更新処理
Route::post('/books/update','BooksController@update');


Auth::routes();

Route::get('/home', 'BooksController@index')->name('home');


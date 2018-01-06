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

// アプリのエントリポイント
Route::get('/', function () {
    Debugbar::info('CurrentDirectory : '.__DIR__);
    return "HelloWorld!";
});

Route::get('blade', function(){
    return view('child');
});

// Contoroller側からアクセス
Route::get('top', 'top@top');

// 名前付きルートでアクセス
Route::get('/mypage', [
    'as' => 'mypage.route',
    function(){
        return "mypage";
    }
    
]);

<?php

use Illuminate\Support\Facades\Route;

// ★ここが回路の接続点
// どんなURLがきても 'index' というビュー（画面）を表示する
Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');

<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


// ユーザー側（未ログインOK）
Route::get('/', [ContactController::class, 'index']); // トップページ
Route::get('/contact', [ContactController::class, 'create'])->name('contact.form'); // 入力画面
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm'); // 確認画面
Route::post('/thanks', [ContactController::class, 'store'])->name('contact.store'); // 保存→完了画面


// 管理者側（ログイン必須）
Route::middleware('auth')->group(function () {
    Route::get('/admin', [ContactController::class, 'admin'])->name('admin'); // 管理画面
    Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
    Route::get('/search', [ContactController::class, 'search'])->name('contact.search'); // 検索
    Route::post('/delete', [ContactController::class, 'delete'])->name('contact.delete'); // 削除
    Route::get('/export', [ContactController::class, 'export'])->name('contact.export'); // CSV出力
    // ✅ 削除機能も含めたCRUDルート
    Route::resource('contacts', ContactController::class);


});
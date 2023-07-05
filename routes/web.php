<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\MicropostsController;
use App\Http\Controllers\UserFollowController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ThreadsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MicropostsController::class, 'index']);

Route::get('/dashboard',[MicropostsController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth']], function () {                                    // 追記
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow',[UserFollowController::class, 'store'])->name('user.follow');
        Route::delete('unfollow',[UserFollowController::class, 'destroy'])->name('user.unfollow');
        Route::get('folloeings',[UsersController::class, 'followings'])->name('users.followings');
        Route::get('followers',[UsersController::class, 'followers'])->name('users.followers');
        Route::get('favorites',[UsersController::class, 'favorites'])->name('users.favorites');
        Route::get('profile',[UsersController::class,'profile'])->name('users.profile'); //ユーザプロフィール画面
        Route::get('profile/edit',[UsersController::class,'edit'])->name('users.edit'); //ユーザプロフィール編集画面
        Route::put('profile',[UsersController::class,'update'])->name('users.update'); //ユーザプロフィール編集処理
    });
    
    Route::resource('users', UsersController::class, ['only' => ['index', 'show']]);      // 追記
    Route::resource('microposts', MicropostsController::class, ['only' => ['store', 'destroy']]);
    Route::get('microposts/{id}/edit',[MicropostsController::class,'edit'])->name('microposts.edit');
    Route::put('microposts/{id}/edit',[MicropostsController::class,'update'])->name('microposts.update');
    
    Route::group(['prefix' => 'micropost/{id}'], function () {
        Route::get('threads',[ThreadsController::class, 'index'])->name('threads'); //受け取ったmicropost_idの返信一覧画面
        Route::delete('threads',[ThreadsController::class, 'destroy'])->name('threads.destroy'); //返信の削除
    });
    Route::get('threads/{id}/edit',[ThreadsController::class, 'edit'])->name('threads.edit');
    Route::put('threads/{id}/edit',[ThreadsController::class, 'update'])->name('threads.update');  
    Route::post('threads',[ThreadsController::class, 'store'])->name('threads.store'); //返信の作成
    
    Route::group(['prefix' => 'microposts/{id}'], function () {
       Route::post('favorites',[FavoritesController::class, 'store'])->name('favorite.favorite');
       Route::delete('unfavorites',[FavoritesController::class, 'destroy'])->name('favorite.unfavorite');
    });
}); 

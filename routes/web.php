<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NewsController;
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

Route::get('/', [LoginController::class, 'show'])->name('login');
Route::get('login', [LoginController::class, 'show'])->name('login');
Route::get('logout', function () {
    auth()->logout();
    return view('auth.login');
})->name('logout');
Route::get('oauth/{driver}', [LoginController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');
Route::group(['middleware' => 'auth'], function () {
    Route::get("top-headlines", [NewsController::class, "fetchTopNewsView"]);
    Route::get("fetchTopHeadlines", [NewsController::class, "fetchTopHeadlines"]);
    Route::post("setFollowedKeyword", [NewsController::class, "setFollowedKeyword"]);
    Route::get("explore",[NewsController::class,"exploreNewsTopics"]);
    Route::get("returnSources",[NewsController::class,"returnSources"]);
    Route::get("followedKeywords",[NewsController::class,"followedKeywords"]);
});
Route::get('clear_cache', function () {
    \Artisan::call('config:cache');
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    dd('done');
});
Route::get('migrate', function () {
    \Artisan::call('migrate');
    dd('done');
});

<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPermissionController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
    return view('welcome');
});

Route::prefix('cms/admin')->middleware('guest:admin')->group(function(){
    Route::get('/login', [AdminAuthController::class,'showLogin'])->name('auth.login.view');
    Route::post('/login',[AdminAuthController::class,'login'])->name('auth.login');
});


Route::prefix('cms/user')->middleware('guest:user')->group(function(){
    Route::get('/login', [UserAuthController::class,'showLogin'])->name('auth-user.login.view');
    Route::post('/login',[UserAuthController::class,'login'])->name('auth-user.login');
});

Route::prefix('cms/admin')->middleware('auth:admin,user')->group(function () {
    Route::view('', 'cms.dashboard')->name('cms.dashboard');
});


Route::prefix('cms/admin')->middleware('auth:admin')->group(function(){
    // Route::view('', 'cms.dashboard')->name('cms.dashboard');

    Route::resource('/admin', AdminController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/doctor', DoctorController::class);
    Route::resource('/patient', PatientController::class);
    Route::resource('/secretary', SecretaryController::class);
    Route::resource('/city', CityController::class);

    Route::resource('/roles', RolesController::class);
    Route::resource('/permissions', PermissionController::class);

    Route::resource('admin.permission',AdminPermissionController::class);

    Route::get('/edit-password',[AdminAuthController::class,'editpassword'])->name('auth.edit-password');
    Route::put('/update-password',[AdminAuthController::class,'updatePassword'])->name('auth.update-password');

    Route::get('/edit-profile',[AdminAuthController::class,'editProfile'])->name('auth.edit-profile');
    Route::put('/update-profile',[AdminAuthController::class,'updateProfile'])->name('auth.update-profile');


    Route::get('/logout',[AdminAuthController::class,'logout'])->name('auth.logout');


});

Route::prefix('cms/user')->middleware('auth:user')->group(function(){
    // Route::view('', 'cms.dashboard')->name('cms.dashboard');

    // Route::resource('/admin', AdminController::class);
    // Route::resource('/user', UserController::class);
    // Route::resource('/doctor', DoctorController::class);
    // Route::resource('/patient', PatientController::class);
    // Route::resource('/secretary', SecretaryController::class);
    // Route::resource('/city', CityController::class);

    // Route::resource('/roles', RolesController::class);
    // Route::resource('/permissions', PermissionController::class);

    // Route::resource('admin.permission',AdminPermissionController::class);

    Route::get('/edit-password',[UserAuthController::class,'editpassword'])->name('auth.edit-password');
    Route::put('/update-password',[UserAuthController::class,'updatePassword'])->name('auth.update-password');

    Route::get('/edit-profile',[UserAuthController::class,'editProfile'])->name('auth.edit-profile');
    Route::put('/update-profile',[UserAuthController::class,'updateProfile'])->name('auth.update-profile');




    Route::get('/logout-user',[UserAuthController::class,'logout'])->name('auth-user.logout');
});

//googel login
Route::get('/login/google',[SocialController::class,'redirectToGoogle'])->name('auth.login.google');
Route::get('/login/google/callback',[SocialController::class,'handleGoogleCallback']);

//facebook login
Route::get('/login/facebook',[SocialController::class,'redirectToFacebook'])->name('auth.login.facebook');
Route::get('/login/facebook/callback',[SocialController::class,'handleFacebookCallback']);

//github login
Route::get('/login/github',[SocialController::class,'redirectToGithub'])->name('auth.login.github');
Route::get('/login/github/callback',[SocialController::class,'handleGithubCallback']);


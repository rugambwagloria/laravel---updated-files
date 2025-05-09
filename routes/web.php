<?php

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


use App\Http\Controllers\PageController;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ChallengeController;




Route::get('/', [LoginController::class, 'welcome'])->middleware('guest')->name('welcome');

// web.php
Route::get('/dashboard',[LoginController::class, 'dashboard'])->name('dashboard');
Route::get('/schools-performance', [PageController::class, 'index'])->name('schools-performance');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');


	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');


	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'end'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');

Route::group(['middleware' => 'auth:admin'], function () {
    // Admin routes here
    Route::get('/home', [LoginController::class, 'dashboard'])->name('home');
    Route::post('/schools-performance', [PageController::class, 'view'])->name('schools-performance.show');

        Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
        //Route::get('/profile-static', [PageController::class, 'school'])->name('profile-static');
        //Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
        Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');

        Route::get('/pages/{page}', [PageController::class, 'index'])->name('page');
        Route::get('school', [ App\Http\Controllers\SchoolController::class, 'create'])->name('school');
Route::get('/school-management',[App\Http\Controllers\SchoolController::class, 'displaySchoolDetails'])->name('schools.display');
Route::post('school', [ App\Http\Controllers\SchoolController::class, 'store'])->name('school.store');
Route::get('/challenge-creation', [ChallengeController::class, 'create'])->name('challenges.create');
Route::get('/challenge-index', [ChallengeController::class, 'index'])->name('challenges.index');
Route::post('/challenge-creation', [ChallengeController::class, 'store'])->name('challenges.store');

Route::get('/questions-uploading', [App\Http\Controllers\QuestionController::class, 'uploadForm'])->name('questions.upload.form');
Route::post('/questions-uploading', [App\Http\Controllers\ChallengeController::class, 'upload'])->name('questions.upload');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');


});




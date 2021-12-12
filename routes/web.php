<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'ajax']);
Route::get('/teacher/all', [App\Http\Controllers\HomeController::class, 'teacherAll']);
Route::POST('/teacher/store/', [App\Http\Controllers\HomeController::class, 'storeData']);
Route::get('/teacher/edit/{id}', [App\Http\Controllers\HomeController::class, 'DataEdit']);
Route::POST('/teacher/update/{id}', [App\Http\Controllers\HomeController::class, 'updateData']);
Route::get('/teacher/delete/{id}', [App\Http\Controllers\HomeController::class, 'datetrData']);

Route::get('/student', [App\Http\Controllers\studentController::class, 'student_form']);

Route::get('/student/alldata', [App\Http\Controllers\studentController::class, 'StudentallData']);

Route::POST('/student/store', [App\Http\Controllers\studentController::class, 'storeData']);

Route::get('/student/edit/{id}', [App\Http\Controllers\studentController::class, 'DataEdit']);

Route::POST('/student/update', [App\Http\Controllers\studentController::class, 'updateData']);

Route::get('ajax-image-upload',  [App\Http\Controllers\ajax_image_upload\ImageUploadController::class,'index']);
Route::post('ajax-image-upload', [App\Http\Controllers\ajax_image_upload\ImageUploadController::class,'store']);



use App\Http\Controllers\ImageController;


Route::get('upload-images', [ ImageController::class, 'index' ]);
Route::post('upload-images', [ ImageController::class, 'storeImage' ])->name('images.store');

Route::get('/fetch-image', [ ImageController::class, 'fetchImage' ]);
Route::get('/edit-image/{id}', [ ImageController::class, 'editImage' ]);
Route::post('/update', [ ImageController::class, 'updateImage' ]);


Route::post('/delete/{id}', [ ImageController::class, 'deleteImage' ]);

// Route::group(['prefix' => 'admin','middleware'=>['admin','auth'],'namespace'=>'admin'], function () {
//     Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.dashbord');
// });


// Route::group(['prefix' => 'user','middleware'=>['user','auth'],'namespace'=>'user'], function () {
//     Route::get('/dashboard', [App\Http\Controllers\User\userController::class, 'index'])->name('user.dashbord');
// });

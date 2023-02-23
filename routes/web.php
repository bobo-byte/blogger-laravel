<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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

Route::get('/', [PostController::class, 'home']); //gets all the posts available.

//posts
Route::get('/user/posts/post/create', [PostController::class, 'create'])->middleware("auth")->name("create_showPost");
Route::post('/user/posts/post/add', [PostController::class,'store'])->middleware("auth")->name("add_post");
Route::get('/user/posts/{post}/edit', [PostController::class,'edit'])->middleware("auth")->name("edit_post");
Route::put('/user/posts/{post}/update', [PostController::class, 'update']);
Route::delete('/user/posts/{post}/delete',[PostController::class, 'delete'])->middleware("auth")->name("delete_post");

//post
Route::get('/post/{post}/show', [PostController::class, 'show']);



//user
Route::get('/dashboard/user/edit/read', [UserController::class, 'show'])->middleware("auth")->name("edit_user");
Route::put('/dashboard/user/edit/update', [UserController::class, 'update'])->middleware("auth")->name("edit_userUpdate");
Route::delete('/dashboard/user/edit/delete', [UserController::class, 'destroy'])->middleware("auth")->name("edit_userDelete");



Route::get('/help', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $currentUser_posts = Auth::user()->posts;
    return view('dashboard', ["posts" => $currentUser_posts]);
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

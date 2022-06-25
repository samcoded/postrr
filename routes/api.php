<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

//Public

//Base routes
Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to the Postrr API. You have reached the base of the API.',
        'description' => 'You can use this to register, login, or create, read, update, and delete posts and comments.',
        'docs' => 'https://documenter.getpostman.com/view/14158032/UzBsGPf5',
    ]);
});

//UserController
Route::post('/register', [UserController::class, 'register']); //register
Route::post('/login', [UserController::class, 'login']); //login

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    //UserController
    Route::post('/logout', [UserController::class, 'logout']); //Logout
    Route::get('/user', [UserController::class, 'current']); //get current user
    Route::get('/user/all', [UserController::class, 'index']); //get all users
    Route::get('/user/{id}', [UserController::class, 'show']); //get user by id

    //FollowController
    Route::post('/follow/{id}', [FollowController::class, 'follow']); //toggle follow a user
    Route::get('/user/{id}/followers', [FollowController::class, 'user_followers']); //users followers
    Route::get('/user/{id}/following', [FollowController::class, 'user_following']); //users following

    //PostController
    Route::get('/posts', [PostController::class, 'index']); //get all posts
    Route::post('/posts', [PostController::class, 'store']); //create a post
    Route::get('/posts/{id}', [PostController::class, 'show']); //get post by id
    Route::put('/posts/{id}', [PostController::class, 'update']); //update post
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); //delete a post
    Route::get('/posts/search/{$searchTerm}', [PostController::class, 'search']); //search posts by searchTerm
    Route::get('/user/{id}/posts', [PostController::class, 'user_posts']); //users posts
    Route::get('/user/{id}/followings/posts', [PostController::class, 'following_posts']); //user's following posts
    Route::post('/posts/{id}/like', [PostController::class, 'like']); //toggle likes
    Route::get('/posts/{id}/likes', [PostController::class, 'likes']); //get  post likes

    //CommentController
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']); //create comment
    Route::get('/posts/{id}/comments', [CommentController::class, 'index']); //get comments
    Route::get('/comments/{comment_id}', [CommentController::class, 'show']); //get comment
    Route::put('/comments/{comment_id}', [CommentController::class, 'update']); //update comment
    Route::delete('/comments/{comment_id}', [CommentController::class, 'destroy']); //delete comment

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
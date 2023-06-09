<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\FrontendController@index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/new-topic', function () {
    return view('client.new-topic');
});
Route::get('/category/overview/{id}', 'App\Http\Controllers\FrontendController@categoryOverview')->name('category.overview');

Route::get('/forum/overview/{id}', 'App\Http\Controllers\FrontendController@forumOverview')->name('forum.overview');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard/home', 'App\Http\Controllers\DashboardController@home');
    // Category
    Route::get('dashboard/category/new', 'App\Http\Controllers\CategoryController@create')->name('category.new');
    Route::post('dashboard/category/new', 'App\Http\Controllers\CategoryController@store')->name('category.store');
    Route::get('dashboard/categories', 'App\Http\Controllers\CategoryController@index')->name('categories');
    Route::get('dashboard/categories/{id}', 'App\Http\Controllers\CategoryController@show')->name('category');

    Route::get('dashboard/categories/edit/{id}', 'App\Http\Controllers\CategoryController@edit')->name('category.edit');
    Route::post('dashboard/categories/edit/{id}', 'App\Http\Controllers\CategoryController@update')->name('category.update');
    Route::get('dashboard/categories/delete/{id}', 'App\Http\Controllers\CategoryController@destroy')->name('category.destroy');
    // Forums
    Route::get('dashboard/forum/new', 'App\Http\Controllers\ForumController@create')->name('forum.new');
    Route::post('dashboard/forum/new', 'App\Http\Controllers\ForumController@store')->name('forum.store');
    Route::get('dashboard/forums', 'App\Http\Controllers\ForumController@index')->name('forums');

    Route::get('dashboard/forums/{id}', 'App\Http\Controllers\ForumController@edit')->name('forum');
    Route::get('dashboard/forums/edit/{id}', 'App\Http\Controllers\ForumController@edit')->name('forum.edit');
    Route::post('dashboard/forums/edit/{id}', 'App\Http\Controllers\ForumController@update')->name('forum.update');
    Route::get('dashboard/forums/delete/{id}', 'App\Http\Controllers\ForumController@destroy')->name('forum.destroy');
    // Users
    Route::get('/dashboard/users', 'App\Http\Controllers\DashboardController@users');
    Route::get('/dashboard/admin/profile', 'App\Http\Controllers\DashboardController@profile')->name('admin.profile');
    Route::get('/dashboard/users/{id}', 'App\Http\controllers\DashboardController@show');
    Route::post('/dashboard/users/{id}', 'App\Http\Controllers\DashboardController@destroy')->name('user.delete');

    Route::get('/dashboard/notifications', 'App\Http\Controllers\DashboardController@notifications')->name('notifications');
    Route::get('/dashboard/notifications/mark-as-read/{id}', 'App\Http\Controllers\DashboardController@markAsRead')->name('notifications.read');
    Route::get('/dashboard/notifications/delete/{id}', 'App\Http\Controllers\DashboardController@notificationDestroy')->name('notifications.delete');
    Route::get('/dashboard/setttings/form', 'App\Http\Controllers\DashboardController@settingsForm')->name('settings.form');
    Route::post('/dashboard/settings/new', 'App\Http\Controllers\DashboardController@newSetting')->name('settings.new');
});



// Topics
Route::get('client/topic/new/{id}', 'App\Http\Controllers\DiscussionController@create')->name('discussion.new');
Route::post('client/topic/new', 'App\Http\Controllers\DiscussionController@store')->name('discussion.store');
Route::get('client/topic/{id}', 'App\Http\Controllers\DiscussionController@show')->name('topic');
Route::post('client/topic/{id}', 'App\Http\Controllers\DiscussionController@reply')->name('topic.reply');
Route::get('client/topic/remove/{id}', 'App\Http\Controllers\DiscussionController@remove')->name('topic.destroy');
route::get('/topic/reply/destroy/{id}', 'App\Http\Controllers\DiscussionController@destroy')->name('reply.destroy');
// Route::get('client/topic', 'App\Http\Controllers\TopicController@index')->name('forums');

// Route::get('client/topic/{id}', 'App\Http\Controllers\TopicController@edit')->name('topic');
// Route::get('client/topic/edit/{id}', 'App\Http\Controllers\TopicController@edit')->name('topic.edit');
// Route::post('client/topic/edit/{id}', 'App\Http\Controllers\TopicController@update')->name('topic.update');
// Route::get('client/topic/delete/{id}', 'App\Http\Controllers\TopicController@destroy')->name('topic.destroy');

Route::get('/updates', 'App\Http\Controllers\DiscussionController@updates');
Route::post('user/update/{id}', 'App\Http\Controllers\UserController@update')->name("user.update");



Route::get('/client/user/{id}', 'App\Http\Controllers\FrontendController@profile')->middleware('auth')->name('client.user_profile');
Route::get('/client/users', 'App\Http\Controllers\FrontendController@users')->middleware('auth')->name('client.users');
Route::post('user/photo/update/{id}', 'App\Http\Controllers\FrontendController@photoUpdate')->name('user.photo.update');

Route::post('topics/sort', 'App\Http\Controllers\DiscussionController@sort')->name('topics.sort');
Route::get('reply/like/{id}', 'App\Http\Controllers\DiscussionController@like')->name('reply.like');
Route::get('reply/dislike/{id}', 'App\Http\Controllers\DiscussionController@dislike')->name('reply.dislike');
Route::post('category/search', 'App\Http\Controllers\CategoryController@search')->name('category.search');

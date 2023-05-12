<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteInfoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLogController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\OfflineMessageController;
use App\Http\Controllers\RatingInfoController;
use App\Http\Controllers\SupportController;

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

Route::middleware(['guest'])->group(function(){
    Route::get('/',[WebsiteInfoController::class, 'index'])->name('heading');
});
Route::post('/settings/store/',[WebsiteInfoController::class, 'store'])->name('settings_store');
Route::get('/settings/create/',[WebsiteInfoController::class, 'create'])->name('settings_create');
Route::get('/about',[WebsiteInfoController::class, 'show'])->name('about');
Route::get('/welcome',[DashboardController::class, 'show'])->name('welcome');
Route::get('/filtered_posts/{topic}',[TopicController::class, 'show'])->name('topic.show');
Route::get('/single_post/{slug}',[PostController::class, 'show'])->name('single_post');
Route::post('/post/logs',[ActivityLogController::class, 'show'])->name('postlogs');
Route::get('/underconstruction', function () {return view('underconstruction');});
Route::post('/support',[SupportController::class, 'store'])->name('user.support');


Route::match(['get','post'],'/user',[UserController::class, 'index'])->name('user.delete');

Route::middleware(['auth'])->group(function(){

    Route::middleware(['admin'])->group(function(){

        Route::group(['prefix' => 'admin'], function () {

            Route::get('/inbox',[SupportController::class, 'index'])->name('support');
            Route::get('/inbox/{id}/show',[SupportController::class, 'show'])->name('support.show');
            Route::get('/inbox/create',[SupportController::class, 'create'])->name('support.create');
            Route::get('/settings',[WebsiteInfoController::class, 'edit'])->name('settings')->middleware('password.confirm');
            Route::get('/settings/update/')->name('settings_update');
            Route::post('/settings/update/{website_info}',[WebsiteInfoController::class, 'update']);

           // Route::get('/support',[SupportController::class, 'index'])->name('admin.support');

            Route::match(['get','post'],'/posts',[PostController::class, 'index'])->name('post');
            Route::post('/posts/{post}/edit',[PostController::class, 'edit'])->name('post.edit');
            Route::get('/posts/create',[PostController::class, 'create'])->name('post.create');
            Route::post('/posts/create',[PostController::class, 'store']);
            Route::post('/posts/{post}/update',[PostController::class, 'update']);
            Route::delete('/posts/{post}/delete',[PostController::class, 'destroy']);

            Route::match(['get','post'],'/user',[UserController::class, 'index'])->name('user');
            // test link


            Route::get('/user/csv/',[UserController::class, 'downloadCSV'])->name('user.csv');
            Route::post('/user/create',[UserController::class, 'store'])->name('user.create');
            Route::get('/user/create',[UserController::class, 'store']);
            Route::post('/user/{user}/edit',[UserController::class, 'edit']);
            Route::post('/user/{user}/show',[UserController::class, 'show']);
            Route::delete('/user/{user}/delete',[UserController::class, 'destroy']);
            Route::match(['get','post','put'],'/user/{user}/update', [UserController::class, 'update']);

            Route::match(['get','post'],'/topics',[TopicController::class, 'index'])->name('topic');
            Route::post('/topics/{topic}/edit',[TopicController::class, 'edit']);
            Route::get('/topics/create',[TopicController::class, 'create'])->name('topic.create');
            Route::post('/topics/create',[TopicController::class, 'store']);
            Route::post('/topics/{topic}/update',[TopicController::class, 'update']);
            Route::delete('/topics/{topic}/delete',[TopicController::class, 'destroy']);

            Route::match(['get','post'],'/tickets',[TicketController::class, 'index'])->name('ticket');
            Route::post('/tickets/{ticket}/edit',[TicketController::class, 'edit']);
            Route::get('/tickets/create',[TicketController::class, 'create'])->name('ticket.create');
            Route::post('/tickets/create',[TicketController::class, 'store']);
            
            Route::post('/tickets/{ticket}/update',[TicketController::class, 'update']);
            Route::delete('/tickets/{ticket}/delete',[TicketController::class, 'destroy']);

            Route::match(['get','post'],'/tickets/comments',[TicketCommentController::class, 'index'])->name('ticket.comments');
            Route::post('/tickets/comments/create',[TicketCommentController::class, 'store'])->name('ticket.comments.create');
            Route::delete('/tickets/comments/{ticketComment}/delete',[TicketCommentController::class, 'destroy']);


            Route::get('/',[DashboardController::class, 'create']);
            Route::get('/dashboard',[DashboardController::class, 'create'])->name('admin.dashboard');
            Route::post('/dashboard/refresh',[DashboardController::class, 'edit'])->name('admin.dashboard.edit');
            Route::post('/profile/{user}/update',[UserController::class, 'update'])->name('admin.profile.update');
            Route::get('/profile',[UserController::class, 'create'])->name('profile');
            Route::get('/change_password',[UserController::class, 'create'])->name('password');
            Route::post('/change_password/{user}',[UserController::class, 'update']);
            Route::get('/activitylog/{id?}',[ActivityLogController::class, 'index'])->name('activitylog');
            Route::post('/activitylog/{activityLog}',[ActivityLogController::class, 'store']);
            Route::get('/alerts/{id?}',[AlertController::class, 'index'])->name('alerts');
            Route::post('/alerts/update',[AlertController::class, 'update']);
            Route::post('/alerts/delete',[AlertController::class, 'destroy']);
            Route::get('/messages/{id?}',[OfflineMessageController::class, 'index'])->name('messages');
            Route::post('/messages/update',[OfflineMessageController::class, 'update']);
            Route::post('/messages/delete',[OfflineMessageController::class, 'destroy']);
            Route::post('/messages/{offlineMessage?}',[OfflineMessageController::class, 'store']);

        });

    });
    Route::post('/userlog/update')->name('userlog');
    Route::post('/userlog/update/{userlog}',[UserLogController::class, 'update']);
    Route::post('/profile/{user}/update',[UserController::class, 'update'])->name('user.profile.update');
    Route::get('/profile',[UserController::class, 'create'])->name('user.profile');
    Route::get('/change_password',[UserController::class, 'create'])->name('user.password');
    Route::post('/change_password/{user}',[UserController::class, 'update']);
    Route::get('/messages',[OfflineMessageController::class, 'index'])->name('user.messages');

    Route::post('/messages/update',[OfflineMessageController::class, 'update'])->name('user.messages.update');
    Route::post('/messages/delete',[OfflineMessageController::class, 'destroy'])->name('user.messages.deetel');
    Route::post('/messages/{offlineMessage}',[OfflineMessageController::class, 'store'])->name('user.messages.store');
    Route::get('/activitylog',[ActivityLogController::class, 'index'])->name('user.activitylog');
    Route::post('/activitylog/delete',[ActivityLogController::class, 'destroy']);
    Route::post('/activitylog/delete_similar',[ActivityLogController::class, 'destroy']);

    Route::get('/alerts',[AlertController::class, 'index'])->name('user.alerts');
    Route::post('/alerts/update',[AlertController::class, 'update'])->name('user.alerts.update');
    Route::post('/alerts/delete',[AlertController::class, 'destroy'])->name('user.alerts.delete');
    Route::get('/messages',[OfflineMessageController::class, 'index'])->name('user.messages');

    Route::get('/followers',[FollowerController::class, 'index'])->name('followers');
    Route::post('/followers',[FollowerController::class, 'update']);
    Route::post('/followers/update',[FollowerController::class, 'update'])->name('followers.update');
    Route::post('/followers/delete',[FollowerController::class, 'destroy'])->name('followers.delete');

    Route::get('/ratings',[RatingInfoController::class, 'index'])->name('ratings');
    Route::post('/ratings',[RatingInfoController::class, 'update']);
    Route::post('/ratings/delete',[RatingInfoController::class, 'destroy'])->name('ratings.delete');



    Route::post('/post/comments',[CommentController::class, 'store'])->name('comments');
    Route::post('/post/comments/update',[CommentController::class, 'update'])->name('comments.update');
    Route::post('/post/comments/delete',[CommentController::class, 'destroy'])->name('comments.delete');

    Route::post('/post/replies',[ReplyController::class, 'store'])->name('replies');
    Route::post('/post/replies/update',[ReplyController::class, 'update'])->name('replies.update');
    Route::post('/post/replies/delete',[ReplyController::class, 'destroy'])->name('replies.delete');

    Route::get('/home',[PostController::class, 'show'])->name('home');

    Route::match(['get','post'],'/post',[PostController::class, 'index'])->name('article');
        Route::post('/post/{post}/edit',[PostController::class, 'edit'])->name('article.edit');
        Route::get('/post/{post}/edit',[PostController::class, 'edit']);
        Route::get('/post/create',[PostController::class, 'create'])->name('article.create');
        Route::post('/post/store',[PostController::class, 'store'])->name('article.store');
        Route::post('/post/{post}/update',[PostController::class, 'update']);
        Route::post('/post/update/{post}',[PostController::class, 'update']);
        Route::delete('/post/{post}/delete',[PostController::class, 'destroy']);
        Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
        Route::get('/settings',[WebsiteInfoController::class, 'edit'])->name('user.settings');
        Route::get('/profile/user/{users?}',[UserController::class, 'create'])->name('user.profileview');

        Route::get('/conversation/{message_id?}',[OfflineMessageController::class, 'create'])->name('conversation');
        Route::post('/conversation',[OfflineMessageController::class, 'store']);
        Route::delete('/conversation/{id}/delete',[OfflineMessageController::class, 'destroy']);
    });

require __DIR__.'/auth.php';
Route::middleware(['auth','admin'])->group(function(){
    Route::get('admin/{page}', function ($page) {
        // Check if the view file exists
        if (view()->exists('admin/'.$page)) {
            // Return the view
            return view('admin/'.$page);
        } else {
           
            // The view file does not exist
            abort(404);
        }
    });
});
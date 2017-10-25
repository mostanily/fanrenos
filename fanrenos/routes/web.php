<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/login', 'Auth\LoginController@login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/register', 'Auth\LoginController@register');
Route::post('/register', 'Auth\LoginController@register');
Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/logout', 'Auth\LoginController@logout');

// 发送密码重置链接路由（邮箱）
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
// 密码重置路由（邮箱）
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');

//处理markdown图片上传
Route::post('/uploads/markdown_image','MarkdownController@uploads');

Route::get('/','HomeController@index');
Route::get('/experience','HomeController@showPersonerExperience');

Route::group(['prefix' => 'blog'], function () {
    Route::get('/', 'HomeController@index');
    Route::post('/comment','CommentController@index');//评论
    Route::get('/more_comment','CommentController@showMoreComment');//展示更多评论
    Route::post('/comment/delete','CommentController@deleteComment');//删除评论
    Route::post('/comment/thumb','CommentController@showThumb');//评论的点赞或鄙视
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'UserController@index');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', 'UserController@showUserProfile');
        Route::get('/profile/avatar','UserController@showUserProfileAvatar');
        Route::post('/profile/avatar','UserController@UpdateUserProfileAvatar');
        Route::put('/profile/{id}', 'UserController@updateUserProfile');
        Route::post('/follow/{id}', 'UserController@doFollow');
    });

    Route::group(['prefix' => '{name}'], function () {
        Route::get('/', 'UserController@showUserInfo');
        Route::get('comments', 'UserController@comments');
        Route::get('following', 'UserController@following');
    });
});

Route::group(['middleware' => 'auth', 'prefix' => 'setting'], function () {
    Route::get('/', 'UserController@showUserSetting');
    Route::post('/change','UserController@changePassword');
});

Route::get('/search','HomeController@showSearch');
Route::get('/contact', 'ContactController@showForm');
Route::post('/contact', 'ContactController@sendContactInfo');

Route::group(['prefix' => 'php'],function(){
    Route::get('/{path}','CategoryController@getArticleByCategory');
});
Route::group(['prefix' => 'sql'],function(){
    Route::get('/{path}','CategoryController@getArticleByCategory');
});
Route::group(['prefix' => 'system'],function(){
    Route::get('/{path}','CategoryController@getArticleByCategory');
});
Route::group(['prefix' => 'tools'],function(){
    Route::get('/{path}','CategoryController@getArticleByCategory');
});
Route::group(['prefix' => 'life'],function(){
    Route::get('/{path}','CategoryController@getArticleByCategory');
});
Route::group(['prefix' => 'fashion'],function(){
    Route::get('/music','MusicController@index');
    Route::get('/album','AlbumController@index');
});

Route::get('/blog/{slug}', 'HomeController@showPost');
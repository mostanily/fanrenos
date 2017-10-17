<?php
Route::get('login', 'Auth\AuthController@login');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');
Route::post('logout', 'Auth\AuthController@logout');

Route::group(['middleware' => ['auth:admin', 'menu']], function () {
    Route::get('/', function () {
        return redirect('/dashboard/home');
    });
    Route::get('/index', function () {
        return redirect('/dashboard/home');
    });
    Route::get('/clear/cache','AdminController@cacheClear');
    Route::get('/home', ['as' => 'dashboard.home', 'uses' => 'AdminController@index']);
    Route::get('/visitor', 'AdminController@getVisitor');
    Route::get('/recovery/{handle}/{id}','AdminController@recycle_normal');//恢复被软删除的信息
    Route::post('/batch_delete/{model}','AdminController@batch_delete');//批量删除(如果为软删除，则为软删除)

    Route::get('/system', ['as' => 'dashboard.system', 'uses' => 'SystemController@getSystemInfo']);
    //菜单管理
    //用户管理
    Route::get('/user/index', ['as' => 'dashboard.user.index', 'uses' => 'UserController@index']);
    Route::get('/user/recycle/index', ['as' => 'dashboard.user_recycle.index', 'uses' => 'UserController@recycle_index']);//回收站
    Route::resource('user', 'UserController', ['names' => ['edit'=>'dashboard.user.edit','update' => 'dashboard.user.edit','create'=>'dashboard.user.create', 'store' => 'dashboard.user.create','destroy'=>'dashboard.user.destroy']]);

    //文章管理
    Route::get('/article/index', ['as' => 'dashboard.article.index', 'uses' => 'ArticleController@index']);
    Route::get('/article/recycle/index', ['as' => 'dashboard.article_recycle.index', 'uses' => 'ArticleController@recycle_index']);//回收站
    Route::get('/article/index_table','ArticleController@indexTable');
    Route::get('/article/recycle_index_table','ArticleController@recycle_indexTable');
    Route::post('/article/real_delete/{id}',['as' => 'dashboard.real_delete.index', 'uses' => 'ArticleController@real_delete']);//彻底删除文章
    Route::resource('article', 'ArticleController', ['names' => ['edit'=>'dashboard.article.edit','update' => 'dashboard.article.edit','create'=>'dashboard.article.create', 'store' => 'dashboard.article.create','destroy'=>'dashboard.article.destroy']]);

    //标签管理
    Route::get('/tag/index', ['as' => 'dashboard.tag.index', 'uses' => 'TagController@index']);
    Route::get('/tag/recycle/index', ['as' => 'dashboard.tag_recycle.index', 'uses' => 'TagController@recycle_index']);//回收站
    Route::resource('tag', 'TagController', ['names' => ['edit'=>'dashboard.tag.edit','update' => 'dashboard.tag.edit','create'=>'dashboard.tag.create', 'store' => 'dashboard.tag.create','destroy'=>'dashboard.tag.destroy']]);

    //个人经历
    Route::get('/experience/index', ['as' => 'dashboard.experience.index', 'uses' => 'ExperienceController@index']);
    Route::resource('experience', 'ExperienceController', ['names' => ['edit'=>'dashboard.experience.edit','update' => 'dashboard.experience.edit','create'=>'dashboard.experience.create', 'store' => 'dashboard.experience.create','destroy'=>'dashboard.experience.destroy']]);

    //评论管理
    Route::get('/comment/index', ['as' => 'dashboard.comment.index', 'uses' => 'CommentController@index']);
    Route::get('/comment/recycle/index', ['as' => 'dashboard.comment_recycle.index', 'uses' => 'CommentController@recycle_index']);//回收站
    Route::post('/comment/real_delete/{id}',['as' => 'dashboard.real_delete.index', 'uses' => 'CommentController@real_delete']);//彻底删除评论
    Route::resource('comment', 'CommentController', ['names' => ['edit'=>'dashboard.comment.edit','update' => 'dashboard.comment.edit','destroy'=>'dashboard.comment.destroy']]);

    //友情链接
    Route::get('/link/index', ['as' => 'dashboard.link.index', 'uses' => 'LinkController@index']);
    Route::get('/link/recycle/index', ['as' => 'dashboard.link_recycle.index', 'uses' => 'LinkController@recycle_index']);//回收站
    Route::post('/link/real_delete/{id}',['as' => 'dashboard.real_delete.index', 'uses' => 'LinkController@real_delete']);//彻底删除
    Route::resource('link', 'LinkController', ['names' => ['edit'=>'dashboard.link.edit','update' => 'dashboard.link.edit','create'=>'dashboard.link.create', 'store' => 'dashboard.link.create','destroy'=>'dashboard.link.destroy']]);
    
    //音乐管理
    Route::get('/music/index',['as' => 'dashboard.music.index', 'uses' => 'MusicController@index']);
    Route::get('/music/index_table','MusicController@indexTable');
    Route::get('/music/recycle_index_table','MusicController@recycle_indexTable');
    Route::get('/music/recycle/index', ['as' => 'dashboard.music_recycle.index', 'uses' => 'MusicController@recycle_index']);//回收站
    Route::post('/music/real_delete/{id}',['as' => 'dashboard.real_delete.index', 'uses' => 'MusicController@real_delete']);//彻底删除
    Route::get('/music/update_info',['as'=>'dashboard.music.update_info','uses'=>'MusicController@uploadMusic']);//更新新的音乐文件
    Route::post('/music/logo_upload/{id}',['as'=>'dashboard.music.logo_upload','uses'=>'MusicController@logoUpload']);//上传音乐封面图
    Route::post('/music/lrc_upload/{id}',['as'=>'dashboard.music.lrc_upload','uses'=>'MusicController@lrcUpload']);//上传音乐歌词
    Route::post('/music/store_one',['as'=>'dashboard.music.store_one','uses'=>'MusicController@musicStore']);//上传单曲
    Route::get('/music/deal_image',['as'=>'dashboard.music.deal_image','uses'=>'MusicController@dealMusicImage']);//批量处理专辑封面图中的大图
    Route::resource('music', 'MusicController', ['names' => ['destroy'=>'dashboard.music.destroy']]);

    //相册管理
    Route::get('/album/index',['as' => 'dashboard.album.index', 'uses' => 'AlbumController@index']);
    Route::get('/album/recycle/index', ['as' => 'dashboard.album_recycle.index', 'uses' => 'AlbumController@recycle_index']);//回收站
    Route::get('/album/index_table','AlbumController@indexTable');
    Route::get('/album/recycle_index_table','AlbumController@recycle_indexTable');
    Route::post('/album/real_delete/{id}',['as' => 'dashboard.real_delete.index', 'uses' => 'AlbumController@real_delete']);//彻底删除
    Route::get('/album/update_info',['as'=>'dashboard.album.update_info','uses'=>'AlbumController@uploadAlbum']);
    Route::post('/album/update_info',['as'=>'dashboard.album.update_info','uses'=>'AlbumController@uploadAlbum']);
    Route::resource('album', 'AlbumController', ['names' => ['destroy'=>'dashboard.album.destroy']]);

    Route::get('/file/index', ['as' => 'dashboard.file.index', 'uses' => 'AdminController@index']);
    Route::get('/category/index', ['as' => 'dashboard.category.index', 'uses' => 'AdminController@index']);
    Route::get('/category/create', ['as' => 'dashboard.category.create', 'uses' => 'AdminController@index']);
});
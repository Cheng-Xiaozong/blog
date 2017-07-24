<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::auth();
//首页
Route::get('/', 'Ariticle\AriticleController@index');
//文章详情页
Route::get('ariticle/detail/{id}', 'Ariticle\AriticleController@detail');
//需要登陆的页面
Route::group(['middleware'=>['auth']],function(){
    //我的博客
    Route::get('myblog', 'Ariticle\AriticleController@myblog');
    //发表博客
    Route::any('ariticle/create', 'Ariticle\AriticleController@create');
    //删除博客
    Route::get('ariticle/delete/{id}', 'Ariticle\AriticleController@delete');
    //编辑博客
    Route::any('ariticle/edit/{id}', 'Ariticle\AriticleController@edit');
    //我的博客详情
    Route::get('myAriticleDetail/{id}', 'Ariticle\AriticleController@myAriticleDetail');
    //博客点赞
    Route::any('ariticle/praise/{id}', 'Ariticle\AriticleController@praise');
    //上传头像
    Route::any('updatePt', 'Ariticle\AriticleController@updatePt');
    //修改资料
    Route::post('updateMyInfo', 'Ariticle\AriticleController@updateMyInfo');
});


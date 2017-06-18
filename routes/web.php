<?php

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

//url get请求
//访问 http://www.mylaravel.com/index.php/get
Route::get('get',function(){
    return 'this is a get req';
});
//url post请求
Route::post('post',function(){
    return 'this is a post req';
});

//url get或post请求
Route::match(['get','post'],'match',function(){
    return 'this is a match req';
});
//url 任意请求
Route::any('any',function(){
    return 'this is an any req';
});

//url 带参数 uid 必须传 ，非必须 uid后加?
Route::get('user/{uid}',function($uid = null){
    return 'this is user req ,uid='.$uid;
});
//url 带参数uid 和 name  非必须传
Route::get('userInfo/{uid?}/{name?}',function($uid=null,$name=null){
    return "this is user req ,param uid={$uid},name={$name}";
});
//url 带必传参数且 参数要通过 正则验证 ,uid 必须数字 name 不为空
Route::get('userQuery/{uid}/{name}',function($uid = null,$name=null){
    return "this is userQuery req and valid with pattern ,uid={$uid},name={$name}";
})->where(['uid'=>'\d+','name'=>'\S+']);


//路由别名,方便统一管理路由， 使用route()获取路由，一个url变动就全站改过来了
Route::get('data/order-center/{uid?}/{order_id?}',['as'=>'order',function($uid=null,$order_id=null){
    //如果那里在需要用到这个url ，就用别名来获取
    return route('order',['uid'=>$uid,'order_id'=>$order_id]);
}]);

// 路由群组
// 访问url ： http://www.mylaravel.com/index.php/center/order/detail
Route::group(['prefix'=>'center'],function(){
    Route::get('user/profile',function(){
        return 'this center/user/profile';
    });
    Route::get('order/detail',function(){
        return 'this center/order/detail';
    });
});

//路由调用控制器
//Route::get('test/profile','TestController@profile');
//uses 是controller，as 是别名 ,交给了controller处理反回
//Member\MemberController@profile 的路径是 /app/Http/Controllers/Member/MemberController.php 里的 profile 方法
Route::get('member/profile/{uid?}',['uses'=>'Member\MemberController@profile','as'=>'member-profile']);



















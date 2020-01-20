<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


// 站点首页
Route::get('/', 'index/index/index');

Route::get('search', 'index/search/index');

Route::get('feedback', 'index/feedback/index');

// 栏目列表
Route::get('channel-<cat_id>', 'index/category/index')
    ->pattern(['cat_id' => '\d+']);

// 文档详情
Route::get('detail-<id>$', 'index/document/index')
    ->pattern(['id' => '\d+']);
    
// 标签
Route::get('tags-<tag_id>$', 'index/tags/detail')
    ->pattern(['tag_id' => '\d+']);

//首页的album
//Route::rule('ctnmit$','admin/Passport/login');
//首页的album
Route::rule('index$','index/Index/index');
//解决方案
Route::rule('solution$','index/Index/solution');
//新闻资讯
Route::rule('news$','index/Index/news');
//新闻资讯详情
Route::rule('news/:id$','index/Index/news_detail?id=:id');
//关于我们
Route::rule('about$','index/Index/about');
//联系我们
Route::rule('contact$','index/Index/contact');

return [
    
];

<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
$api = app('Dingo\Api\Routing\Router');

/**
 * Api V1.0 版本
 * 增加 api 接口限制次数  绑定 ip 5分钟内只能请求500次!
 */
$api->version('v1', function ($api) {
    $api->group(["namespace" => "App\Api\Controllers\Admin"], function ($api) {
        $api->get('/admin', ['as' => 'api.admin.index', 'uses' => 'AdminController@index']);
        $api->post('auth/login', ['uses' => 'AuthController@login']);
        $api->post('auth/logout', ['uses' => 'AuthController@logout']);
    });
});

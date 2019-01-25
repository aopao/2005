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

        /*获取管理员个人信息*/
        $api->get('admin/profile', ['as' => 'api.admin.profile', 'uses' => 'AdminController@profile']);

        /*登录注册退出路由*/
        $api->get('auth/login', ['as' => 'api.admin.auth.login', 'uses' => 'AuthController@login']);
        $api->post('auth/login', ['uses' => 'AuthController@login']);
        $api->post('auth/logout', ['uses' => 'AuthController@logout']);

        /*管理员管理管理路由*/
        $api->resource('admin', 'AdminController');

        /*大学类型管理管理路由*/
        $api->resource('college/category', 'CollegeCategoryController');

        /*大学信息管理管理路由*/
        $api->resource('college', 'CollegeController');

        /*省份管理管理路由*/
        $api->get('province/option_list', 'ProvinceController@option_list');
        $api->resource('province', 'ProvinceController');

        /*管理管理路由*/
        $api->post('role/permission', ['uses' => 'RoleController@givePermission']);
        $api->post('role/user', ['uses' => 'RoleController@giveUser']);
        $api->resource('role', 'RoleController');
        $api->resource('permission', 'PermissionController');
    });
});

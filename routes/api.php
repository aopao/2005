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
//$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 500, 'expires' => 1], function ($api) {

    $api->group(["namespace" => "App\Api\Controllers\Admin"], function ($api) {

        /*获取管理员个人信息*/
        $api->get('admin/profile', ['as' => 'api.admin.profile', 'uses' => 'AdminController@profile']);

        /*登录注册退出路由*/
        $api->get('auth/login', ['as' => 'api.admin.login', 'uses' => 'AuthController@login']);
        $api->post('auth/login', ['uses' => 'AuthController@login']);
        $api->post('auth/logout', ['uses' => 'AuthController@logout']);

        /*管理员管理管理路由*/
        $api->resource('admin', 'AdminController');

        /*大学类型管理管理路由*/
        $api->resource('college/category', 'CollegeCategoryController', ['as' => 'college']);

        /*大学层次管理管理路由*/
        $api->resource('college/diplomas', 'CollegeDiplomasController', ['as' => 'college']);

        /*大学信息管理管理路由*/
        $api->resource('college', 'CollegeController');

        /*大学信息管理管理路由*/
        $api->get('major/levelOptionList', 'MajorController@levelOptionList');
        $api->resource('major', 'MajorController');

        /*省份省控线管理管理路由*/
        $api->resource('provinceControlScore', 'ProvinceControlScoreController');

        /*省份管理管理路由*/
        $api->get('province/optionList', 'ProvinceController@optionList');
        $api->resource('province', 'ProvinceController');

        /*VIP服务卡管理路由*/
        $api->get('vipCard/optionList', 'vipCardController@optionList');
        $api->resource('vipCard', 'vipCardController');

        /*序列号管理路由*/
        $api->resource('serialNumber', 'SerialNumberController');

        /*管理管理路由*/
        $api->post('role/permission', ['uses' => 'RoleController@givePermission']);
        $api->post('role/user', ['uses' => 'RoleController@giveUser']);
        $api->resource('role', 'RoleController');
        $api->resource('permission', 'PermissionController');
    });
});

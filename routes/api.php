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
//$api->version('v1', function ($api) {
$api->version('v1', [
    'middleware' => 'api.throttle',
    'limit' => 5000,
    'expires' => 1,
], function ($api) {

    $api->group(["namespace" => "App\Api\Controllers\Admin", 'prefix' => 'admin'], function ($api) {

        /*登录注册退出路由*/
        $api->get('auth/login', ['as' => 'admin.login', 'uses' => 'AuthController@login']);
        $api->post('auth/login', ['uses' => 'AuthController@login']);
        $api->post('auth/logout', ['as' => 'admin.logout', 'uses' => 'AuthController@logout']);

        /*获取管理员个人信息*/
        $api->get('profile', ['as' => 'admin.profile', 'uses' => 'AdminController@profile']);

        /*管理员管理管理路由*/
        $api->resource('/admin', 'AdminController', ['as' => 'admin']);

        /*代理商管理管理路由*/
        $api->get('/agent/getControlProvince/{agent_id}', ['as' => 'admin.agent.getControlProvince', 'uses' => 'AgentController@getControlProvince']);
        $api->post('/agent/batch', ['as' => 'admin.agent.batchProvince', 'uses' => 'AgentController@batch']);
        $api->get('/agent/query/{agent_id}', ['as' => 'admin.agent.query', 'uses' => 'AgentController@getQueryList']);
        $api->resource('/agent', 'AgentController', ['as' => 'admin']);

        /*大学类型管理管理路由*/
        $api->resource('college/category', 'CollegeCategoryController', ['as' => 'admin.college']);

        /*大学层次管理管理路由*/
        $api->resource('college/diplomas', 'CollegeDiplomasController', ['as' => 'admin.college']);

        /*大学信息管理管理路由*/
        $api->resource('college', 'CollegeController', ['as' => 'admin']);

        /*大学信息管理管理路由*/
        $api->get('major/levelOptionList', ['as' => 'admin.major.levelOptionList', 'uses' => 'MajorController@levelOptionList']);
        $api->resource('major', 'MajorController', ['as' => 'admin']);

        /*省份省控线管理管理路由*/
        $api->post('province/ControlScoreUpload', ['as' => 'admin.province.control.score.upload', 'uses' => 'ProvinceControlScoreController@ControlScoreUpload']);
        $api->resource('provinceControlScore', 'ProvinceControlScoreController', ['as' => 'admin']);

        /*省份管理管理路由*/
        $api->get('province/optionList', ['as' => 'admin.province.optionList', 'uses' => 'ProvinceController@optionList']);
        $api->resource('province', 'ProvinceController', ['as' => 'admin']);

        /*VIP服务卡管理路由*/
        $api->get('vipCard/optionList', ['as' => 'admin.vipCard.optionList', 'uses' => 'vipCardController@optionList']);
        $api->resource('vipCard', 'vipCardController', ['as' => 'admin']);

        /*序列号管理路由*/
        $api->post('/serialNumber/agent/batch/', ['as' => 'admin.batch.agent.SerialNumber', 'uses' => 'SerialNumberController@batchSerialNumber']);
        $api->resource('serialNumber', 'SerialNumberController', ['as' => 'admin']);

        /*文章内容分类管理管理路由*/
        $api->get('article/category/optionList', ['as' => 'admin.article.category.optionList', 'uses' => 'ArticleCategoryController@optionList']);
        $api->resource('article/category', 'ArticleCategoryController', ['as' => 'admin.article.category']);

        $api->post('article/UploadThumb', ['as' => 'admin.article.UploadThumb', 'uses' => 'ArticleController@UploadThumb']);
        $api->resource('article', 'ArticleController', ['as' => 'admin.article']);

        /*角色权限管理管理路由*/
        $api->get('role/permission/{role_id}', ['as' => 'admin.role.permission', 'uses' => 'RoleController@permission']);
        $api->post('role/givePermission', ['as' => 'admin.role.give.permission', 'uses' => 'RoleController@givePermission']);
        $api->get('role/optionList', ['as' => 'admin.role.optionList', 'uses' => 'RoleController@optionList']);
        $api->resource('role', 'RoleController', ['as' => 'admin']);
        $api->get('permission/optionList', ['as' => 'admin.permission.optionList', 'uses' => 'PermissionController@optionList']);
        $api->get('permission/control/optionList', ['as' => 'admin.permission.control.optionList', 'uses' => 'PermissionController@controlOptionList']);
        $api->resource('permission', 'PermissionController', ['as' => 'admin']);
    });

    $api->group(["namespace" => "App\Api\Controllers\Agent", 'prefix' => 'agent'], function ($api) {
        /*登录注册退出路由*/
        $api->get('auth/login', ['as' => 'agent.login', 'uses' => 'AuthController@login']);
        $api->post('auth/login', ['uses' => 'AuthController@login']);
        $api->post('auth/logout', ['as' => 'agent.logout', 'uses' => 'AuthController@logout']);
    });
});

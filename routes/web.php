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
/**
 * 数据转换使用,用后删除!
 */
Route::get('/c', function () {
    ini_set('memory_limit', '3072M');    // 临时设置最大内存占用为3G
    set_time_limit(0);   // 设置脚本最大执行时间 为0 永不过期
    $relation = [
        '211' => 1,
        '985' => 2,
        "中央直属" => 3,
        "教育部直属" => 4,
        "研究生院" => 5,
        "博士生院" => 6,
        "公办" => 7,
        "双一流" => 8,
        "自主招生" => 9,
        "千人计划" => 10,
        "卓越计划" => 11,
    ];
    $data = \App\Entities\College::select(
        ['id', 'name', 'is_985', 'is_211', 'is_belong_to_edu', 'is_belong_to_center', 'is_nation', 'is_top_college', 'doctor_number', 'postgraduate_number'])
        ->get()->toArray();
    foreach ($data as $value) {
        if ($value['is_211'] == 1) {
            $data = [
                'college_id' => $value['id'],
                'college_attributes_id' => 1,
            ];
            \App\Entities\CollegeHasAttribute::create($data);
        }
        if ($value['is_985'] == 1) {
            $data = [
                'college_id' => $value['id'],
                'college_attributes_id' => 2,
            ];
            \App\Entities\CollegeHasAttribute::create($data);
        }
        if ($value['is_belong_to_center'] == 1) {
            $data = [
                'college_id' => $value['id'],
                'college_attributes_id' => 3,
            ];
            \App\Entities\CollegeHasAttribute::create($data);
        }
        if ($value['is_belong_to_edu'] == 1) {
            $data = [
                'college_id' => $value['id'],
                'college_attributes_id' => 4,
            ];
            \App\Entities\CollegeHasAttribute::create($data);
        }
        if ($value['is_nation'] == 1) {
            $data = [
                'college_id' => $value['id'],
                'college_attributes_id' => 7,
            ];
            \App\Entities\CollegeHasAttribute::create($data);
        }
        if ($value['is_top_college'] == 1) {
            $data = [
                'college_id' => $value['id'],
                'college_attributes_id' => 8,
            ];
            \App\Entities\CollegeHasAttribute::create($data);
        }
        if ($value['doctor_number'] > 0) {
            $data = [
                'college_id' => $value['id'],
                'college_attributes_id' => 6,
            ];
            \App\Entities\CollegeHasAttribute::create($data);
        }
        if ($value['postgraduate_number'] > 0) {
            $data = [
                'college_id' => $value['id'],
                'college_attributes_id' => 5,
            ];
            \App\Entities\CollegeHasAttribute::create($data);
        }
    }
    echo "OK!";
});
Route::get('/a', 'MajorsController@index');

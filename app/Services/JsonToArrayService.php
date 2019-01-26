<?php
/**
 * 将 Json 转换成 Array
 * User: jason
 * Date: 2018/9/17
 * Time: 下午1:38
 */

namespace App\Services;

class JsonToArrayService
{
    /**
     * 获取 json 源文件数据
     *
     * @param $filename
     * @return mixed
     */
    public static function getJson($filename)
    {
        $filepath = __DIR__.'/../../data/'.$filename;
        $content = file_get_contents($filepath);

        return json_decode($content, true);
    }
}
<?php

namespace App\Api\Serializers;

class ResponseFormat
{
    /**
     * 自定义返回的成功 Json类型
     *
     * @param string $message
     * @param array  $data
     * @param int    $status
     * @return array
     */
    public function success($data = [], $message = 'success', $status = 200)
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'timestamp' => time(),
        ];
    }

    /**
     * 自定义返回的失败 Json类型
     *
     * @param int    $status
     * @param string $message
     * @return array
     */
    public function error($message = '操作出错!', $status = 404)
    {
        return [
            'status' => $status,
            'message' => $message,
            'timestamp' => time(),
        ];
    }
}
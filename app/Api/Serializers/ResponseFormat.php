<?php

namespace App\Api\Serializers;

class ResponseFormat
{
    /**
     * 自定义返回的成功 Json类型
     *
     * @param array  $data
     * @param int    $status
     * @param string $message
     * @return array
     */
    public function success($data = [], $status = 200, $message = 'success')
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
    public function error($status = 404, $message = 'error')
    {
        return [
            'status' => $status,
            'message' => $message,
            'timestamp' => time(),
        ];
    }
}
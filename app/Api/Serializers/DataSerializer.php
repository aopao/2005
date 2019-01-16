<?php

namespace App\Api\Serializers;

class DataSerializer
{
    /**
     * 自定义返回的 Json类型
     *
     * @param array $data
     * @return array
     */
    public function response($data)
    {
        return [
            'status' => 200,
            'message' => 'success',
            'result' => [
                'data' => $data,
            ],
            'timestamp' => time(),
        ];
    }

    /**
     * 返回成功方法
     *
     * @param string $message
     * @return array
     */
    public function succee($message = 'succee')
    {
        return [
            'status' => 200,
            'message' => $message,
            'timestamp' => time(),
        ];
    }

    /**
     * 返回失败方法
     *
     * @param string $message
     * @return array
     */
    public function error($message = 'error')
    {
        return [
            'status' => 404,
            'message' => $message,
            'timestamp' => time(),
        ];
    }
}
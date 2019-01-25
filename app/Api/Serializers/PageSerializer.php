<?php

namespace App\Api\Serializers;

class PageSerializer
{
    /**
     * 自定义返回的 Json类型
     *
     * @param array  $data
     * @param int    $pageSize
     * @param int    $pageNo
     * @param int    $totalPage
     * @param int    $totalCount
     * @param int    $status
     * @param string $message
     * @return array
     */
    public function collection($data, $pageSize = 10, $pageNo = 1, $totalPage = 0, $totalCount = 0, $status = 200, $message = 'success')
    {
        return [
            'status' => $status,
            'message' => $message,
            'timestamp' => time(),
            'result' => [
                'data' => $data,
                'pageSize' => $pageSize,
                'pageNo' => $pageNo,
                'totalPage' => $totalPage,
                'totalCount' => $totalCount,
            ],
        ];
    }
}
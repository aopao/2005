<?php

namespace App\Api\Serializers;

class PageSerializer
{
    /**
     * 自定义返回的 Json类型
     *
     * @param array  $data
     * @param int    $status
     * @param string $message
     * @param int    $pageSize
     * @param int    $pageNo
     * @param int    $totalPage
     * @param int    $totalCount
     * @return array
     */
    public function collection($data, $status = 200, $message = 'success', $pageSize = 10, $pageNo = 1, $totalPage = 0, $totalCount = 0)
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
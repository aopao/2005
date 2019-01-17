<?php

namespace App\Api\Serializers;

use League\Fractal\Serializer\ArraySerializer;

class DataArraySerializer extends ArraySerializer
{
    /**
     * Serialize a collection
     *
     * @param string $resourceKey
     * @param array  $data
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        $resultData = ['data' => $data, 'status_code' => 200, 'message' => 'success'];
        if (! empty($resourceKey)) {
            $resultData['total'] = $resourceKey;
        }

        return $resultData;
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return ['data' => $data, 'status_code' => 200, 'message' => 'success'];
    }

    /**
     * Serialize null resource.
     *
     * @return array
     */
    public function null()
    {
        return ['data' => [], 'status_code' => 200, 'message' => 'success'];
    }
}
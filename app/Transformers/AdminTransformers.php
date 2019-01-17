<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class AdminTransformers extends TransformerAbstract
{
    public function transform($model)
    {
        return [
            'guid' => $model['guid'],
            'mobile' => $model['mobile'],
            'nickname' => $model['nickname'],
            'email' => $model['email'],
            'qq' => $model['qq'],
            'status' => $model['status'] == 1 ? true : false,
        ];
    }
}
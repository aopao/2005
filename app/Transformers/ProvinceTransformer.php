<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Province;

/**
 * Class ProvinceTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProvinceTransformer extends TransformerAbstract
{
    /**
     * Transform the Province entity.
     *
     * @param \App\Entities\Province $model
     *
     * @return array
     */
    public function transform(Province $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

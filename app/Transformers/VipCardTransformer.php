<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\VipCard;

/**
 * Class VipCardTransformer.
 *
 * @package namespace App\Transformers;
 */
class VipCardTransformer extends TransformerAbstract
{
    /**
     * Transform the VipCard entity.
     *
     * @param \App\Entities\VipCard $model
     *
     * @return array
     */
    public function transform(VipCard $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

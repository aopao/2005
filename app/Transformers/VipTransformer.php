<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Vip;

/**
 * Class VipTransformer.
 *
 * @package namespace App\Transformers;
 */
class VipTransformer extends TransformerAbstract
{
    /**
     * Transform the Vip entity.
     *
     * @param \App\Entities\Vip $model
     *
     * @return array
     */
    public function transform(Vip $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

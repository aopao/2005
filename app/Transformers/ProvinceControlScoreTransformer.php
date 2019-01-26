<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ProvinceControlScore;

/**
 * Class ProvinceControlScoreTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProvinceControlScoreTransformer extends TransformerAbstract
{
    /**
     * Transform the ProvinceControlScore entity.
     *
     * @param \App\Entities\ProvinceControlScore $model
     *
     * @return array
     */
    public function transform(ProvinceControlScore $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

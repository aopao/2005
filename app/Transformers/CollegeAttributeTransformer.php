<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CollegeAttribute;

/**
 * Class CollegeAttributeTransformer.
 *
 * @package namespace App\Transformers;
 */
class CollegeAttributeTransformer extends TransformerAbstract
{
    /**
     * Transform the CollegeAttribute entity.
     *
     * @param \App\Entities\CollegeAttribute $model
     *
     * @return array
     */
    public function transform(CollegeAttribute $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

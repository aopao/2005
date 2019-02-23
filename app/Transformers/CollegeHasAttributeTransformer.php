<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CollegeHasAttribute;

/**
 * Class CollegeHasAttributeTransformer.
 *
 * @package namespace App\Transformers;
 */
class CollegeHasAttributeTransformer extends TransformerAbstract
{
    /**
     * Transform the CollegeHasAttribute entity.
     *
     * @param \App\Entities\CollegeHasAttribute $model
     *
     * @return array
     */
    public function transform(CollegeHasAttribute $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

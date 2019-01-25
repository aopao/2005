<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CollegeCategory;

/**
 * Class CollegeCategoryTransformer.
 *
 * @package namespace App\Transformers;
 */
class CollegeCategoryTransformer extends TransformerAbstract
{
    /**
     * Transform the CollegeCategory entity.
     *
     * @param \App\Entities\CollegeCategory $model
     *
     * @return array
     */
    public function transform(CollegeCategory $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

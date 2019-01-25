<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\College;

/**
 * Class CollegeTransformer.
 *
 * @package namespace App\Transformers;
 */
class CollegeTransformer extends TransformerAbstract
{
    /**
     * Transform the College entity.
     *
     * @param \App\Entities\College $model
     *
     * @return array
     */
    public function transform(College $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

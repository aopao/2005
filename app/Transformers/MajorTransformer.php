<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Major;

/**
 * Class MajorTransformer.
 *
 * @package namespace App\Transformers;
 */
class MajorTransformer extends TransformerAbstract
{
    /**
     * Transform the Major entity.
     *
     * @param \App\Entities\Major $model
     *
     * @return array
     */
    public function transform(Major $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

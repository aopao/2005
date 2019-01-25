<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CollegeDiplomas;

/**
 * Class CollegeDiplomasTransformer.
 *
 * @package namespace App\Transformers;
 */
class CollegeDiplomasTransformer extends TransformerAbstract
{
    /**
     * Transform the CollegeDiplomas entity.
     *
     * @param \App\Entities\CollegeDiplomas $model
     *
     * @return array
     */
    public function transform(CollegeDiplomas $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

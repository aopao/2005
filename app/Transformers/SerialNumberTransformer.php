<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\SerialNumber;

/**
 * Class SerialNumberTransformer.
 *
 * @package namespace App\Transformers;
 */
class SerialNumberTransformer extends TransformerAbstract
{
    /**
     * Transform the SerialNumber entity.
     *
     * @param \App\Entities\SerialNumber $model
     *
     * @return array
     */
    public function transform(SerialNumber $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

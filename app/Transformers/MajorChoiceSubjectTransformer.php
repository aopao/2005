<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MajorChoiceSubject;

/**
 * Class MajorChoiceSubjectTransformer.
 *
 * @package namespace App\Transformers;
 */
class MajorChoiceSubjectTransformer extends TransformerAbstract
{
    /**
     * Transform the MajorChoiceSubject entity.
     *
     * @param \App\Entities\MajorChoiceSubject $model
     *
     * @return array
     */
    public function transform(MajorChoiceSubject $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

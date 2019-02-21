<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ArticleCategory;

/**
 * Class ArticleCategoryTransformer.
 *
 * @package namespace App\Transformers;
 */
class ArticleCategoryTransformer extends TransformerAbstract
{
    /**
     * Transform the ArticleCategory entity.
     *
     * @param \App\Entities\ArticleCategory $model
     *
     * @return array
     */
    public function transform(ArticleCategory $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

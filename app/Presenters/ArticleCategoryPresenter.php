<?php

namespace App\Presenters;

use App\Transformers\ArticleCategoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ArticleCategoryPresenter.
 *
 * @package namespace App\Presenters;
 */
class ArticleCategoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ArticleCategoryTransformer();
    }
}

<?php

namespace App\Presenters;

use App\Transformers\CollegeCategoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CollegeCategoryPresenter.
 *
 * @package namespace App\Presenters;
 */
class CollegeCategoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CollegeCategoryTransformer();
    }
}

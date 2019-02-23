<?php

namespace App\Presenters;

use App\Transformers\CollegeAttributeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CollegeAttributePresenter.
 *
 * @package namespace App\Presenters;
 */
class CollegeAttributePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CollegeAttributeTransformer();
    }
}

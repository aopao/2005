<?php

namespace App\Presenters;

use App\Transformers\CollegeHasAttributeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CollegeHasAttributePresenter.
 *
 * @package namespace App\Presenters;
 */
class CollegeHasAttributePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CollegeHasAttributeTransformer();
    }
}

<?php

namespace App\Presenters;

use App\Transformers\CollegeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CollegePresenter.
 *
 * @package namespace App\Presenters;
 */
class CollegePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CollegeTransformer();
    }
}

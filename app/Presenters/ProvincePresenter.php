<?php

namespace App\Presenters;

use App\Transformers\ProvinceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProvincePresenter.
 *
 * @package namespace App\Presenters;
 */
class ProvincePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProvinceTransformer();
    }
}

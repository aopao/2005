<?php

namespace App\Presenters;

use App\Transformers\ProvinceControlScoreTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProvinceControlScorePresenter.
 *
 * @package namespace App\Presenters;
 */
class ProvinceControlScorePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProvinceControlScoreTransformer();
    }
}

<?php

namespace App\Presenters;

use App\Transformers\VipCardTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class VipCardPresenter.
 *
 * @package namespace App\Presenters;
 */
class VipCardPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new VipCardTransformer();
    }
}

<?php

namespace App\Presenters;

use App\Transformers\VipTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class VipPresenter.
 *
 * @package namespace App\Presenters;
 */
class VipPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new VipTransformer();
    }
}

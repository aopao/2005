<?php

namespace App\Presenters;

use App\Transformers\MajorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MajorPresenter.
 *
 * @package namespace App\Presenters;
 */
class MajorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MajorTransformer();
    }
}

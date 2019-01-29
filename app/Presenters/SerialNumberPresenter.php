<?php

namespace App\Presenters;

use App\Transformers\SerialNumberTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SerialNumberPresenter.
 *
 * @package namespace App\Presenters;
 */
class SerialNumberPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SerialNumberTransformer();
    }
}

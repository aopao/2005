<?php

namespace App\Presenters;

use App\Transformers\CollegeDiplomasTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CollegeDiplomasPresenter.
 *
 * @package namespace App\Presenters;
 */
class CollegeDiplomasPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CollegeDiplomasTransformer();
    }
}

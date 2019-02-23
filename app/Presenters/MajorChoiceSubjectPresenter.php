<?php

namespace App\Presenters;

use App\Transformers\MajorChoiceSubjectTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MajorChoiceSubjectPresenter.
 *
 * @package namespace App\Presenters;
 */
class MajorChoiceSubjectPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MajorChoiceSubjectTransformer();
    }
}

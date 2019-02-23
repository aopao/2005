<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MajorChoiceSubjectRepository;
use App\Entities\MajorChoiceSubject;
use App\Validators\MajorChoiceSubjectValidator;

/**
 * Class MajorChoiceSubjectRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MajorChoiceSubjectRepositoryEloquent extends BaseRepository implements MajorChoiceSubjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MajorChoiceSubject::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MajorChoiceSubjectValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

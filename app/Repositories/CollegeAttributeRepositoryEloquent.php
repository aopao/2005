<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CollegeAttributeRepository;
use App\Entities\CollegeAttribute;
use App\Validators\CollegeAttributeValidator;

/**
 * Class CollegeAttributeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CollegeAttributeRepositoryEloquent extends BaseRepository implements CollegeAttributeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CollegeAttribute::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CollegeAttributeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

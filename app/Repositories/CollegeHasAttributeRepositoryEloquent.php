<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CollegeHasAttributeRepository;
use App\Entities\CollegeHasAttribute;
use App\Validators\CollegeHasAttributeValidator;

/**
 * Class CollegeHasAttributeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CollegeHasAttributeRepositoryEloquent extends BaseRepository implements CollegeHasAttributeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CollegeHasAttribute::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CollegeHasAttributeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CollegeDiplomasRepository;
use App\Entities\CollegeDiplomas;
use App\Validators\CollegeDiplomasValidator;

/**
 * Class CollegeDiplomasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CollegeDiplomasRepositoryEloquent extends BaseRepository implements CollegeDiplomasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CollegeDiplomas::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CollegeDiplomasValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

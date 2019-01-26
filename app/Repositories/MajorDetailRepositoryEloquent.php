<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MajorDetailRepository;
use App\Entities\MajorDetail;
use App\Validators\MajorDetailValidator;

/**
 * Class MajorDetailRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MajorDetailRepositoryEloquent extends BaseRepository implements MajorDetailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MajorDetail::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

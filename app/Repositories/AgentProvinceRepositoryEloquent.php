<?php

namespace App\Repositories;

use App\Entities\AgentProvince;
use App\Validators\AgentProvinceValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class AgentProvinceRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AgentProvinceRepositoryEloquent extends BaseRepository implements AgentProvinceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AgentProvince::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

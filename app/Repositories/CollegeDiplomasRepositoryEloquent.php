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

    /**
     * Ant desing 所需的分页方法
     *
     * @param $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getAllByPage($request)
    {
        /*判断页数*/
        $pageSize = $request->get('pageSize', 10) != null ? $request->get('pageSize', 10) : 10;
        if (($pageSize % 10 != 0) || $pageSize > 50) {
            return response()->json(['status_code' => '404']);
        }
        /*获取查询参数*/
        $name = $request->get('name', null);

        /*组装查询参数*/
        $sql = $this->model;
        if ($name != null) {
            $sql = $sql->where('name', 'like', '%'.$name.'%');
        }

        /*构造页数参数*/
        $pageNo = $request->get('pageNo', 10) != null ? $request->get('pageNo', 0) : 0;
        $offset = ($pageNo - 1) * $pageSize;
        $totalCount = $sql->count();
        $totalPage = ceil($totalCount / $pageSize);

        /*数据库查询*/
        $data = $sql->skip($offset)->take($pageSize)->get();

        return compact('data', 'pageNo', 'pageSize', 'totalCount', 'totalPage');
    }
}

<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CollegeRepository;
use App\Entities\College;
use App\Validators\CollegeValidator;

/**
 * Class CollegeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CollegeRepositoryEloquent extends BaseRepository implements CollegeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return College::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return CollegeValidator::class;
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
        $is_985 = $request->get('is_985', null);
        $is_211 = $request->get('is_211', null);
        $province_id = $request->get('province_id', null);
        $category_id = $request->get('category_id', null);

        /*组装查询参数*/
        $sql = $this->model;
        if ($name != null) {
            $sql = $sql->where('name', 'like', '%'.$name.'%');
        }
        if ($is_985 != null) {
            $sql = $sql->where('is_985', $is_985);
        }
        if ($is_211 != null) {
            $sql = $sql->where('is_211', $is_211);
        }
        if ($province_id != null) {
            $sql = $sql->where('province_id', $province_id);
        }
        if ($category_id != null) {
            $sql = $sql->where('category_id', $category_id);
        }

        /*构造页数参数*/
        $pageNo = $request->get('pageNo', 10) != null ? $request->get('pageNo', 0) : 0;
        $offset = ($pageNo - 1) * $pageSize;
        $totalCount = $sql->count();
        $totalPage = ceil($totalCount / $pageSize);

        /*数据库查询*/
        $data = $sql->skip($offset)->take($pageSize)
            ->with('collegeDetail', 'collegeCategory', 'collegeDiplomas', 'province')
            ->get();

        return compact('data', 'pageNo', 'pageSize', 'totalCount', 'totalPage');
    }
}

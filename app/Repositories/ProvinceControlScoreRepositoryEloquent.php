<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\ProvinceControlScore;
use App\Validators\ProvinceControlScoreValidator;

/**
 * Class ProvinceControlScoreRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProvinceControlScoreRepositoryEloquent extends BaseRepository implements ProvinceControlScoreRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProvinceControlScore::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return ProvinceControlScoreValidator::class;
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
        $province_id = $request->get('province_id', null);
        $year = $request->get('year', null);
        $subject = $request->get('subject', null);

        /*组装查询参数*/
        $sql = $this->model;
        if ($province_id != null) {
            $sql = $sql->where('province_id', $province_id);
        }

        if ($year != null) {
            $sql = $sql->where('year', $year);
        }

        if ($subject != null) {
            $sql = $sql->where('subject', $subject);
        }

        /*构造页数参数*/
        $pageNo = $request->get('pageNo', 10) != null ? $request->get('pageNo', 0) : 0;
        $offset = ($pageNo - 1) * $pageSize;
        $totalCount = $sql->count();
        $totalPage = ceil($totalCount / $pageSize);

        /*数据库查询*/
        $data = $sql->skip($offset)->take($pageSize)->with('province')->get();

        return compact('data', 'pageNo', 'pageSize', 'totalCount', 'totalPage');
    }
}

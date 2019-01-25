<?php

namespace App\Repositories;

use App\Entities\Admin;
use App\Validators\AdminValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class AdminRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AdminRepositoryEloquent extends BaseRepository implements AdminRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admin::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return AdminValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 根据 guid 获取 Id
     *
     * @param $guid
     * @return mixed
     */
    public function getIdByGuid($guid)
    {
        return $this->model->where('guid', $guid)->first();
    }

    /**
     * 根据 mobile 获取 Id
     *
     * @param $mobile
     * @return mixed
     */
    public function getIdByMobile($mobile)
    {
        return $this->model->where('mobile', $mobile)->first();
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
        $mobile = $request->get('mobile', null);

        /*组装查询参数*/
        $sql = $this->model;
        if ($mobile != null) {
            $sql = $sql->where('mobile', 'like', '%'.$mobile.'%');
        }

        /*构造页数参数*/
        $pageNo = $request->get('pageNo', 10) != null ? $request->get('pageNo', 0) : 0;
        $offset = ($pageNo - 1) * $pageSize;
        $totalCount = $sql->count();
        $totalPage = ceil($totalCount / $pageSize);

        /*数据库查询*/
        $users = $sql->skip($offset)->take($pageSize)->get();

        /*关联用户组*/
        $data = $users->map(function ($user) {
            $item = $user;
            $item['role'] = $user->getRoleNames();

            return $item;
        });

        return compact('data', 'pageNo', 'pageSize', 'totalCount', 'totalPage');
    }
}

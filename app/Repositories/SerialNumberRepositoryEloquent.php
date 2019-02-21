<?php

namespace App\Repositories;

use DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\SerialNumber;
use App\Validators\SerialNumberValidator;

/**
 * Class SerialNumberRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SerialNumberRepositoryEloquent extends BaseRepository implements SerialNumberRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SerialNumber::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return SerialNumberValidator::class;
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
        $number = $request->get('number', null);
        $vip_id = $request->get('vip_id', null);

        /*组装查询参数*/
        $sql = $this->model->orderBy('id', 'desc');
        if ($number != null) {
            $sql = $sql->where('number', 'like', '%'.$number.'%');
        }

        if ($vip_id != null) {
            $sql = $sql->where('vip_id', $vip_id);
        }

        /*构造页数参数*/
        $pageNo = $request->get('pageNo', 10) != null ? $request->get('pageNo', 0) : 0;
        $offset = ($pageNo - 1) * $pageSize;
        $totalCount = $sql->count();
        $totalPage = ceil($totalCount / $pageSize);

        /*数据库查询*/
        $data = $sql->skip($offset)->take($pageSize)->with([
            'admin' => function ($query) {
                $query->select('id', 'nickname');
            },
            'agent' => function ($query) {
                $query->select('id', 'nickname');
            },
            'student' => function ($query) {
                $query->select('id', 'nickname');
            },
            'vip' => function ($query) {
                $query->select('id', 'name');
            },
        ])->get();

        return compact('data', 'pageNo', 'pageSize', 'totalCount', 'totalPage');
    }

    /**
     * 批量插入数据
     *
     * @param array $data
     * @return mixed
     */
    public function addAll(Array $data)
    {
        $new_data = [];
        foreach ($data as $key => $value) {
            date_default_timezone_set('PRC');
            $value['created_at'] = date('Y-m-d H:i:s', time());
            $new_data[] = $value;
        }
        $rs = $this->model->insert($new_data);

        return $rs;
    }
}

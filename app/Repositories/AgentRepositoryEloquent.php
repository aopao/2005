<?php

namespace App\Repositories;

use App\Entities\AgentProvince;
use App\Entities\Province;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Agent;
use App\Validators\AgentValidator;

/**
 * Class AgentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AgentRepositoryEloquent extends BaseRepository implements AgentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Agent::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return AgentValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
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
     * 获取已分配的省份
     *
     * @param $agent_id
     * @return mixed
     */
    public function getControlProvince($agent_id)
    {
        $data = AgentProvince::where('agent_id', $agent_id)->with('province')->get();
        $data = $data->map(function ($item) {
            return $item['province']['name'];
        });

        return $data;
    }

    /**
     * 分配省份
     *
     * @param $data
     * @return bool
     */
    public function batchProvince($data)
    {
        if (count($data['province']) < 1) {
            return true;
        }
        $provinces = Province::whereIn('name', $data['province'])->pluck('id')->toArray();
        AgentProvince::where('agent_id', $data['id'])->delete();
        foreach ($provinces as $value) {
            $item = [
                'agent_id' => $data['id'],
                'province_id' => $value,
            ];
            AgentProvince::firstOrCreate($item);
        }

        return true;
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

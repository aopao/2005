<?php

namespace App\Api\Controllers\Admin;

use App\Entities\Agent;
use Auth;
use Illuminate\Http\Request;
use App\Entities\AgentProvince;
use App\Validators\AgentValidator;
use App\Repositories\AgentRepository;
use App\Http\Requests\AgentCreateRequest;
use App\Http\Requests\AgentUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class AgentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class AgentController extends BaseController
{
    /**
     * @var AgentRepository
     */
    protected $repository;

    /**
     * @var AgentValidator
     */
    protected $validator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * AgentsController constructor.
     *
     * @param AgentRepository          $repository
     * @param AgentValidator           $validator
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(AgentRepository $repository, AgentValidator $validator, Request $request)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->validator = $validator;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $data = $this->repository->getAllByPage($this->request);

        return $this->pageSerializer->collection($data['data'], $data['pageSize'], $pageNo = $data['pageNo'], $totalPage = $data['totalPage'], $totalCount = $data['totalCount']);
    }

    public function getQueryList($agent_id)
    {
        $agent = Agent::where("mobile", 'like', '%'.$agent_id.'%')->get()->toArray();

        return $this->responseFormat->success($agent);
    }

    /**
     * 分配代理商代理已分配的省份
     *
     * @param $agent_id
     * @return array
     */
    public function getControlProvince($agent_id)
    {
        $response = $this->repository->getControlProvince($agent_id);

        return $response ? $this->responseFormat->success($response) : $this->responseFormat->error();
    }

    /**
     * 分配代理商代理的省份
     *
     * @return array
     */
    public function batch()
    {
        $response = $this->repository->batchProvince($this->request->all());

        return $response ? $this->responseFormat->success($message = '分配成功!') : $this->responseFormat->error();
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\AgentCreateRequest $request
     * @return array
     */
    public function store(AgentCreateRequest $request)
    {
        try {

            if ($a = $this->repository->findByField('mobile', $request->get('mobile', null))->first()) {
                return $this->responseFormat->error(201, '手机号已经注册!');
            }

            $admin = $this->repository->create($request->all());

            return $this->responseFormat->success($admin);
        } catch (ModelNotFoundException $e) {

            return $this->responseFormat->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return array|\Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $agent = $this->repository->findByField('id', $id)->first();

        return isset($agent) ? $this->responseFormat->success($agent) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\AgentUpdateRequest $request
     * @param                                       $mobile
     * @return array
     */
    public function update(AgentUpdateRequest $request, $mobile)
    {
        $info = $this->repository->getIdByMobile($mobile);
        if (isset($info)) {
            $data = $request->all();
            //dd($data);
            $this->repository->update($data, $info['id']);

            return $this->responseFormat->success($message = '修改成功!');
        } else {
            return $this->responseFormat->error($message = "修改失败!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        AgentProvince::where('agent_id', $id)->delete();
        $response = $this->repository->deleteWhere(['id' => $id]);

        return $response ? $this->responseFormat->success() : $this->responseFormat->error($message = "删除失败!");
    }
}

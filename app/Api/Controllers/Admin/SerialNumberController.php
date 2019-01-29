<?php

namespace App\Api\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Services\SerialNumberService;
use App\Validators\SerialNumberValidator;
use App\Repositories\SerialNumberRepository;
use App\Transformers\SerialNumberTransformers;
use App\Http\Requests\SerialNumberCreateRequest;
use App\Http\Requests\SerialNumberUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class SerialNumberController.
 *
 * @package namespace App\Http\Controllers;
 */
class SerialNumberController extends BaseController
{
    /**
     * @var SerialNumberRepository
     */
    protected $repository;

    /**
     * @var SerialNumberValidator
     */
    protected $validator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * SerialNumberController constructor.
     *
     * @param SerialNumberRepository   $repository
     * @param SerialNumberValidator    $validator
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(SerialNumberRepository $repository, SerialNumberValidator $validator, Request $request)
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

    /**
     *  Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\SerialNumberCreateRequest   $request
     * @param \App\Api\Controllers\Admin\SerialNumberService $serialNumberService
     * @return array
     */
    public function store(SerialNumberCreateRequest $request, SerialNumberService $serialNumberService)
    {
        try {
            ini_set('memory_limit', '500M');
            set_time_limit(0);//设置超时限制为0分钟
            $id = Auth::guard('admin')->user()->id;
            $data = $serialNumberService->getSerialnunmbers(
                $request->get('sum', 0),
                $is_senior = $request->get('is_senior', 0),
                $admin_id = $id,
                $agent_id = 0,
                $vip_id = $request->get('vip_id', 0),
                $channel = $request->get('channel', 0));

            $this->repository->addAll($data);

            return $this->responseFormat->success();
        } catch (ModelNotFoundException $e) {

            return $this->responseFormat->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $guid
     * @return array|\Dingo\Api\Http\Response
     */
    public function show($guid)
    {
        $admin = $this->repository->findByField('guid', $guid)->first();

        return isset($admin) ? $this->response->item($admin, new SerialNumberTransformers) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\SerialNumberUpdateRequest    $request
     * @param                                                 $id
     * @return array
     */
    public function update(SerialNumberUpdateRequest $request, $id)
    {
        $info = $this->repository->find($id);
        if (isset($info)) {
            $data = $request->only('name', 'description');
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

        $response = $this->repository->deleteWhere(['id' => $id]);

        return $response ? $this->responseFormat->success([]) : $this->responseFormat->error();
    }

    public function profile()
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            $admin->getRoleNames();
            $admin->getAllPermissions();
            $data = $admin->toArray();
            if (isset($data['roles']) && isset($data['roles'][0])) {
                $data['role']['name'] = $data['roles'][0]['display_name'];
                $data['role']['describe'] = $data['roles'][0]['description'];
                $permissions = $data['roles'][0]['permissions'];
                foreach ($permissions as $key => $value) {
                    $item = [];
                    $item['name'] = $value['name'];
                    $item['display_name'] = $value['display_name'];
                    $data['role']['permissions'][] = $item;
                }
            }
            unset($data['roles']);
            $data['avatar'] = './avatar.jpeg';

            return $this->responseFormat->success($data);
        } else {
            $this->responseFormat->error(201, '您还未登录!');
        }
    }
}

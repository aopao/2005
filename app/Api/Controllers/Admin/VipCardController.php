<?php

namespace App\Api\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Validators\VipCardValidator;
use App\Repositories\VipCardRepository;
use App\Transformers\VipCardTransformers;
use App\Http\Requests\VipCardCreateRequest;
use App\Http\Requests\VipCardUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class VipCardController.
 *
 * @package namespace App\Http\Controllers;
 */
class VipCardController extends BaseController
{
    /**
     * @var VipCardRepository
     */
    protected $repository;

    /**
     * @var VipCardValidator
     */
    protected $validator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * VipCardController constructor.
     *
     * @param VipCardRepository        $repository
     * @param VipCardValidator         $validator
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(VipCardRepository $repository, VipCardValidator $validator, Request $request)
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
     * 获取下拉列表中的值
     *
     * @return array
     */
    public function optionList()
    {
        return $this->responseFormat->success($this->repository->all(['id', 'name']));
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\VipCardCreateRequest $request
     * @return array
     */
    public function store(VipCardCreateRequest $request)
    {
        try {

            if ($a = $this->repository->findByField('name', $request->get('name', null))->first()) {
                return $this->responseFormat->error(201, '此VIP服务卡已经添加啦!');
            }

            $response = $this->repository->create($request->all());

            return $this->responseFormat->success($response);
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
        $data = $this->repository->find($id);

        return isset($data) ? $this->responseFormat->success($data) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\VipCardUpdateRequest         $request
     * @param                                                 $id
     * @return array
     */
    public function update(VipCardUpdateRequest $request, $id)
    {
        $info = $this->repository->find($id);
        if (isset($info)) {
            $data = $request->all();
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

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
        $response = $this->repository->getAllByPage($this->request);

        return $this->pageSerializer->collection($response['data'], $response['pageSize'], $pageNo = $response['pageNo'], $totalPage = $response['totalPage'], $totalCount = $response['totalCount']);
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

            if ($this->repository->findByField('name', $request->get('name', null))->first()) {
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
        $response = $this->repository->find($id);

        return isset($response) ? $this->responseFormat->success($response) : $this->responseFormat->error();
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
}

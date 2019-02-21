<?php

namespace App\Api\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Validators\MajorValidator;
use App\Repositories\MajorRepository;
use App\Transformers\MajorTransformers;
use App\Http\Requests\MajorCreateRequest;
use App\Http\Requests\MajorUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class MajorController.
 *
 * @package namespace App\Http\Controllers;
 */
class MajorController extends BaseController
{
    /**
     * @var MajorRepository
     */
    protected $repository;

    /**
     * @var MajorValidator
     */
    protected $validator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * MajorController constructor.
     *
     * @param MajorRepository          $repository
     * @param MajorValidator           $validator
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(MajorRepository $repository, MajorValidator $validator, Request $request)
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
     * 获取层级 Option
     */
    public function levelOptionList()
    {
        $response = $this->repository->levelOptionList();

        return isset($response) ? $this->responseFormat->success($response) : $this->responseFormat->error();
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\MajorCreateRequest $request
     * @return array
     */
    public function store(MajorCreateRequest $request)
    {
        $response = $this->repository->createMajor($request->all());

        return isset($response) ? $this->responseFormat->success() : $this->responseFormat->error();
    }

    /**
     * Display the specified resource.
     *
     * @param $guid
     * @return array|\Dingo\Api\Http\Response
     */
    public function show($guid)
    {
        $response = $this->repository->findByField('guid', $guid)->first();

        return isset($response) ? $this->response->item($response, new MajorTransformers) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\MajorUpdateRequest           $request
     * @param                                                 $id
     * @return array
     */
    public function update(MajorUpdateRequest $request, $id)
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
}

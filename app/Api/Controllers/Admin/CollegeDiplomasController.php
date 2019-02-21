<?php

namespace App\Api\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Validators\CollegeDiplomasValidator;
use App\Repositories\CollegeDiplomasRepository;
use App\Transformers\CollegeDiplomasTransformers;
use App\Http\Requests\CollegeDiplomasCreateRequest;
use App\Http\Requests\CollegeDiplomasUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class CollegeDiplomasController.
 *
 * @package namespace App\Http\Controllers;
 */
class CollegeDiplomasController extends BaseController
{
    /**
     * @var CollegeDiplomasRepository
     */
    protected $repository;

    /**
     * @var CollegeDiplomasValidator
     */
    protected $validator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * CollegeDiplomasController constructor.
     *
     * @param CollegeDiplomasRepository $repository
     * @param CollegeDiplomasValidator  $validator
     * @param \Illuminate\Http\Request  $request
     */
    public function __construct(CollegeDiplomasRepository $repository, CollegeDiplomasValidator $validator, Request $request)
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
     *  Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CollegeDiplomasCreateRequest $request
     * @return array
     */
    public function store(CollegeDiplomasCreateRequest $request)
    {
        try {

            if ($this->repository->findByField('name', $request->get('name', null))->first()) {
                return $this->responseFormat->error(201, '此院校层次已经添加啦!');
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
     * @param $guid
     * @return array|\Dingo\Api\Http\Response
     */
    public function show($guid)
    {
        $response = $this->repository->findByField('guid', $guid)->first();

        return isset($response) ? $this->response->item($response, new CollegeDiplomasTransformers) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\CollegeDiplomasUpdateRequest $request
     * @param                                                 $id
     * @return array
     */
    public function update(CollegeDiplomasUpdateRequest $request, $id)
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

<?php

namespace App\Api\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Validators\ArticleCategoryValidator;
use App\Repositories\ArticleCategoryRepository;
use App\Transformers\ArticleCategoryTransformers;
use App\Http\Requests\ArticleCategoryCreateRequest;
use App\Http\Requests\ArticleCategoryUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ArticleCategoryController.
 *
 * @package namespace App\Http\Controllers;
 */
class ArticleCategoryController extends BaseController
{
    /**
     * @var ArticleCategoryRepository
     */
    protected $repository;

    /**
     * @var ArticleCategoryValidator
     */
    protected $validator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * ArticleCategoryController constructor.
     *
     * @param ArticleCategoryRepository $repository
     * @param ArticleCategoryValidator  $validator
     * @param \Illuminate\Http\Request  $request
     */
    public function __construct(ArticleCategoryRepository $repository, ArticleCategoryValidator $validator, Request $request)
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
     * 层级分类
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function optionList()
    {
        $data = $this->repository->getOptionList();

        return $this->responseFormat->success($data);
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ArticleCategoryCreateRequest $request
     * @return array
     */
    public function store(ArticleCategoryCreateRequest $request)
    {
        try {
            $response = $this->repository->create($request->only(['name', 'parent_id', 'description']));

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

        return isset($response) ? $this->response->item($response, new ArticleCategoryTransformers) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ArticleCategoryUpdateRequest $request
     * @param                                                 $id
     * @return array
     */
    public function update(ArticleCategoryUpdateRequest $request, $id)
    {
        $info = $this->repository->find($id);
        if (isset($info)) {
            $data = $request->only('name', 'description');
            $this->repository->update($data, $info['id']);

            return $this->responseFormat->success($type = 'edit');
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

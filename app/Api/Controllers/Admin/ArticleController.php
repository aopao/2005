<?php

namespace App\Api\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Services\UploadServices;
use App\Validators\ArticleValidator;
use App\Repositories\ArticleRepository;
use App\Transformers\ArticleTransformers;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ArticleController.
 *
 * @package namespace App\Http\Controllers;
 */
class ArticleController extends BaseController
{
    /**
     * @var ArticleRepository
     */
    protected $repository;

    /**
     * @var ArticleValidator
     */
    protected $validator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * ArticleController constructor.
     *
     * @param ArticleRepository        $repository
     * @param ArticleValidator         $validator
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(ArticleRepository $repository, ArticleValidator $validator, Request $request)
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
     * 上传缩略图
     *
     * @param \Illuminate\Http\Request                  $request
     * @param \App\Api\Controllers\Admin\UploadServices $uploadServices
     * @return array
     */
    public function UploadThumb(Request $request, UploadServices $uploadServices)
    {
        $file = $uploadServices->updateStore($request, 'article', ['jpeg', 'jpg', 'png', 'gif']);
        if ($file == 203) {
            return $this->responseFormat->error('请上传图片格式文件!', 203);
        }

        return $this->responseFormat->success(['file' => $file]);
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ArticleCreateRequest $request
     * @return array
     */
    public function store(ArticleCreateRequest $request)
    {
        try {
            $data = $request->all();
            $data['admin_id'] = Auth::guard('admin')->user()->id;
            $response = $this->repository->create($data);

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

        return isset($response) ? $this->response->item($response, new ArticleTransformers) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ArticleUpdateRequest         $request
     * @param                                                 $id
     * @return array
     */
    public function update(ArticleUpdateRequest $request, $id)
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

<?php

namespace App\Api\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Validators\CollegeCategoryValidator;
use App\Repositories\CollegeCategoryRepository;
use App\Transformers\CollegeCategoryTransformers;
use App\Http\Requests\CollegeCategoryCreateRequest;
use App\Http\Requests\CollegeCategoryUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class CollegeCategoryController.
 *
 * @package namespace App\Http\Controllers;
 */
class CollegeCategoryController extends BaseController
{
    /**
     * @var CollegeCategoryRepository
     */
    protected $repository;

    /**
     * @var CollegeCategoryValidator
     */
    protected $validator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * CollegeCategoryController constructor.
     *
     * @param CollegeCategoryRepository $repository
     * @param CollegeCategoryValidator  $validator
     * @param \Illuminate\Http\Request  $request
     */
    public function __construct(CollegeCategoryRepository $repository, CollegeCategoryValidator $validator, Request $request)
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
     * @param \App\Http\Requests\CollegeCategoryCreateRequest $request
     * @return array
     */
    public function store(CollegeCategoryCreateRequest $request)
    {
        try {

            if ($a = $this->repository->findByField('name', $request->get('name', null))->first()) {
                return $this->responseFormat->error(201, '此院校类型已经添加啦!');
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
        $admin = $this->repository->findByField('guid', $guid)->first();

        return isset($admin) ? $this->response->item($admin, new CollegeCategoryTransformers) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\CollegeCategoryUpdateRequest $request
     * @param                                                 $id
     * @return array
     */
    public function update(CollegeCategoryUpdateRequest $request, $id)
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

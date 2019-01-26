<?php

namespace App\Api\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Validators\ProvincecontrolScoreValidator;
use App\Repositories\ProvincecontrolScoreRepository;
use App\Transformers\ProvincecontrolScoreTransformers;
use App\Http\Requests\ProvincecontrolScoreCreateRequest;
use App\Http\Requests\ProvincecontrolScoreUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ProvincecontrolScoreController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProvinceControlScoreController extends BaseController
{
    /**
     * @var ProvincecontrolScoreRepository
     */
    protected $repository;

    /**
     * @var ProvincecontrolScoreValidator
     */
    protected $validator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * ProvincecontrolScoreController constructor.
     *
     * @param ProvincecontrolScoreRepository $repository
     * @param ProvincecontrolScoreValidator  $validator
     * @param \Illuminate\Http\Request        $request
     */
    public function __construct(ProvincecontrolScoreRepository $repository, ProvincecontrolScoreValidator $validator, Request $request)
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
     * @param \App\Http\Requests\ProvincecontrolScoreCreateRequest $request
     * @return array
     */
    public function store(ProvincecontrolScoreCreateRequest $request)
    {
        try {

            if ($a = $this->repository->findByField('name', $request->get('name', null))->first()) {
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
        $admin = $this->repository->findByField('guid', $guid)->first();

        return isset($admin) ? $this->response->item($admin, new ProvincecontrolScoreTransformers) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ProvincecontrolScoreUpdateRequest $request
     * @param                                                       $id
     * @return array
     */
    public function update(ProvincecontrolScoreUpdateRequest $request, $id)
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

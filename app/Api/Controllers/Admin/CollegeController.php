<?php

namespace App\Api\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Validators\CollegeValidator;
use App\Repositories\CollegeRepository;
use App\Transformers\CollegeTransformers;
use App\Http\Requests\CollegeCreateRequest;
use App\Http\Requests\CollegeUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class CollegeController.
 *
 * @package namespace App\Http\Controllers;
 */
class CollegeController extends BaseController
{
    /**
     * @var CollegeRepository
     */
    protected $repository;

    /**
     * @var CollegeValidator
     */
    protected $validator;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * CollegeController constructor.
     *
     * @param CollegeRepository        $repository
     * @param CollegeValidator         $validator
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(CollegeRepository $repository, CollegeValidator $validator, Request $request)
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
     * @param \App\Http\Requests\CollegeCreateRequest $request
     * @return array
     */
    public function store(CollegeCreateRequest $request)
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
     * @param $guid
     * @return array|\Dingo\Api\Http\Response
     */
    public function show($guid)
    {
        $admin = $this->repository->findByField('guid', $guid)->first();

        return isset($admin) ? $this->response->item($admin, new CollegeTransformers) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\CollegeUpdateRequest $request
     * @param                                         $mobile
     * @return array
     */
    public function update(CollegeUpdateRequest $request, $mobile)
    {
        $info = $this->repository->getIdByMobile($mobile);
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
     * @param $mobile
     * @return array
     */
    public function destroy($mobile)
    {

        $response = $this->repository->deleteWhere(['mobile' => $mobile]);

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

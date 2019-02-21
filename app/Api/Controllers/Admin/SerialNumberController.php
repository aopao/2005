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
        $response = $this->repository->getAllByPage($this->request);

        return $this->pageSerializer->collection($response['data'], $response['pageSize'], $pageNo = $response['pageNo'], $totalPage = $response['totalPage'], $totalCount = $response['totalCount']);
    }

    public function batchSerialNumber(Request $request)
    {
        $ids = $request->get('serialNumber_id');
        foreach ($ids as $id) {
            $data = $this->repository->findWhere(['id' => $id, 'agent_id' => 0], ['id'])->toArray();
            if (! empty($data)) {
                $this->repository->update(['agent_id' => $request->get('agent_id', 0)], $id);
            }
        }

        return $this->responseFormat->success();
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
        $response = $this->repository->findByField('guid', $guid)->first();

        return isset($response) ? $this->response->item($response, new SerialNumberTransformers) : $this->responseFormat->error();
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
}

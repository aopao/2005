<?php

namespace App\Api\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Services\UploadServices;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProvinceControlScoreImport;
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
     * @param \Illuminate\Http\Request       $request
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
        $response = $this->repository->getAllByPage($this->request);

        return $this->pageSerializer->collection($response['data'], $response['pageSize'], $pageNo = $response['pageNo'], $totalPage = $response['totalPage'], $totalCount = $response['totalCount']);
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

            $res = $this->repository->findWhere(
                [
                    'year' => $request->get('year', null),
                    'province_id' => $request->get('province_id', null),
                    'subject' => $request->get('subject', null),
                    'batch' => $request->get('batch', null),
                ])->first();
            if ($res) {
                return $this->responseFormat->error(201, '此省控线数据已经添加啦!');
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

        return isset($response) ? $this->response->item($response, new ProvincecontrolScoreTransformers) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ProvincecontrolScoreUpdateRequest  $request
     * @param                                                       $id
     * @return array
     */
    public function update(ProvincecontrolScoreUpdateRequest $request, $id)
    {
        $response = $this->repository->update($request->all(), $id);

        return isset($response) ? $this->responseFormat->success() : $this->responseFormat->error();
    }

    public function ControlScoreUpload(Request $request, UploadServices $uploadServices)
    {
        $file = $uploadServices->updateStore($request, 'temp');
        if ($file == 203) {
            return $this->responseFormat->error('请上传Excel格式文件!', 203);
        }
        Excel::import(new ProvinceControlScoreImport(), $file, 'public');

        return $file;
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

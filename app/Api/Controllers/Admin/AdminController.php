<?php

namespace App\Api\Controllers\Admin;

use App\Validators\AdminValidator;
use App\Repositories\AdminRepository;
use App\Http\Requests\AdminCreateRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Transformers\AdminTransformers;
use Prettus\Validator\Contracts\ValidatorInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class AdminsController.
 *
 * @package namespace App\Http\Controllers;
 */
class AdminController extends BaseController
{
    /**
     * @var AdminRepository
     */
    protected $repository;

    /**
     * @var AdminValidator
     */
    protected $validator;

    /**
     * AdminsController constructor.
     *
     * @param AdminRepository $repository
     * @param AdminValidator  $validator
     */
    public function __construct(AdminRepository $repository, AdminValidator $validator)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $data = $this->repository->all();

        return $this->response->collection($data, new AdminTransformers);
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\AdminCreateRequest $request
     * @return array
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AdminCreateRequest $request)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
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

        return isset($admin) ? $this->response->item($admin, new AdminTransformers) : $this->responseFormat->error();
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param \App\Http\Requests\AdminUpdateRequest $request
     * @param                                       $guid
     * @return array
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(AdminUpdateRequest $request, $guid)
    {
        $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $info = $this->repository->getIdByGuid($guid);
        if (isset($info)) {
            $this->repository->update($request->all(), $info['id']);

            return $this->responseFormat->success([]);
        } else {
            return $this->responseFormat->error();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $guid
     * @return array
     */
    public function destroy($guid)
    {

        $response = $this->repository->deleteWhere(['guid' => $guid]);

        return $response ? $this->responseFormat->success([]) : $this->responseFormat->error();
    }
}

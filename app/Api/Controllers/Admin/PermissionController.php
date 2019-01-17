<?php

namespace App\Api\Controllers\Admin;

use Spatie\Permission\Models\Permission;
use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;

/**
 * Class PermissionsController.
 *
 * @package namespace App\Http\Controllers;
 */
class PermissionController extends BaseController
{
    /**
     * @var PermissionRepository
     */
    protected $model;

    /**
     * PermissionsController constructor.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        parent::__construct();
        $this->model = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->model->all();

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PermissionCreateRequest $request
     * @return array
     */
    public function store(PermissionCreateRequest $request)
    {
        $response = $this->model->create($request->all());

        return $response ? $this->responseFormat->success() : $this->responseFormat->error();
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        $response = $this->model->find($id);

        return $response ? $this->responseFormat->success() : $this->responseFormat->error();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\PermissionUpdateRequest $request
     * @param                                            $id
     * @return array
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        $response = $this->model->where('id', $id)->update($request->all());

        return $response ? $this->responseFormat->success([]) : $this->responseFormat->error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return array
     */
    public function destroy($id)
    {
        $response = $this->model->destroy($id);

        return $response ? $this->responseFormat->success([]) : $this->responseFormat->error();
    }
}

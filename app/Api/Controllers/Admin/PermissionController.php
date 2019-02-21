<?php

namespace App\Api\Controllers\Admin;

use Auth;
use App\Entities\RoleHasPermission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
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
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        /*判断页数*/
        $pageSize = $request->get('pageSize', 10) != null ? $request->get('pageSize', 10) : 10;
        if (($pageSize % 10 != 0) || $pageSize > 50) {
            return response()->json(['status_code' => '404']);
        }
        /*获取查询参数*/
        $display_name = $request->get('display_name', null);

        /*组装查询参数*/
        $sql = $this->model;
        if ($display_name != null) {
            $sql = $sql->where('display_name', 'like', '%'.$display_name.'%');
        }

        /*构造页数参数*/
        $pageNo = $request->get('pageNo', 10) != null ? $request->get('pageNo', 0) : 0;
        $offset = ($pageNo - 1) * $pageSize;
        $totalCount = $sql->count();
        $totalPage = ceil($totalCount / $pageSize);

        /*数据库查询*/
        $data = $sql->skip($offset)->take($pageSize)->get();

        return $this->pageSerializer->collection($data, $pageSize, $pageNo, $totalPage, $totalCount);
    }

    /**
     * 返回全部的权限列表
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function optionList(Request $request)
    {
        $guard_name = $request->only('guard_name');
        $data = $this->model->where('guard_name', $guard_name)->get();
        $data = $data->map(function ($item) {
            $node = [];
            $node['label'] = $item['display_name'];
            $node['value'] = $item['name'];

            return $node;
        });

        return $data;
    }

    public function controlOptionList(Request $request, Permission $permission, Role $role, RoleHasPermission $roleHasPermission)
    {

        $role_id = $request->get('role_id', null);
        $role_model = $role->where('id', $role_id)->first();
        $data = $roleHasPermission->where('role_id', $role_model->id)->get();
        $data = $data->map(function ($item) {
            return $item['permission_id'];
        });

        $permission_id = [];
        foreach ($data as $item) {
            $permission_id[] = $item;
        }

        $data = $permission->whereIn('id', $permission_id)->pluck('name');
        $permissions = [];
        foreach ($data as $item) {
            $permissions[] = $item;
        }

        return $this->responseFormat->success($permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PermissionCreateRequest $request
     * @return array
     */
    public function store(PermissionCreateRequest $request)
    {
        $response = $this->model->create($request->only('name', 'display_name', 'guard_name'));

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

        return $response ? $this->responseFormat->success($response) : $this->responseFormat->error();
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

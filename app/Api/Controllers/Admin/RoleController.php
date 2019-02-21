<?php

namespace App\Api\Controllers\Admin;

use Illuminate\Http\Request;
use App\Validators\RoleValidator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;

/**
 * Class RolesController.
 *
 * @package namespace App\Http\Controllers;
 */
class RoleController extends BaseController
{
    /**
     * @var RoleRepository
     */
    protected $model;

    /**
     * @var \Spatie\Permission\Models\Permission
     */
    private $permission;

    /**
     * RolesController constructor.
     *
     * @param Role                                 $role
     * @param \Spatie\Permission\Models\Permission $permission
     */
    public function __construct(Role $role, Permission $permission)
    {
        parent::__construct();
        $this->model = $role;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
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
        $guard_name = $request->get('guard_name', null);

        /*组装查询参数*/
        $sql = $this->model->where('guard_name', $guard_name);
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

        return $data ? $this->pageSerializer->collection($data, $pageSize, $pageNo, $totalPage, $totalCount) : $this->responseFormat->error();
    }

    /**
     * 层级分类
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function optionList(Request $request)
    {
        $guard_name = $request->only('guard_name');
        $data = $this->model->where('guard_name', $guard_name)->get();
        $data = $data->map(function ($item) {
            $node = [];
            $node['id'] = $item['name'];
            $node['name'] = $item['display_name'];

            return $node;
        });

        return $this->responseFormat->success($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\RoleCreateRequest $request
     * @return array
     */
    public function store(RoleCreateRequest $request)
    {
        $response = $this->model->create($request->only(['name', 'display_name', 'guard_name']));

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
        $response = $this->model->select('id', 'display_name', 'name')->find($id);

        return $response ? $this->responseFormat->success($response) : $this->responseFormat->error();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\RoleUpdateRequest $request
     * @param                                      $id
     * @return array
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $response = $this->model->where('id', $id)->update($request->all());

        return $response ? $this->responseFormat->success([]) : $this->responseFormat->error();
    }

    /**
     * 给角色组分配权限
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function givePermission(Request $request)
    {
        try {
            $id = $request->get('id', null);
            $role = $this->model->where('id', $id)->first();

            if (! $role) {
                return $this->responseFormat->error();
            }

            $permissions = $request->get('permission', null);
            $response = $role->syncPermissions($permissions);

            return $response ? $this->responseFormat->success([]) : $this->responseFormat->error();
        } catch (ModelNotFoundException $e) {

            return $this->responseFormat->error();
        }
    }

    /**
     * 给用户分配角色
     *
     * @param \Illuminate\Http\Request          $request
     * @param \App\Repositories\AdminRepository $adminRepository
     * @return array
     */
    public function giveUser(Request $request, AdminRepository $adminRepository)
    {
        $type = $request->get('type', 'admin');
        $guid = $request->get('guid', null);
        $role = $request->get('role', null);

        switch ($type) {
            case 'admin':
                $admin = $adminRepository->findByField('guid', $guid)->first();
                if (! $admin) {
                    return $this->responseFormat->error();
                }
                $response = $admin->syncRoles($role);

                return $response ? $this->responseFormat->success([]) : $this->responseFormat->error();
            case 'agent':
                //TODO-LIST
                break;
            case 'student':
                //TODO-LIST
                break;
        }

        return $this->responseFormat->error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $response = $this->model->destroy($id);

        return $response ? $this->responseFormat->success([]) : $this->responseFormat->error();
    }
}

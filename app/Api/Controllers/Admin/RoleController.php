<?php

namespace App\Api\Controllers\Admin;

use App\Repositories\AdminRepository;
use App\Validators\RoleValidator;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->model->all();

        return response()->json([
            'data' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\RoleCreateRequest $request
     * @return array
     */
    public function store(RoleCreateRequest $request)
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
     * @param \Illuminate\Http\Request             $request
     * @param \Spatie\Permission\Models\Permission $permission
     * @return array
     */
    public function givePermission(Request $request, Permission $permission)
    {
        try {
            $id = $request->get('id', null);
            $role = $this->model->where('id', $id)->first();

            if (! $role) {
                return $this->responseFormat->error();
            }

            $permissionList = $request->get('permissions_id', null);
            $permissions = $permission->whereIn('name', $permissionList)->get();
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

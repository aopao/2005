<?php

namespace App\Api\Controllers\Admin;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends BaseController
{
    use AuthenticatesUsers;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * AuthController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    /**
     * Login Method
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $data = $this->request->all();
        if (! $token = Auth::guard('admin')->attempt($data)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            $admin = Auth::guard('admin')->user()->toArray();

            return $this->respondWithToken($admin, $token);
        }
    }

    /**
     * Logout Method
     */
    public function logout()
    {
        //token注销
        //JWTAuth::invalidate(JWTAuth::getToken());
        //
        //return response()->json([
        //    'code' => '200',
        //]);
    }

    public function guard()
    {
        return JWTAuth::guard();
    }

    public function me()
    {

        $str = '{"message":"","result":{"id":"4291d7da9005377ec9aec4a71ea837f","name":"卡布奇诺","username":"admin","password":"","avatar":"/avatar2.jpg","status":1,"telephone":"","lastLoginIp":"27.154.74.117","lastLoginTime":1534837621348,"creatorId":"admin","createTime":1497160610259,"merchantCode":"TLif2btpzg079h15bk","deleted":0,"roleId":"admin","role":{"id":"admin","name":"管理员","describe":"拥有所有权限","status":1,"creatorId":"system","createTime":1497160610259,"deleted":0,"permissions":[{"roleId":"admin","permissionId":"dashboard","permissionName":"仪表盘","actions":"[{\"action\":\"add\",\"defaultCheck\":false,\"describe\":\"新增\"},{\"action\":\"query\",\"defaultCheck\":false,\"describe\":\"查询\"},{\"action\":\"get\",\"defaultCheck\":false,\"describe\":\"详情\"},{\"action\":\"update\",\"defaultCheck\":false,\"describe\":\"修改\"},{\"action\":\"delete\",\"defaultCheck\":false,\"describe\":\"删除\"}]","actionEntitySet":[{"action":"add","describe":"新增","defaultCheck":false},{"action":"query","describe":"查询","defaultCheck":false},{"action":"get","describe":"详情","defaultCheck":false},{"action":"update","describe":"修改","defaultCheck":false},{"action":"delete","describe":"删除","defaultCheck":false}],"actionList":null,"dataAccess":null},{"roleId":"admin","permissionId":"exception","permissionName":"异常页面权限","actions":"[{\"action\":\"add\",\"defaultCheck\":false,\"describe\":\"新增\"},{\"action\":\"query\",\"defaultCheck\":false,\"describe\":\"查询\"},{\"action\":\"get\",\"defaultCheck\":false,\"describe\":\"详情\"},{\"action\":\"update\",\"defaultCheck\":false,\"describe\":\"修改\"},{\"action\":\"delete\",\"defaultCheck\":false,\"describe\":\"删除\"}]","actionEntitySet":[{"action":"add","describe":"新增","defaultCheck":false},{"action":"query","describe":"查询","defaultCheck":false},{"action":"get","describe":"详情","defaultCheck":false},{"action":"update","describe":"修改","defaultCheck":false},{"action":"delete","describe":"删除","defaultCheck":false}],"actionList":null,"dataAccess":null},{"roleId":"admin","permissionId":"result","permissionName":"结果权限","actions":"[{\"action\":\"add\",\"defaultCheck\":false,\"describe\":\"新增\"},{\"action\":\"query\",\"defaultCheck\":false,\"describe\":\"查询\"},{\"action\":\"get\",\"defaultCheck\":false,\"describe\":\"详情\"},{\"action\":\"update\",\"defaultCheck\":false,\"describe\":\"修改\"},{\"action\":\"delete\",\"defaultCheck\":false,\"describe\":\"删除\"}]","actionEntitySet":[{"action":"add","describe":"新增","defaultCheck":false},{"action":"query","describe":"查询","defaultCheck":false},{"action":"get","describe":"详情","defaultCheck":false},{"action":"update","describe":"修改","defaultCheck":false},{"action":"delete","describe":"删除","defaultCheck":false}],"actionList":null,"dataAccess":null},{"roleId":"admin","permissionId":"profile","permissionName":"详细页权限","actions":"[{\"action\":\"add\",\"defaultCheck\":false,\"describe\":\"新增\"},{\"action\":\"query\",\"defaultCheck\":false,\"describe\":\"查询\"},{\"action\":\"get\",\"defaultCheck\":false,\"describe\":\"详情\"},{\"action\":\"update\",\"defaultCheck\":false,\"describe\":\"修改\"},{\"action\":\"delete\",\"defaultCheck\":false,\"describe\":\"删除\"}]","actionEntitySet":[{"action":"add","describe":"新增","defaultCheck":false},{"action":"query","describe":"查询","defaultCheck":false},{"action":"get","describe":"详情","defaultCheck":false},{"action":"update","describe":"修改","defaultCheck":false},{"action":"delete","describe":"删除","defaultCheck":false}],"actionList":null,"dataAccess":null},{"roleId":"admin","permissionId":"table","permissionName":"表格权限","actions":"[{\"action\":\"add\",\"defaultCheck\":false,\"describe\":\"新增\"},{\"action\":\"import\",\"defaultCheck\":false,\"describe\":\"导入\"},{\"action\":\"get\",\"defaultCheck\":false,\"describe\":\"详情\"},{\"action\":\"update\",\"defaultCheck\":false,\"describe\":\"修改\"}]","actionEntitySet":[{"action":"add","describe":"新增","defaultCheck":false},{"action":"import","describe":"导入","defaultCheck":false},{"action":"get","describe":"详情","defaultCheck":false},{"action":"update","describe":"修改","defaultCheck":false}],"actionList":null,"dataAccess":null},{"roleId":"admin","permissionId":"form","permissionName":"表单权限","actions":"[{\"action\":\"add\",\"defaultCheck\":false,\"describe\":\"新增\"},{\"action\":\"get\",\"defaultCheck\":false,\"describe\":\"详情\"},{\"action\":\"query\",\"defaultCheck\":false,\"describe\":\"查询\"},{\"action\":\"update\",\"defaultCheck\":false,\"describe\":\"修改\"},{\"action\":\"delete\",\"defaultCheck\":false,\"describe\":\"删除\"}]","actionEntitySet":[{"action":"add","describe":"新增","defaultCheck":false},{"action":"get","describe":"详情","defaultCheck":false},{"action":"query","describe":"查询","defaultCheck":false},{"action":"update","describe":"修改","defaultCheck":false},{"action":"delete","describe":"删除","defaultCheck":false}],"actionList":null,"dataAccess":null},{"roleId":"admin","permissionId":"order","permissionName":"订单管理","actions":"[{\"action\":\"add\",\"defaultCheck\":false,\"describe\":\"新增\"},{\"action\":\"query\",\"defaultCheck\":false,\"describe\":\"查询\"},{\"action\":\"get\",\"defaultCheck\":false,\"describe\":\"详情\"},{\"action\":\"update\",\"defaultCheck\":false,\"describe\":\"修改\"},{\"action\":\"delete\",\"defaultCheck\":false,\"describe\":\"删除\"}]","actionEntitySet":[{"action":"add","describe":"新增","defaultCheck":false},{"action":"query","describe":"查询","defaultCheck":false},{"action":"get","describe":"详情","defaultCheck":false},{"action":"update","describe":"修改","defaultCheck":false},{"action":"delete","describe":"删除","defaultCheck":false}],"actionList":null,"dataAccess":null},{"roleId":"admin","permissionId":"permission","permissionName":"权限管理","actions":"[{\"action\":\"add\",\"defaultCheck\":false,\"describe\":\"新增\"},{\"action\":\"get\",\"defaultCheck\":false,\"describe\":\"详情\"},{\"action\":\"update\",\"defaultCheck\":false,\"describe\":\"修改\"},{\"action\":\"delete\",\"defaultCheck\":false,\"describe\":\"删除\"}]","actionEntitySet":[{"action":"add","describe":"新增","defaultCheck":false},{"action":"get","describe":"详情","defaultCheck":false},{"action":"update","describe":"修改","defaultCheck":false},{"action":"delete","describe":"删除","defaultCheck":false}],"actionList":null,"dataAccess":null},{"roleId":"admin","permissionId":"role","permissionName":"角色管理","actions":"[{\"action\":\"add\",\"defaultCheck\":false,\"describe\":\"新增\"},{\"action\":\"get\",\"defaultCheck\":false,\"describe\":\"详情\"},{\"action\":\"update\",\"defaultCheck\":false,\"describe\":\"修改\"},{\"action\":\"delete\",\"defaultCheck\":false,\"describe\":\"删除\"}]","actionEntitySet":[{"action":"add","describe":"新增","defaultCheck":false},{"action":"get","describe":"详情","defaultCheck":false},{"action":"update","describe":"修改","defaultCheck":false},{"action":"delete","describe":"删除","defaultCheck":false}],"actionList":null,"dataAccess":null},{"roleId":"admin","permissionId":"table","permissionName":"桌子管理","actions":"[{\"action\":\"add\",\"defaultCheck\":false,\"describe\":\"新增\"},{\"action\":\"get\",\"defaultCheck\":false,\"describe\":\"详情\"},{\"action\":\"query\",\"defaultCheck\":false,\"describe\":\"查询\"},{\"action\":\"update\",\"defaultCheck\":false,\"describe\":\"修改\"},{\"action\":\"delete\",\"defaultCheck\":false,\"describe\":\"删除\"}]","actionEntitySet":[{"action":"add","describe":"新增","defaultCheck":false},{"action":"get","describe":"详情","defaultCheck":false},{"action":"query","describe":"查询","defaultCheck":false},{"action":"update","describe":"修改","defaultCheck":false},{"action":"delete","describe":"删除","defaultCheck":false}],"actionList":null,"dataAccess":null},{"roleId":"admin","permissionId":"user","permissionName":"用户管理","actions":"[{\"action\":\"add\",\"defaultCheck\":false,\"describe\":\"新增\"},{\"action\":\"import\",\"defaultCheck\":false,\"describe\":\"导入\"},{\"action\":\"get\",\"defaultCheck\":false,\"describe\":\"详情\"},{\"action\":\"update\",\"defaultCheck\":false,\"describe\":\"修改\"},{\"action\":\"delete\",\"defaultCheck\":false,\"describe\":\"删除\"},{\"action\":\"export\",\"defaultCheck\":false,\"describe\":\"导出\"}]","actionEntitySet":[{"action":"add","describe":"新增","defaultCheck":false},{"action":"import","describe":"导入","defaultCheck":false},{"action":"get","describe":"详情","defaultCheck":false},{"action":"update","describe":"修改","defaultCheck":false},{"action":"delete","describe":"删除","defaultCheck":false},{"action":"export","describe":"导出","defaultCheck":false}],"actionList":null,"dataAccess":null}]}},"status":200,"timestamp":1534844188679}';
        //$admin = Auth::guard('admin_api')->user()->toArray();
        //$data = $this->dataSerializer->collection($admin);
        return response()->json(json_decode($str));
    }

    /**
     * Get the token array structure.
     *
     * @param         $admin
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($admin, $token)
    {
        if (isset($admin['id'])) {
            unset($admin['id']);
        }
        $data = $this->responseFormat->success($admin);
        $data['access_token'] = 'Bearer '.$token;

        return response()->json($data);
    }
}